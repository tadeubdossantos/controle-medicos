<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidade;

class EspecialidadeController extends Controller
{
    public function index() {
        return view('pages.especialidades');
    }

    public function create(Request $request) {
        $result = Especialidade::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao
        ]);
       return $result;
    }
}
