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
    $(document).ready(function() {
        $('#modal-especialidade').modal('show');
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
        $.ajax({
            type: "POST",
            url: "{{ url('especialidades/create') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                $("#exampleModal").modal('hide');
                var oTable = $("#exampleModal").dataTable();
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
    function editFunc(id) {
       $.ajax({
           type: "POST",
           url: "{{ url('especialidades/read') }}",
           data: { id: id },
           dataType: 'json',
           success: function(data) {
                console.log(data);
               $('#modal-especialidade').html("Edit Employee");
               $('#modal-especialidade').modal('show');
            //    $('#id').val(res.id);
               $('#nome').val(data.nome);
               $('#descricao').html(data.descricao);
           }
       });
   }
</script>

</html>
