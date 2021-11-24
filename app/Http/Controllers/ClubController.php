<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;

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
            'id_instructor'=>'required']);

        $datos = new Club;
        $result = $datos->fill($req->all())->save();
        if($result)
            return response()->json(['status'=>'success'], 200);
        else
            return response()->json(['status'=>'failed'], 404);
    }

    public function update(Request $req, $id){
        $this->validate($req, [
            'nombre'=>'filled',
            'tipo'=>'filled',
            'id_instructor'=>'filled']);

        $datos = Club::find($id);
        if(!$datos) return response()->json(['status'=>'failed'], 404);
        $result = $datos->fill($req->all())->save();
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