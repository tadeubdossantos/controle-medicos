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
                    <div class="alert" role="alert"></div>
                    <form action="" method="post" enctype="multipart/form-data" id="frm-medicos">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome:</label><span class="required">*</span>
                            <input type="text" class="form-control" id="nome" name="nome" maxlength="30">
                        </div>
                        <div class="mb-3">
                            <label for="crm" class="form-label">CRM:</label><span class="required">*</span>
                            <input type="text" class="form-control" id="crm" name="crm" maxlength="30">
                        </div>
                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone:</label>
                            <input type="text" class="form-control" id="telefone" name="telefone" maxlength="30">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail:</label>
                            <input type="email" class="form-control" id="email" name="email" maxlength="30">
                        </div>
                        <div class="mb-3">
                            <h5>Especialidades:</h5>
                        </div>
                        <div class="mb-3">
                            @php
                                $qtdEspecialistas = count($especialidades);
                                if ($qtdEspecialistas > 0) {
                                    $rowsCol1 = $rowsCol2 = intval($qtdEspecialistas / 2);
                                    $rowsCol1 += $qtdEspecialistas % 2;
                                    $especialidadesCol1 = $especialidadesCol2 = [];
                                    foreach ($especialidades as $key => $especialidade) {
                                        if ($key < $rowsCol1) {
                                            $especialidadesCol1[] = $especialidades[$key];
                                        } else {
                                            $especialidadesCol2[] = $especialidades[$key];
                                        }
                                    }
                                }
                            @endphp
                            @if ($qtdEspecialistas > 0)
                                <div class="row">
                                    <div class="col">
                                        @foreach ($especialidadesCol1 as $especialidadeCol1)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ $especialidadeCol1->id }}" name="especialidades[]">
                                                <label class="form-check-label">
                                                    {{ $especialidadeCol1->nome }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if (count($especialidadesCol2) > 0)
                                        <div class="col">
                                            @foreach ($especialidadesCol2 as $especialidadeCol2)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="{{ $especialidadeCol2->id }}" name="especialidades[]">
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
                            <button type="submit" class="btn btn-primary" id="btnIncluir">Registrar</button>
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
                serverSide: true,
                ajax: {
                    url: "{{ url('medicos/lista') }}",
                    type: "POST",
                },
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
            $('input.is-invalid').removeClass('is-invalid');
            $.ajax({
                    type: "POST",
                    url: rota,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.result == -1) {
                            let erros = '';
                            Object.keys(data.errors).forEach(key => {
                                $(`input[name=${key}]`).addClass('is-invalid');
                                erros += `<p>${data.errors[key][0]}</p>`;
                            });
                            return alertarErro(erros);
                        } else if (data.result == -2) {
                            return alertarErro();
                        }

                        if (!$('#id').val()) {
                            resetForm();
                            alertarSucesso('Cadastro realizado com sucesso!');
                        } else {
                            alertarSucesso('Atualização realizada com sucesso!');
                        }
                    },
                    error: function() {
                        alertarErro();
                    }
                })
                .always(function(data) {
                    if (data.result == 1) {
                        let oTable = $("#table-medicos").dataTable();
                        oTable.fnDraw(false);
                    }
                });
        });

        var timerSucesso = null;

        function alertarSucesso(msg) {
            $('.alert').removeClass('alert-danger');
            $('.alert').hide().html(msg).addClass('alert-success');
            if (timerSucesso) {
                clearTimeout(timerSucesso);
            }
            timerSucesso = setTimeout(function() {
                if (!$('.alert').hasClass('alert-danger')) {
                    $('.alert').slideUp().html(``).removeClass('alert-success');
                }
            }, 5000);
            $('.alert').slideDown();
        }

        function alertarErro(msg) {
            $('.alert').removeClass('alert-success');
            $('.alert').html(``).hide().addClass('alert-danger');
            if (msg === null || msg === undefined) {
                msg = 'Houve algum problema! Por favor, tentar novamente mais tarde!';
            }
            if (Array.isArray(msg)) {
                msg.forEach(function(value) {
                    $('.alert').append(`<p>${value}</p>`);
                });
            } else {
                $('.alert').html(msg);
            }
            $('.alert').slideDown();
        }
    </script>

    {{-- Funções chamadas de forma inline só funcionam neste bloco que não possui o atributo 'type' --}}
    <script>
        function consultar(id) {
            resetForm();
            $.ajax({
                type: "POST",
                url: "{{ url('medicos/consultar') }}",
                data: { id: id },
                dataType: 'json',
                success: function(data) {
                    if (data.result < 0) {
                        return alertarErro();
                    }
                    let dados = data.data;
                    $('#modal-label-medico').html("Alterar Medico");
                    $('#id').val(dados.id);
                    $('#nome').val(dados.nome);
                    $('#crm').val(dados.crm);
                    $('#telefone').val(dados.telefone);
                    $('#email').val(dados.email);
                    $('#descricao').val(dados.descricao);
                    dados.especialidades.forEach(function(value) {
                        let idEspecialidade = value.especialidade_id;
                        $('input[type=checkbox]').each(function(index) {
                            if ($(this).val() == idEspecialidade)
                                $(`input[type=checkbox][value=${idEspecialidade}]`).prop(
                                    'checked', true);
                        });
                    });
                },
                error: function() {
                    alertErro();
                }
            });
        }

        function excluir(id) {
            if (!confirm("Deseja realmente excluir?")) return;
            $.ajax({
                type: "POST",
                url: "{{ url('medicos/excluir') }}",
                data: { id: id },
                dataType: 'json',
                success: function(data) {
                    if (data.result < 0) {
                        return alert('Houve algum problema! Por favor, tentar novamente mais tarde!');
                    }
                    alert('Exclusão realizada com sucesso!');
                    var oTable = $('#table-medicos').dataTable();
                    oTable.fnDraw(false);
                },
                error: function() {
                    alert('Houve algum problema! Por favor, tentar novamente mais tarde!');
                }
            });
        }

        function resetForm() {
            $('input.is-invalid').removeClass('is-invalid');
            $('.alert').html(``).hide();
            $('.alert').removeClass('alert-danger');
            $('.alert').removeClass('alert-success');
            $('#frm-medicos input[type=text]').val('');
            $('#frm-medicos input[type=checkbox]').each(function() {
                $(this).prop('checked', false);
            });
        }
    </script>

@endsection
