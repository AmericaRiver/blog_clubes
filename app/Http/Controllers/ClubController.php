<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use Carbon\Carbon;

class ClubController extends Controller{
    public function index(){
        return Club::all();
    }

    public function get($id){
        $result = Club::find($id);
        if($result)
            return $result;
        else
            return response()->json(['status'=>'failed'], 404);
    }

    public function create(Request $req){
        $this->validate($req, [
            'nombre'=>'required',
            'tipo'=>'required',
            'id_instructor'=>'required', 
            'imagen'=>'required']);

        $datos = new Club;
        if($req->hasFile("imagen")){
            $nombreArchvo = $req->file("imagen")->getClientOriginalName();
            $nuevoNombre = Carbon::now()->timestamp."_".$nombreArchvo;
            $carpetaDes ="./upload/";
            $req->file("imagen")->move($carpetaDes, $nuevoNombre);
            
             $datos->nombre = $req->nombre;  
             $datos->tipo = $req->tipo;  
             $datos->id_instructor = $req->id_instructor;
             $datos->imagen = ltrim($carpetaDes,".").$nuevoNombre;
             $result = $datos->save();
        }
        if($result)
            return response()->json(['status'=>'success'], 200);
        else
            return response()->json(['status'=>'failed'], 404);
    }

    public function update(Request $req, $id){
        /*$this->validate($req, [
            'nombre'=>'filled',
            'tipo'=>'filled',
            'id_instructor'=>'filled',
            'imagen'=>'filled' ]);*/

        $datos = Club::find($id);

        if($req->hasFile("imagen")){
            if($datos){
                $ruta = base_path("public").$datos->imagen;
    
                if(file_exists($ruta)){
                    unlink($ruta);
                }
                $datos->delete();
            }
            
            $nombreArchvo = $req->file("imagen")->getClientOriginalName();
            $nuevoNombre = Carbon::now()->timestamp."_".$nombreArchvo;
            $carpetaDes ="./upload/";
            $req->file("imagen")->move($carpetaDes, $nuevoNombre);
                              
            $datos->imagen = ltrim($carpetaDes,".").$nuevoNombre;
            $datos->save();
        }

        if($req->input("nombre")){
            $datos->nombre = $req->input("nombre");
        }
        if($req->input("tipo")){
            $datos->tipo = $req->input("tipo");
        }
        if($req->input("id_instructor")){
            $datos->id_instructor = $req->input("id_instructor");
        }
        //$datos->save();

        if(!$datos) return response()->json(['status'=>'failed'], 404);
        $result = $datos->save();
        if($result)
            return response()->json(['status'=>'success'], 200);
        else
            return response()->json(['status'=>'failed'], 404);
    }

    public function destroy($id){
        $datos = Club::find($id);
        if(!$datos) return response()->json(['status'=>'failed'], 404);
        $result = $datos->delete();
        if($result)
            return response()->json(['status'=>'success'], 200);
        else
            return response()->json(['status'=>'failed'], 404);
    }
}