@extends('index')

@section('title', 'Especialidades')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Especialidades</h1>
    </div>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-especialidade"
        onclick=" $('#modal-label-especialidade').html('Incluir Especialidade');resetForm();">
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
                    <form action="" method="post" enctype="multipart/form-data" id="frm-especialidades">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome:</label>
                            <input type="text" class="form-control" id="nome" name="nome">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>

                        <div class="mb-3">
                            <label for="nome" class="form-label">Descrição:</label>
                            <textarea class="form-control" id="descricao" style="height: 100px" name="descricao"></textarea>
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
                processing: true,
                serverSide: true,
                ajax: "{{ url('especialidades/lista') }}",
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

        $('#frm-especialidades').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var rota = $('input[name=id]').val() === '' ?
                "{{ url('especialidades/cadastrar') }}" :
                "{{ url('especialidades/alterar') }}";
            $.ajax({
                type: "POST",
                url: rota,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if(data.errors) {
                        $('.card').hide();
                        $('.card-body').html('');
                        Object.keys(data.errors).forEach(key => {
                            $('.card-body').append(`<p>${data.errors[key][0]}</p>`);
                        });
                        return $('.card').show();
                    }

                    if(!$('#id').val()) alert('Cadastro Realizado com sucesso!');
                    else alert('Atualização Realizada com sucesso!');
                    resetForm();
                    $('.btn-close').click();
                },
                error: function() {
                    alert('Houve algum problema! Por favor, tentar novamente mais tarde!');
                }
            })
            .always(function(data) {
                var oTable = $("#table-especialidades").dataTable();
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
                url: "{{ url('especialidades/consultar') }}",
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
                url: "{{ url('especialidades/excluir') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    var oTable = $('#table-especialidades').dataTable();
                    oTable.fnDraw(false);
                }
            });
        }

        function resetForm() {
            $('.card').hide();
            $('.card-body ').html('');
            $('#frm-especialidades input').val('');
            $('#frm-especialidades textarea').val('');
        }
    </script>

@endsection
