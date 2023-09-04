<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Medico;
use App\Models\Especialidade;
use App\Models\MedicoEspecialidade;
use Datatables;

class MedicoController extends Controller
{
    public function index() {
        if (request()->ajax()) {
            return datatables()
                ->of(Medico::select('*'))
                ->addColumn('data_formatada', function ($data) {
                    return $data->created_at->format('d/m/Y H:i');
                })
                ->addColumn('action', 'components/medicos-acoes')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        $especialidades = Especialidade::all();
        return view('pages.medicos', compact('especialidades'));
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(),
            ['nome' => 'required', 'crm' => 'required'],
            ['nome.required' => 'Preencha o campo nome', 'crm.required' => 'Preencha o campo CRM'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::beginTransaction();

        try {
            $novoMedico = Medico::create([
                'nome' => $request->nome,
                'crm' => $request->crm,
                'telefone' => $request->telefone,
                'email' => $request->email,
            ]);

            $idNovoMedico = $novoMedico->id;
            $especialidades = $request->especialidades;
            foreach($especialidades as $especialidade) {
                MedicoEspecialidade::create([
                    'medico_id' => $idNovoMedico,
                    'especialidade_id' => $especialidade
                ]);
            }
        }
        catch (\Exception $e) {
            DB::rollback();
            return response()->json(['result' => -1]);
        }

        DB::commit();
        return response()->json(['result' => 1]);
    }

    public function read(Request $request) {
        if(empty($idMedico = $request->id)) return -1;
        $medico = Medico::where('id', '=', $idMedico)->first();
        $medico['especialidades'] = MedicoEspecialidade::where('medico_id', '=', $idMedico)->get();
        return Response()->json($medico);
    }

    public function alterar(Request $request)
    {
        $validator = Validator::make($request->all(), ['nome' => 'required', 'crm' => 'required'], ['nome.required' => 'Preencha o campo Nome', 'crm.required' => 'Preencha o campo CRM']);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $row = Medico::find($request->id);
        $result = $row->update([
            'nome' => $request->nome,
            'crm' => $request->crm,
            'telefone' => $request->telefone,
            'email' => $request->email,
        ]);
        if (!$result) {
            return response()->json(['success' => false]);
        }
        return response()->json(['success' => true]);
    }

    public function delete(Request $request)
    {
        $row = Medico::find($request->id);
        $row->delete();
        return response()->json(['success' => true]);
    }

    public function countRows()
    {
        return Medico::count();
    }
}
