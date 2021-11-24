<?php   
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model{
    protected $table = "alumnos";

    
    protected $fillable = [
        'id','folio', 'nombre', 'apellido_paterno','apellido_materno',
        'carrera',
        'sexo',
        'edad',
        'telefono',
        'correo',
        'club_alternativo',
        'alergias',
        'situacion_medica'
    ];
    public $timestamps = false;
}