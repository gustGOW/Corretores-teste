<?php

namespace App\Http\Controllers;

use App\Models\Corretores;
use Illuminate\Http\Request;

class CorretoresController extends Controller
{
    public function index(){
        $corretores = Corretores::all();
        return view('index')->with('corretores', $corretores);
    }

    public function getAll(){
        $corretores = Corretores::all();
        return response()->json($corretores);
    }

    public function find($id)
    {
        $corretores = Corretores::find($id);
        return response()->json($corretores);

    }
    public function update(Request $request, $id){
        $corretores = Corretores::find($id);

        $corretores->name = $request->name;
        $corretores->cpf = $request->cpf;
        $corretores->creci = $request->creci;
        $corretores->save();

        return response()->json($corretores);
    }

    public function delete($id){
        $corretores = Corretores::find($id);

        $corretores->delete();
        return response()->json($corretores);
    }

    public function create(Request $request){
        $this->validate($request,[
            'name' => 'required|string',
            'cpf' => 'required|string|max:11',
            'creci' => 'required|string|max:9',
        ]);

        $cpf = Corretores::where('cpf', $request->cpf)->exists();
        if ($cpf) {
            return response()->json(["CPF ja cadastrado"], 400);
        }

        if(!empty($request->id)) {
            return $this->update($request, $request->id);

        $corretores = new Corretores();

        $corretores->name = $request->name;
        $corretores->cpf = $request->cpf;
        $corretores->creci = $request->creci;
        $corretores->save();

        return response()->json($corretores);
    }
}
}