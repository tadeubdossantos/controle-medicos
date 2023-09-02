<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- styles --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Controle de Médicos</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </header>

    <div class="container-fluid">
        <div class="row">
            {{-- Menu --}}
            @include('components.menu')
            {{-- Conteudo --}}
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('content')
            </main>
        </div>
    </div>
    {{-- scripts --}}
    {{-- <script src="https://getbootstrap.com/docs/5.2/dist/js/bootstrap.bundle.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script> --}}
    {{-- <script src="https://getbootstrap.com/docs/5.2/examples/dashboard/dashboard.js"></script> --}}
</body>

<script type="module">
    //   $('#modal-especialidade').modal('show');
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
                    data: 'descricao',
                    name: 'descricao'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },

            ],
            order: [
                [0, 'desc']
            ]
        });
    });

    $('#frm-especialidades').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var rota = $('input[name=id]').val() === '' ?
            "{{ url('especialidades/cadastrar') }}"
            : "{{ url('especialidades/alterar') }}" ;
        $.ajax({
            type: "POST",
            url: rota,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                $("#exampleModal").modal('hide');
                var oTable = $("#table-especialidades").dataTable();
                oTable.fnDraw(false);

            },
            error: function(data) {
                console.log(data);
            }
        });
    });
</script>
{{-- Funções aplicados de forma inline
    se não haver o

    --}}
<script>
    function consultar(id) {
        $.ajax({
            type: "POST",
            url: "{{ url('especialidades/consultar') }}",
            data: { id: id },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#modal-label-especialidade').html("Alterar Especialidade");
                $('#id').val(data.id);
                $('#nome').val(data.nome);
                $('#descricao').html(data.descricao);
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
                var oTable = $('#table-especialidades').dataTable();
                oTable.fnDraw(false);
            }
        });
    }

</script>

</html>
