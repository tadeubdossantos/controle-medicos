@extends('index')

@section('title', 'Médicos por Especialidades')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Médicos por Especialidades</h1>
    </div>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-especialidade"
        onclick=" $('#modal-label-especialidade').html('Incluir Médico por Especialidade');resetForm();">
        Novo
    </button>
    <br><br>

    <!-- Modal -->
    <div class="modal fade" id="modal-especialidade" tabindex="-1" aria-labelledby="modal-label-especialidade"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-label-especialidade">Inclusão de Especialidade</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card bg-danger">
                        <div class="card-body text-light"></div>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data" id="frm-medicos-especialistas">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="medico_id">Médico</label>
                            <select class="form-select" id="medico_id" name="medico_id" aria-label="Floating label select example">
                                <option>Nenhum</option>
                                @foreach ($medicos as $medico)
                                    <option value="{{ $medico->id }}">{{ $medico->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="especialidade_id">Especialidade</label>
                            <select class="form-select" id="especialidade_id" name="especialidade_id" aria-label="Floating label select example">
                                <option>Nenhum</option>
                                @foreach ($especialidades as $especialidade)
                                    <option value="{{ $especialidade->id }}">{{ $especialidade->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" id="btnIncluir">Registar</button>
                            {{-- <input type="submit" value="Registrar"> --}}
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    Controle de Médicos
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-sm" id="table-medicos-especialidades">
            <thead>
                <tr>
                    <th scope="col">Médico</th>
                    <th scope="col">Especialidade</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
        </table>
    </div>

@endsection

@section('scripts')

    <script type="module">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#table-medicos-especialidades').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('medicos_especialidades/lista') }}",
                columns: [
                    {
                        data: 'medico_nome',
                        name: 'medico_nome'
                    },
                    {
                        data: 'especialidade_nome',
                        name: 'especialidade_nome'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                oLanguage: {
                    "sLengthMenu": "Mostrar _MENU_ registros por página",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
                    "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
                    "sInfoFiltered": "(filtrado de _MAX_ registros)",
                    "sSearch": "Pesquisar: ",
                    "oPaginate": {
                        "sFirst": "Início",
                        "sPrevious": "Anterior",
                        "sNext": "Próximo",
                        "sLast": "Último"
                    }
                },
            });
        });

        $('#frm-medicos-especialistas').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var rota = $('input[name=id]').val() === '' ?
                "{{ url('medicos_especialidades/cadastrar') }}" :
                "{{ url('medicos_especialidades/alterar') }}";
            $.ajax({
                    type: "POST",
                    url: rota,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.errors) {
                            $('.card').hide();
                            $('.card-body').html('');
                            Object.keys(data.errors).forEach(key => {
                                $('.card-body').append(`<p>${data.errors[key][0]}</p>`);
                            });
                            return $('.card').show();
                        }

                        if (!$('#id').val()) alert('Cadastro Realizado com sucesso!');
                        else alert('Atualização Realizada com sucesso!');
                        resetForm();
                        $('.btn-close').click();
                    },
                    error: function() {
                        alert('Houve algum problema! Por favor, tentar novamente mais tarde!');
                    }
                })
                .always(function(data) {
                    var oTable = $("#table-medicos-especialidades").dataTable();
                    oTable.fnDraw(false);
                });
        });
    </script>

    {{-- Funções chamadas de forma inline só funcionam neste bloco que não possui o atributo 'type' --}}
    <script>
        function consultar(id) {
            resetForm();
            $.ajax({
                type: "POST",
                url: "{{ url('medicos_especialidades/consultar') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $('#modal-label-especialidade').html("Alterar Especialidade");
                    $('#id').val(data.id);
                    $('#nome').val(data.nome);
                    $('#descricao').val(data.descricao);
                }
            });
        }

        function excluir(id) {
            if (!confirm("Deseja realmente excluir?")) return;
            $.ajax({
                type: "POST",
                url: "{{ url('medicos_especialidades/excluir') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    var oTable = $('#table-medicos-especialidades').dataTable();
                    oTable.fnDraw(false);
                }
            });
        }

        function resetForm() {
            $('.card').hide();
            $('.card-body ').html('');
            $('#frm-medicos-especialistas input').val('');
            $('#frm-medicos-especialistas textarea').val('');
        }
    </script>

@endsection
