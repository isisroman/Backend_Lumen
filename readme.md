# Lumen (BACKEND) API Restful 
Este proyecto esta generado con (Lumen 5.7.6) (Laravel Components 5.7.*)

# Empezar desde aquí
1. Es necesario tener instalado [XAMPP](https://www.apachefriends.org/download.html) integrado Apache, PhpMyAdmin para la base de datos, y un Editor [PhpStorm](https://www.jetbrains.com/phpstorm/download/)(o cualquier otro Editor en ph).



2. En una carpeta de nuestro sistema donde vamos a crear el proyecto escribimos lo siguiente:

   `composer create-project --prefer-dist laravel/lumen NOMBRE_PROY`

   **`C:\xampp\htdocs> composer create-project --prefer-dist laravel/lumen apilumen`**
   

3. Crear la base de datos `lumen` en `MySQL-PhpMyAdmin`


4. En el archivo **`.env `** se la conexion a base de datos y timezone:

> * APP_TIMEZONE=America/La_Paz
> * DB_CONNECTION=mysql
> * DB_HOST=127.0.0.1
> * DB_PORT=3306
> * DB_DATABASE=lumen
> * DB_USERNAME=root
> * DB_PASSWORD=secret



5. Abrimos el archivo **`/bootstrap/app.php`** y se adiciona lo siguiente:

> * ` $app->middleware([`
>      `App\Http\Middleware\ExampleMiddleware::class`
>  `]);`
> *  `$app->routeMiddleware([`
>      `'auth' => App\Http\Middleware\Authenticate::class`
>  `]);`
> * `$app->withFacades();`
> * `$app->withEloquent();`



6. Abrimos la terminal y escribimos los siguientes comandos:

>  **`C:\xampp\htdocs\apilumen> php artisan make:migration create_cargo_table`**

>  **`C:\xampp\htdocs\apilumen> php artisan make:migration create_operativo_table`**

***

7. Al finalizar tendremos una estructura similar a esta: 

![](https://github.com/isisroman/github/blob/master/create_migration.JPG)



7.1. Agregamos el siguiente código en el archivo `2019_04_13_160401_create_cargo_table.php` y `2019_04_13_160428_create_operativo_table.php`:

   ![](https://github.com/isisroman/github/blob/master/migration_cargo.JPG)

   ![](https://github.com/isisroman/github/blob/master/migration_operativo.JPG)



7.2. Abrimos la terminal y escribimos el siguiente comando:

>  **`C:\xampp\htdocs\apilumen> php artisan migrate`**



7.3. Al finalizar tendremos la migracion realizada en la base de datos MySQL:
![](https://github.com/isisroman/github/blob/master/bd_lumen.JPG)



8. En la carpeta **app > Http** vamos a dar **clic derecho > nueva carpeta** y lo vamos a llamar `Models`. 
Luego ahi creamos lo siguiente: **Clic derecho > new Class**, del cual lo vamos a llamar `cargo.php` y `operativo.php `respectivamente:

![](https://github.com/isisroman/github/blob/master/model_cargp.JPG)
![](https://github.com/isisroman/github/blob/master/model_operativo.JPG)



9. En la carpeta **app > Http >Controllers** crearemos los controllers para cada modelo, **Clic derecho > new Class**, del cual lo vamos a llamar `CargoController.php` y `OperativoController.php `

> CargoController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Models\Cargo;

use Exception;

use Illuminate\Support\Facades\Validator;

use Symfony\Component\HttpFoundation\Response;

class CargoController{

    public function __construct(){ }

    public function index(){
        try{
            $listado = Cargo::all();
            return response()->json($listado,Response::HTTP_OK);
        }catch (Exception $ex){
            return response()->json([
                'error' => 'Hubo un error al listar todos los cargos: '. $ex->getMessage()
            ], 206);
        }
    }
    public function show(Request $request,$id)
    {
        try{
            $cargo = Cargo::find($id);
            return response()->json($cargo,Response::HTTP_OK);
        }catch (Exception $ex){
            return response()->json([
                'error' => 'Hubo un error al encontrar el cargo con id => '. $id ." : ". $ex->getMessage()
            ], 404);
        }
    }
    public function store(Request $request)
    {
        try{
            $cargo = Cargo::create($request->all());
            return response()->json($cargo, Response::HTTP_CREATED);
        }catch (Exception $ex){
            return response()->json([
                'error' => 'Hubo un error al registrar el cargo: '. $ex->getMessage()
            ], 400);
        }
    }
    public function update(Request $request, $id)
    {
        try{
            $cargo= Cargo::findOrFail($id);
            $cargo->update($request->all());
            return response()->json($cargo,Response::HTTP_OK);
        }catch (Exception $ex){
            return response()->json([
                'error' => 'Hubo un error al actualizar el cargo con id => '.$id." : ". $ex->getMessage()
            ], 400);
        }
    }
    public function destroy(Request $request, $id)
    {
        try{
            Cargo::find($id)->delete();
            return response()->json([],Response::HTTP_OK);
        }catch (Exception $ex){
            return response()->json([
                'error' => 'Hubo un error al eliminar el cargo con id => '.$id." : ". $ex->getMessage()
            ], 400);
        }
    }
}


OperativoController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Models\Cargo;

use Exception;

use Illuminate\Support\Facades\Validator;

use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\DB;

use App\Http\Models\Operativo;

> class OperativoController{

    public function __construct(){}

    public function index(){
        try{
            $listado =  DB::table('operativo')
                ->join('cargo', 'operativo.idcargo', '=', 'cargo.id')
                ->select('operativo.*', 'cargo.carnombre')
                ->get();
            return response()->json($listado,Response::HTTP_OK);
        }catch (Exception $ex){
            return response()->json([
            'error' => 'Hubo un error al listar todos los operativos: '. $ex->getMessage()
        ], 206);
    }
    }
    public function show(Request $request, $id)
    {
        try{
            $operativo = Operativo::find($id);
            return response()->json($operativo);
        }catch (Exception $ex){
            return response()->json([
                'error' => 'Hubo un error al encontrar el operativo con id => '. $id ." : ". $ex->getMessage()
            ], 404);
        }
    }
    public function store(Request $request)
    {
        try{
            $operativo = Operativo::create($request->all());
            return response()->json($operativo, Response::HTTP_CREATED);
        }catch (Exception $ex){
            return response()->json([
                'error' => 'Hubo un error al registrar el operativo: '. $ex->getMessage()
            ], 400);
        }
    }
    public function update(Request $request, $id)
    {
        try{
            $operativo= Operativo::findOrFail($id);
            $operativo->update($request->all());
            return response()->json($operativo,Response::HTTP_OK);
        }catch (Exception $ex){
            return response()->json([
                'error' => 'Hubo un error al actualizar el operativo con id => '.$id." : ". $ex->getMessage()
            ], 400);
        }
    }
    public function destroy(Request $request, $id)
    {
        try{
            Operativo::find($id)->delete();
            return response()->json([],Response::HTTP_OK);
        }catch (Exception $ex){
            return response()->json([
                'error' => 'Hubo un error al eliminar el operativo con id => '.$id." : ". $ex->getMessage()
            ], 400);
        }
    }
}


10. En el archivo **app > routes > web.php** 

![](https://github.com/isisroman/github/blob/master/rutas.JPG)



11. Configurando `Cors Policy`, en la carpeta **app > Http >Middleware** vamos a dar **Click derecho > new Class**, del cual lo vamos a llamar `Cors.php`:
> > >
class Cors
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Autorization'                     => 'RcgkvUAAOpGckyWonLANuTAZEFtU7VkZ',
            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With'
        ];

        if ($request->isMethod('OPTIONS'))
        {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        $response = $next($request);
        foreach($headers as $key => $value)
        {
            $response->header($key, $value);
        }

        return $response;
    }
}



12. Agregar la clase Cors.php en ** > bootstrap > app.php** lo siguiente:
> 
> 
> $app->middleware([
>      App\Http\Middleware\ExampleMiddleware::class,
>      App\Http\Middleware\Cors::class
>  ]);

 `Finalmente abrir en navegador para visualizar el api restful :`

>  `GET    http://localhost:8080/www/apilumen/public/api/cargo`

>  `GET    http://localhost:8080/www/apilumen/public/api/cargo/{id}`

>  `POST   http://localhost:8080/www/apilumen/public/api/cargo`

>  `PUT    http://localhost:8080/www/apilumen/public/api/cargo/{id]`

>  `DELETE http://localhost:8080/www/apilumen/public/api/cargo/{id}`


![](https://github.com/isisroman/github/blob/master/apirest.JPG)
