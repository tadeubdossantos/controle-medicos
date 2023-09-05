<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class MedicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicos = [
            [
                'nome' => "Dr. Ana Cardoso",
                'crm' => "12345-SP",
                'telefone' => "(11)555-1234",
                'email' => "dr.anacardoso@email.com",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nome' => "Dr. Carlos Silva",
                'crm' => "67890-RJ",
                'telefone' => "(21)555-5678",
                'email' => "dr.carlossilva@email.com",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nome' => "Dra. Maria Santos",
                'crm' => "54321-MG",
                'telefone' => "(31)555-9876",
                'email' => "dra.mariasantos@email.com",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nome' => "Dr. Pedro Rocha",
                'crm' => "98765-SP",
                'telefone' => "(11)555-4321",
                'email' => "dr.pedrorocha@email.com",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nome' => "Dra. Laura Mendes",
                'crm' => "34567-RJ",
                'telefone' => "(21)555-8785",
                'email' => "dra.lauramends@email.com",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
                ]
            ];

            DB::table('medicos')->insert($medicos);
        }
}
