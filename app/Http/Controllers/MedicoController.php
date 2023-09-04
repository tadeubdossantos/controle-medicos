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
        $validator = Validator::make($request->all(), ['nome' => 'required', 'crm' => 'required'], ['nome.required' => 'Preencha o campo nome', 'crm.required' => 'Preencha o campo CRM']);

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
            foreach ($especialidades as $especialidade) {
                MedicoEspecialidade::create([
                    'medico_id' => $idNovoMedico,
                    'especialidade_id' => $especialidade,
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['result' => -1]);
        }

        DB::commit();
        return response()->json(['result' => 1]);
    }

    public function read(Request $request) {
        if (empty(($idMedico = $request->id))) {
            return -1;
        }
        $medico = Medico::where('id', '=', $idMedico)->first();
        $medico['especialidades'] = MedicoEspecialidade::where('medico_id', '=', $idMedico)->get();
        return Response()->json($medico);
    }

    public function alterar(Request $request) {
        $validator = Validator::make($request->all(), ['nome' => 'required', 'crm' => 'required'], ['nome.required' => 'Preencha o campo Nome', 'crm.required' => 'Preencha o campo CRM']);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $medicoId = $request->id;
            $medico = Medico::find($medicoId);
            $medico = $medico->update([
                'nome' => $request->nome,
                'crm' => $request->crm,
                'telefone' => $request->telefone,
                'email' => $request->email,
            ]);

            // Se houver especialidades checkadas
            if(count($especialidadesMedico = ($request->especialidades ?? [])) > 0) {
                // Vincula especialidades novas checkadas
                foreach($especialidadesMedico as $especialidadeId) {
                    $result = MedicoEspecialidade::where('medico_id', '=', $medicoId)
                        ->where('especialidade_id', '=', $especialidadeId)
                        ->first();
                    if(empty($result)) {
                        $retorno = MedicoEspecialidade::create([
                            'medico_id' => $medicoId,
                            'especialidade_id' => $especialidadeId,
                        ]);
                    }
                }

                // Verificar a possibilidade de houver especialidades não mais pertecentes ao médico
                $especialidadesGravadas = MedicoEspecialidade::where('medico_id', '=', $medicoId);
                foreach($especialidadesMedico as $especialidadeId) {
                   $especialidadesGravadas->where('especialidade_id', '<>', $especialidadeId);
                }
                $especialidadesGravadas->delete();

            /* Senão houver nenhuma especialidade checkada então verificar se tem alguma que já foi vinculada
            anteriormente para excluir */
            }else if(empty($especialidadesMedico)) {
                $medicoEspecialidades = MedicoEspecialidade::where('medico_id', '=', $medicoId)->delete();
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['result' => -1]);
        }

        DB::commit();
        return response()->json(['result' => 1]);
    }

    public function delete(Request $request) {
        $medicoId = $request->id;
        DB::beginTransaction();
        try {
            $medicoEspecialidades = MedicoEspecialidade::where('medico_id', '=', $medicoId)->delete();
            $medico = Medico::find($medicoId)->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['result' => -1, 'error' => $e]);
        }

        DB::commit();
        return response()->json(['result' => true]);
    }

    public function countRows()
    {
        return Medico::count();
    }
}
