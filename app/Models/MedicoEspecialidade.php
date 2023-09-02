<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicoEspecialidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'medico_id',
        'especialidade_id'
    ];

    public function medico() {
        return $this->belongsTo(Medico::class);
    }

    public function especialidade() {
        return $this->belongsTo(Especialidade::class);
    }
}
