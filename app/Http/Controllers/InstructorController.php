<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use Illuminate\Support\Facades\Hash;


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
             'password'=>'required']);
 
         $datos = new Instructor;
         // $datos->user = $req->user;
         $datos->password = Hash::make( $req->password );
         // $datos->nombre = $req->nombre;
         // $datos->rol = $req->rol;
         // $datos->save();
         $result = $datos->fill($req->all())->save();
         if($result)
             return response()->json(['status'=>'success'], 200);
         else
             return response()->json(['status'=>'failed'], 404);
     }
 
     public function update(Request $req, $id){
         //if($req->user()->rol != 'A') return response()->json(['status'=>'failed'], 401);
         $this->validate($req, [
             'rol'=>'filled', 
             'nombre'=>'filled',
             'apellido_paterno'=>'filled',
             'apellido_materno'=>'filled',
             'edad'=>'filled',
             'telefono'=>'filled',
             'correo'=>'filled',
             'usuario'=>'filled',
             'password'=>'filled']);
 
         $datos = Instructor::find($id);
         $datos->password = Hash::make( $req->password );
         if(!$datos) return response()->json(['status'=>'failed'], 404);
         $result = $datos->fill($req->all())->save();
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