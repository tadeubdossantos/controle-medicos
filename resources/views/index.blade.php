<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
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
        console.log('123');
    });

    $('#frm-especialidades').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type:"POST",
            url: "{{ route('especialidades.create') }}",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: (data) => {
                console.log(data)
            },
            error: function(data) {
                console.log(data);
            }
        });

    });
</script>

</html>
