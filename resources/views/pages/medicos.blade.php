@extends('index')

@section('title', 'Medicos')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Médicos</h1>
    </div>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-medico"
        onclick=" $('#modal-label-medico').html('Incluir Medico');resetForm();">
        Novo
    </button>
    <br><br>

    <!-- Modal -->
    <div class="modal fade" id="modal-medico" tabindex="-1" aria-labelledby="modal-label-medico" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-label-medico">Inclusão de Medico</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card bg-danger">
                        <div class="card-body text-light"></div>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data" id="frm-medicos">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome:</label>
                            <input type="text" class="form-control" id="nome" name="nome">
                        </div>
                        <div class="mb-3">
                            <label for="crm" class="form-label">CRM:</label>
                            <input type="text" class="form-control" id="crm" name="crm">
                        </div>
                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone:</label>
                            <input type="text" class="form-control" id="telefone" name="telefone">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail:</label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <h5>Especialidades:</h5>
                        </div>
                        <div class="mb-3">
                            @php
                                if(($qtdEspecialistas = count($especialidades)) > 0) {
                                    $rowsCol1 = $rowsCol2 = intval($qtdEspecialistas / 2);
                                    $rowsCol1 += ($qtdEspecialistas % 2);
                                    $especialidadesCol1 = $especialidadesCol2 = [];
                                    foreach ($especialidades as $key => $especialidade) {
                                        if(($key) < $rowsCol1) $especialidadesCol1[] = $especialidades[$key];
                                        else $especialidadesCol2[] = $especialidades[$key];
                                    }
                                }
                            @endphp
                            @if($qtdEspecialistas > 0)
                                <div class="row">
                                    <div class="col">
                                        @foreach ($especialidadesCol1 as $especialidadeCol1)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="{{ $especialidadeCol1->id }}" name="especialidades[]">
                                                <label class="form-check-label">
                                                    {{ $especialidadeCol1->nome }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if(count($especialidadesCol2) > 0)
                                        <div class="col">
                                            @foreach ($especialidadesCol2 as $especialidadeCol2)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{ $especialidadeCol2->id }}" name="especialidades[]">
                                                    <label class="form-check-label">
                                                        {{ $especialidadeCol2->nome }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif
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
        <table class="table table-striped table-sm" id="table-medicos">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">CRM</th>
                    <th scope="col">Email</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Data de Cadastro</th>
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

            $('#table-medicos').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('medicos/lista') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'nome',
                        name: 'nome'
                    },
                    {
                        data: 'crm',
                        name: 'crm'
                    },
                    {
                        data: 'telefone',
                        name: 'telefone'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'data_formatada',
                        name: 'data_formatada'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },

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

        $('#frm-medicos').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var rota = $('input[name=id]').val() === '' ?
                "{{ url('medicos/cadastrar') }}" :
                "{{ url('medicos/alterar') }}";
            $.ajax({
                    type: "POST",
                    url: rota,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        return console.log(formData);
                        if (data.errors) {

                            console.log('error')
                            $('.card').hide();
                            $('.card-body').html('');
                            Object.keys(data.errors).forEach(key => {
                                $('.card-body').append(`<p>${data.errors[key][0]}</p>`);
                            });
                            return $('.card').show();
                        }
                        if (!$('#id').val()) alert('Cadastrado com Realizado com sucesso!');
                        else alert('Atualização Realizada com sucesso!');
                        resetForm();
                        $('.btn-close').click();
                    },
                    error: function() {
                        alert('Houve algum problema! Por favor, tentar novamente mais tarde!');
                    }
                })
                .always(function(data) {
                    var oTable = $("#table-medicos").dataTable();
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
                url: "{{ url('medicos/consultar') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $('#modal-label-medico').html("Alterar Medico");
                    $('#id').val(data.id);
                    $('#nome').val(data.nome);
                    $('#crm').val(data.crm);
                    $('#telefone').val(data.telefone);
                    $('#email').val(data.email);
                    $('#descricao').val(data.descricao);
                }
            });
        }

        function excluir(id) {
            if (!confirm("Deseja realmente excluir?")) return;
            $.ajax({
                type: "POST",
                url: "{{ url('medicos/excluir') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    var oTable = $('#table-medicos').dataTable();
                    oTable.fnDraw(false);
                }
            });
        }

        function resetForm() {
            $('.card').hide();
            $('.card-body ').html('');
            $('#frm-medicos input[type=text]').val('');
            $('#frm-medicos input[type=checkbox]').is(':checked').each(function(){
                $(this).prop('checked', false);
            });
        }
    </script>

@endsection
