<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Especialidade;
use Datatables;

class EspecialidadeController extends Controller
{
    public function index() {

        if(request()->ajax()) {
            return datatables()->of(Especialidade::select('*'))
                ->addColumn('data_formatada', function ($data) {
                    return $data->created_at->format('d/m/Y H:i');
                })
                ->addColumn('action', 'components/especialidades-acoes')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('pages.especialidades');
    }

    public function create(Request $request) {

        $validator = Validator::make($request->all(),
            [ 'nome' => 'required' ],
            [ 'nome.required' => 'Preenhca o campo nome'
        ]);

        if ($validator->fails()) {
            return response()->json(['result' => -1, 'errors' => $validator->errors()]);
        }

        $result = Especialidade::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao
        ]);
        if(!$result) {
            return response()->json(['result' => -2]);
        }

        return response()->json(['result' => 1]);
    }

    public function read(Request $request) {
        $especialidade = Especialidade::where('id', '=', $request->id)->first();
        if(!$especialidade) {
            return response()->json(['result' => -1]);
        }
        return response()->json(['result' => 1, 'data' => $especialidade]);
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(),
            [ 'nome' => 'required' ],
            [ 'nome.required' => 'Preencha o campo Nome' ]
        );

        if ($validator->fails()) {
            return response()->json(['result' => -1, 'errors' => $validator->errors()]);
        }

        $especialidade = Especialidade::find($request->id);
        $especialidade = $especialidade->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao
        ]);
        if(!$especialidade) {
            return response()->json(['result' => -1]);
        }
        return response()->json(['result' => 1]);
    }

    public function delete(Request $request) {
        $especialidade = Especialidade::find($request->id)->delete();
        if(!$especialidade) {
            return response()->json(['result' => -1]);
        }
        return response()->json(['result' => 1]);
    }

    public function countRows() {
        return Especialidade::count();
    }
}
