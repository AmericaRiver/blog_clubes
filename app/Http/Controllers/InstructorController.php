<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class InstructorController extends Controller{

    public function index(Request $req){
         if($req->user()->rol != 'A') return response()->json(['status'=>'failed no eres administrador'], 401);
         return Instructor::all();
     }
 
     public function get(Request $req, $id){
         if($req->user()->rol != 'A') return response()->json(['status'=>'failed no eres administrador'], 401);
         $result = Instructor::find($id);
         //$result = DB::table('users')->where('user', '=', $user)->get();
         if($result)
             return $result;
         else
             return response()->json(['status'=>'failed'], 404);
     }
 
     public function create(Request $req){
         if($req->user()->rol != 'A') return response()->json(['status'=>'failed'], 401);
         $this->validate($req, [
             'rol'=>'required', 
             'nombre'=>'required',
             'apellido_paterno'=>'required',
             'apellido_materno'=>'required',
             'edad'=>'required',
             'telefono'=>'required',
             'correo'=>'required',
             'usuario'=>'required',
             'password'=>'required',
             'video'=>'required']);
 
         $datos = new Instructor;
         if($req->hasFile("video")){
             $nombreArchvo = $req->file("video")->getClientOriginalName();
             $nuevoNombre = Carbon::now()->timestamp."_".$nombreArchvo;
             $carpetaDes ="./uploadVideos/";
             $req->file("video")->move($carpetaDes, $nuevoNombre);
             
             $datos->rol = $req->rol;
              $datos->nombre = $req->nombre;  
              $datos->apellido_paterno = $req->apellido_paterno;
              $datos->apellido_materno = $req->apellido_materno;
              $datos->edad = $req->edad;
              $datos->telefono = $req->telefono;
              $datos->correo = $req->correo;
              $datos->usuario = $req->usuario;  
              $datos->password = Hash::make( $req->password );
              $datos->video = ltrim($carpetaDes,".").$nuevoNombre;
              $result = $datos->save();
         }

         // $datos->user = $req->user;
         // $datos->nombre = $req->nombre;
         // $datos->rol = $req->rol;
         // $datos->save();
        //  $result = $datos->fill($req->all())->save();
         if($result)
             return response()->json(['status'=>'success'], 200);
         else
             return response()->json(['status'=>'failed'], 404);
         }
 
     public function update(Request $req, $id){
         //if($req->user()->rol != 'A') return response()->json(['status'=>'failed'], 401);
        /* $this->validate($req, [
             'rol'=>'filled', 
             'nombre'=>'filled',
             'apellido_paterno'=>'filled',
             'apellido_materno'=>'filled',
             'edad'=>'filled',
             'telefono'=>'filled',
             'correo'=>'filled',
             'usuario'=>'filled',
             'password'=>'filled']);*/
 
         $datos = Instructor::find($id);

         if($req->hasFile("video")){
            if($datos){
                $ruta = base_path("public").$datos->video;
    
                if(file_exists($ruta)){
                    unlink($ruta);
                }
                $datos->delete();
            }
            
            $nombreArchvo = $req->file("video")->getClientOriginalName();
            $nuevoNombre = Carbon::now()->timestamp."_".$nombreArchvo;
            $carpetaDes ="./uploadVideos/";
            $req->file("video")->move($carpetaDes, $nuevoNombre);
                              
            $datos->video = ltrim($carpetaDes,".").$nuevoNombre;
            $datos->save();
        }
        if($req->input("rol")){
            $datos->rol = $req->input("rol");
        }
        if($req->input("nombre")){
            $datos->nombre = $req->input("nombre");
        }
        if($req->input("apellido_paterno")){
            $datos->apellido_paterno = $req->input("apellido_paterno");
        }
        if($req->input("apellido_materno")){
            $datos->apellido_materno = $req->input("apellido_materno");
        }
        if($req->input("edad")){
            $datos->edad = $req->input("edad");
        }
        if($req->input("telefono")){
            $datos->telefono = $req->input("telefono");
        }
        if($req->input("correo")){
            $datos->correo = $req->input("correo");
        }
        if($req->input("usuario")){
            $datos->usuario = $req->input("usuario");
        }
        if($req->input("password")){
            $datos->password = Hash:: make ($req->input("password"));
        }
        // $datos->password = Hash::make( $req->password );
         if(!$datos) return response()->json(['status'=>'failed'], 404);
         $result = $datos->save();
         //$result = $datos->fill($req->all())->save();
         if($result)
             return response()->json(['status'=>'success'], 200);
         else
             return response()->json(['status'=>'failed'], 404);
     }
 
     public function destroy(Request $req, $id){
        // if($req->user()->rol != 'A') return response()->json(['status'=>'failed'], 401);
         $datos = Instructor::find($id);
         if(!$datos) return response()->json(['status'=>'failed'], 404);
         $result = $datos->delete();
         if($result)
             return response()->json(['status'=>'success'], 200);
         else
             return response()->json(['status'=>'failed'], 404);
     } 
}