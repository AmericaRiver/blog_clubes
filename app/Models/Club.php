<?php   
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Club extends Model{
    protected $table = "clubes";

     protected $fillable = [
        'id', 'nombre', 'imagen', 'tipo', 'id_instructor'
     ];

     public $timestamps = false;
}