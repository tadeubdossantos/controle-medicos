@extends('index')

@section('title', 'Relatório')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Relatório</h1>
    </div>

    <form id="frm-relatorio">
        <div class="row">
            <div class="col">
                <label for="crm" class="form-label">CRM</label>
                <input type="text" class="form-control" id="crm" name="crm">
            </div>
            <div class="col">
                <label for="especialidade" class="form-label">Especialidade</label>
                <select class="form-select" name="especialidade">
                    <option value="" selected>Todos</option>
                    @foreach ($especialidades as $especialidade)
                        <option value="{{ $especialidade->id }}">{{ $especialidade->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <br />
                <button class="btn btn-primary" type="submit" style="margin-top:8px;width:100%;">Pesquisar</button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped table-sm" id="table-medicos-especialidades">
            <thead>
                <tr>
                    <th scope="col">Médico</th>
                    <th scope="col">Especialidade</th>
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

            pesquisar();
        });

        $('#frm-relatorio').submit(function(e) {
            e.preventDefault();
            pesquisar();
        });

        function pesquisar() {
            $('#table-medicos-especialidades').DataTable({
                bFilter: false,
                serverSide: true,
                bDestroy: true,
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
                ajax: {
                    url: "{{ url('relatorio') }}",
                    type: "POST",
                    data: {
                        crm: $('input[name=crm]').val(),
                        especialidade: $('select[name=especialidade]').val()
                    },
                    dataSrc: function(data) {
                        if(data.result < 0) {
                            return alert('Houve algum problema! Por favor, tentar novamente mais tarde!');
                        }
                        return data.data;
                    }
                },
                columns: [
                    {
                        data: 'medico_nome',
                        name: 'medico_nome'
                    },
                    {
                        data: 'especialidade_nome',
                        name: 'especialidade_nome'
                    }
                ]
            });
        }
    </script>

    <script></script>
@endsection
