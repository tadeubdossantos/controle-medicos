<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidade;
use Datatables;

class EspecialidadeController extends Controller
{
    public function index() {
        if(request()->ajax()) {
            return datatables()->of(Especialidade::select('*'))
                ->addColumn('action', 'components/especialidades-acoes')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('pages.especialidades');
    }

    public function create(Request $request) {
        $result = Especialidade::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao
        ]);
       return $result;
    }

    public function read(Request $request) {
        $result = Especialidade::where('id', '=', $request->id)->first();
        return Response()->json($result);
    }

    public function delete(Request $request) {
        $row = Especialidade::find($request->id);
        $row->delete();
        return response()->json(['success' => true]);
    }
}
