<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-medicos-especialidades"
    onclick="consultar({{ $medico_id }}, {{ $especialidade_id }});">
    Editar
</button>
<a href="javascript:void(0);" id="delete-compnay" onclick="excluir({{ $medico_id }}, {{ $especialidade_id }});"
    data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger">
    Excluir
</a>
