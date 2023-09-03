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
    public function index()
    {
        if (request()->ajax()) {
            return datatables()
                ->eloquent(MedicoEspecialidade::query())
                ->addColumn('medico_nome', function ($data) {
                    return $data->medico->nome; // Substitua 'nome' pelo nome correto do campo na tabela 'medicos'.
                })
                ->addColumn('especialidade_nome', function ($data) {
                    return $data->especialidade->nome; // Substitua 'nome' pelo nome correto do campo na tabela 'especialidades'.
                })
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

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), ['medico_id' => 'required', 'especialidade_id' => 'required'], ['medico_id.required' => 'Selecione o médico', 'especialidade_id.required' => 'Selecione a especialidade']);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $result = MedicoEspecialidade::create([
            'medico_id' => $request->medico_id,
            'especialidade_id' => $request->especialidade_id,
        ]);
        return $result;
    }

    public function read(Request $request)
    {
        $result = MedicoEspecialidade::where('id', '=', $request->id)->first();
        return Response()->json($result);
    }

    public function alterar(Request $request)
    {
        $validator = Validator::make($request->all(), ['medico_id' => 'required', 'especialidade_id' => 'required'], ['medico_id.required' => 'Selecione o médico', 'especialidade_id.required' => 'Selecione a especialidade']);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $row = MedicoEspecialidade::find($request->id);
        $result = $row->update([
            'medico_id' => $request->medico_id,
            'especialidade_id' => $request->especialidade_id,
        ]);
        if (!$result) {
            return response()->json(['success' => false]);
        }
        return response()->json(['success' => true]);
    }

    public function delete(Request $request)
    {
        $row = MedicoEspecialidade::find($request->id);
        $row->delete();
        return response()->json(['success' => true]);
    }

    public function countRows()
    {
        return MedicoEspecialidade::count();
    }
}
