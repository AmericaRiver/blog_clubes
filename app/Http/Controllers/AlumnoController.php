<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Alumno;

class AlumnoController extends Controller{
    public function index(Request $req){
        return Alumno::all();
    }

    public function get($id){
        $result = Alumno::find($id);
        if($result)
            return $result;
        else
            return response()->json(['status'=>'failed'], 404);
    }

    public function create (Request $req){
        $this->validate($req, [ 
            'nombre'=>'required',
            'apellidos'=>'required',
            'carrera'=>'required',
            'sexo'=>'required',
            'edad'=>'required',
            'telefono'=>'required',
            'correo'=>'required',
            'club_alternativo'=>'required']);
        $datos = new Alumno;
        $result = $datos->fill($req->all())->save();
        if($result)
            return response()->json(['status'=>'success'], 200);
        else
            return response()->json(['status'=>'failed'], 404);
    }

    public function update (Request $req, $id){
        
        $this->validate($req, [ 
            'nombre'=>'filled',
            'apellidos'=>'filled',
            'carrera'=>'filled',
            'sexo'=>'filled',
            'edad'=>'filled',
            'telefono'=>'filled',
            'correo'=>'filled',
            'club_alternativo'=>'filled']);

            $datos = Alumno::find($id);
            if(!$datos) return response()->json(['status'=>'failed'], 404);
            $result = $datos->fill($req->all())->save();
            if($result)
                return response()->json(['status'=>'success'], 200);
            else
                return response()->json(['status'=>'failed'], 404);

    }

    public function destroy ($id){
        $datos = Alumno::find($id);
        if(!$datos) return response()->json(['status'=>'failed'], 404);
        $result = $datos->delete();
        if($result)
            return response()->json(['status'=>'success'], 200);
        else
            return response()->json(['status'=>'failed'], 404);

    }
}