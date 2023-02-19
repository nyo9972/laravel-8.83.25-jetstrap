<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <img width="50px" class="sidebar-card-illustration mb-2" src="assets/img/logo.png" alt="...">
        <div class="sidebar-brand-text mx-3">W2O Software</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
           aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-plus"></i>
            <span>Cadastros</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/clients">Cliente</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Configurações</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/users">Usuários</a>
                <a class="collapse-item" href="/emails">Gerenciamento de e-mails</a>
            </div>
        </div>
    </li>

    <!-- Sidebar user -->
    <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="assets/img/undraw_profile.svg" alt="...">
        <p class="text-center mb-2"><strong>Usuário W2O</strong></p>
        <a class="btn btn-danger btn-sm" href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >Sair</a>
        <form method="POST" id="logout-form" action="{{ route('logout') }}">
            @csrf
        </form>
    </div>
</ul>
<!-- End of Sidebar -->
