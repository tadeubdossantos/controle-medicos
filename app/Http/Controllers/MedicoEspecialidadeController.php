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

        if (!$result) {
            return response()->json(['success' => false]);
        }
        return response()->json(['success' => true]);
    }

    public function delete(Request $request)
    {
        $row = MedicoEspecialidade::where('medico_id', $request->medico_id)
            ->where('especialidade_id', $request->especialidade_id)
            ->delete();

        if (!$row) {
            return response()->json(['success' => false]);
        }
        return response()->json(['success' => true]);
    }

    public function relatorio(Request $request)
    {
        if(request()->ajax()) {
            $crm = $request->crm ?? '';
            $especialidade = $request->especialidade ?? '';
            $query = MedicoEspecialidade::select('medicos.nome as medico_nome', 'especialidades.nome as especialidade_nome', 'medicos.crm', 'medicos.telefone', 'medicos.email')
                ->join('medicos', 'medicos.id', '=', 'medicos_especialidades.medico_id')
                ->join('especialidades', 'especialidades.id', '=', 'medicos_especialidades.especialidade_id')
                ->where('medicos.crm', 'like', '%' . $crm . '%');
            if(!empty($especialidade)) {
                $query->Where('especialidades.id', '=', $especialidade);
            }
            return datatables()
                ->of($query->get())
                ->make(true);
        }

        $especialidades = Especialidade::orderBy('nome')->get();
        return view('pages.relatorio', compact('especialidades'));
    }
}
