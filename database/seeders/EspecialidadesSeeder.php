<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EspecialidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $especialidades = [
            [
                'nome' => "Cardiologia",
                'descricao' => "A cardiologia é a especialidade médica que se concentra no diagnóstico e tratamento de doenças do coração e do sistema cardiovascular.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nome' => "Dermatologia",
                'descricao' => "Dermatologia é a especialidade médica que trata da pele, cabelo, unhas e mucosas.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nome' => "Pediatria",
                'descricao' => "A pediatria é a especialidade médica voltada para o cuidado de bebês, crianças e adolescentes.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nome' => "Neurologia",
                'descricao' => "A neurologia é a especialidade médica que se concentra no diagnóstico e tratamento de distúrbios do sistema nervoso, incluindo o cérebro, a medula espinhal e os nervos periféricos.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nome' => "Ortopedia",
                'descricao' => "A ortopedia é a especialidade médica que lida com o diagnóstico e tratamento de distúrbios do sistema musculoesquelético.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
                ]
            ];

            DB::table('especialidades')->insert($especialidades);
    }
}
