@extends('index')

@section('title', 'Início')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Início</h1>
    </div>
    <div class="row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Especialidades</h5>
                    <p class="card-text">Total: {{ $qtdEspecialidades }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Médicos</h5>
                    <p class="card-text">Total: {{ $qtdMedicos }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
