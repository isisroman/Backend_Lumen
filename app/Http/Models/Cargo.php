<?php

/**
 * Created by PhpStorm.
 * User: MYSERVER
 * Date: 13/04/2019
 * Time: 16:10
 */
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
class Cargo extends Model
{
    protected $table='cargo';
    protected $primaryKey='id';
    protected $fillable = ['id', 'carnombre', 'carestado'];

}