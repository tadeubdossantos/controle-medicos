<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->path() == '/' ? 'active' : '' }}" href="/">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Início
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->path() == 'especialidades' ? 'active' : '' }}"
                    href="{{ route('especialidades.list') }}">
                    <span data-feather="file" class="align-text-bottom"></span>
                    Especialidades
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->path() == 'medicos' ? 'active' : '' }}" href="{{ route('medicos.list') }}">
                    <span data-feather="shopping-cart" class="align-text-bottom"></span>
                    Médicos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->path() == 'relatorio' ? 'active' : '' }}" href="{{ route('relatorio.list') }}">
                    <span data-feather="shopping-cart" class="align-text-bottom"></span>
                    Relatório
                </a>
            </li>
        </ul>
    </div>
</nav>
