@extends('index')

@section('title', 'Especialidades')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Especialidades</h1>
    </div>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-especialidade"
        onclick=" $('#modal-label-especialidade').html('Inclusão de Especialidade');resetForm();">
        Novo
    </button>
    <br><br>

    <!-- Modal -->
    <div class="modal fade" id="modal-especialidade" tabindex="-1" aria-labelledby="modal-label-especialidade"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-label-especialidade"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert" role="alert"></div>
                    <form action="" method="post" enctype="multipart/form-data" id="frm-especialidades">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label><span class="required">*</span>
                            <input type="text" class="form-control" id="nome" name="nome" maxlength="30">
                        </div>

                        <div class="mb-3">
                            <label for="nome" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" style="height: 100px" name="descricao" maxlength="255"></textarea>
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" id="btnIncluir">Registar</button>
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
        <table class="table table-striped table-sm" id="table-especialidades">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
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

            $('#table-especialidades').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('especialidades/lista') }}",
                    type: "POST"
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
                    [0, 'asc']
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

        $('#frm-especialidades').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var rota = $('input[name=id]').val() === '' ?
                "{{ url('especialidades/cadastrar') }}" :
                "{{ url('especialidades/alterar') }}";
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
                            return alertarErro(
                                `Houve algum problema! Por favor, tentar novamente mais tarde`);
                        }

                        if (!$('#id').val()) {
                            resetForm();
                            alertarSucesso('Cadastro realizado com sucesso!');
                        } else {
                            alertarSucesso('Atualização realizada com sucesso!');
                        }
                    },
                    error: function() {
                        $('.alert').html(`Houve algum problema! Por favor, tentar novamente mais tarde!`)
                            .addClass('alert-danger').slideDown();
                    }
                })
                .always(function(data) {
                    if (data.result == 1) {
                        let oTable = $("#table-especialidades").dataTable();
                        oTable.fnDraw(false);
                    }
                });
        });
    </script>

    {{-- Funções chamadas de forma inline só funcionam neste bloco que não possui o atributo 'type' --}}
    <script>
        function consultar(id) {
            resetForm();
            $.ajax({
                type: "POST",
                url: "{{ url('especialidades/consultar') }}",
                data: { id: id },
                dataType: 'json',
                success: function(data) {
                    let dados = data.data;
                    $('#modal-label-especialidade').html("Alterar Especialidade");
                    $('#id').val(dados.id);
                    $('#nome').val(dados.nome);
                    $('#descricao').val(dados.descricao);
                },
                error: function() {
                    alert('Houve algum problema! Por favor, tentar novamente mais tarde!');
                }
            });
        }

        function excluir(id) {
            if (!confirm("Deseja realmente excluir?")) return;
            $.ajax({
                type: "POST",
                url: "{{ url('especialidades/excluir') }}",
                data: { id: id },
                dataType: 'json',
                success: function(data) {
                    if (data.result < 0) {
                        return alert('Houve algum problema! Por favor, tentar novamente mais tarde!');
                    }
                    alert('Exclusão realizada com sucesso!');
                    var oTable = $('#table-especialidades').dataTable();
                    oTable.fnDraw(false);
                },
                error: function(e) {
                    if (e.responseJSON.message.indexOf('SQLSTATE[23000]') !== 1)
                        return alert(
                            'Essa especialidade já está vinculado com um médico, portanto não vai ser permtido excluir!'
                        );
                    alert('Houve algum problema! Por favor, tentar novamente mais tarde!');
                }
            });
        }

        function resetForm() {
            $('input.is-invalid').removeClass('is-invalid');
            $('.alert').html(``).hide();
            $('.alert').removeClass('alert-danger');
            $('.alert').removeClass('alert-success');
            $('#frm-especialidades input').val('');
            $('#frm-especialidades textarea').val('');
        }

        function alertarSucesso(msg) {
            $('.alert').removeClass('alert-danger');
            $('.alert').hide().html(msg).addClass('alert-success');
            setTimeout(function() {
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

@endsection
