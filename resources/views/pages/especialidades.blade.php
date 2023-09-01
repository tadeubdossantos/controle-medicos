@extends('index')

@section('title', 'Especialidades')

@section('content')
<div
    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Especialidades</h1>
</div>

<button type="button" class="btn btn-success">Incluir</button>
<br/><br/>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Descrição</th>
                <th scope="col">Criado</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
    </table>
</div>

@endsection
