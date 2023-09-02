<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MedicoEspecialidade;
use App\Models\Medico;
use App\Models\Especialidade;
use Datatables;

class MedicoEspecialidadeController extends Controller
{
    public function index() {

        if(request()->ajax()) {
            return datatables()->of(MedicoEspecialidade::select('*'))
                ->addColumn('data_formatada', function ($data) {
                    return $data->created_at->format('d/m/Y H:i');
                })
                ->addColumn('action', 'components/medicos_especialidades-acoes')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        $medicos = Medico::all();
        $especialidades = Especialidade::all();
        return view('pages.medicos_especialidades', compact('medicos', 'especialidades'));
    }

    public function create(Request $request) {

        $validator = Validator::make($request->all(),
            [ 'nome' => 'required', 'crm' => 'required' ],
            [ 'nome.required' => 'Preencha o campo nome', 'crm.required' => 'Preencha o campo CRM']
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $result = MedicoEspecialidade::create([
            'nome' => $request->nome,
            'crm' => $request->crm,
            'telefone' => $request->telefone,
            'email' => $request->email
        ]);
       return $result;
    }

    public function read(Request $request) {
        $result = MedicoEspecialidade::where('id', '=', $request->id)->first();
        return Response()->json($result);
    }

    public function alterar(Request $request) {
        $validator = Validator::make($request->all(),
            [ 'nome' => 'required', 'crm' => 'required' ],
            [ 'nome.required' => 'Preencha o campo Nome', 'crm.required' => 'Preencha o campo CRM']
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $row = MedicoEspecialidade::find($request->id);
        $result = $row->update([
            'nome' => $request->nome,
            'crm' => $request->crm,
            'telefone' => $request->telefone,
            'email' => $request->email
        ]);
        if(!$result)
            return response()->json(['success' => false]);
        return response()->json(['success' => true]);
    }

    public function delete(Request $request) {
        $row = MedicoEspecialidade::find($request->id);
        $row->delete();
        return response()->json(['success' => true]);
    }

    public function countRows() {
        return MedicoEspecialidade::count();
    }
}
