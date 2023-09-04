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
        $especialidades = Especialidade::orderBy('nome')->get();
        return view('pages.relatorio', compact('especialidades'));
    }

    public function relatorio(Request $request) {
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
        return response()->json(['result' => -1]);
    }
}
