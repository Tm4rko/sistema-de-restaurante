@php( $logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout') )
@php( $profile_url = View::getSection('profile_url') ?? config('adminlte.profile_url', 'logout') )

@if (config('adminlte.usermenu_profile_url', false))
@php( $profile_url = Auth::user()->adminlte_profile_url() )
@endif

@if (config('adminlte.use_route_url', false))
@php( $profile_url = $profile_url ? route($profile_url) : '' )
@php( $logout_url = $logout_url ? route($logout_url) : '' )
@else
@php( $profile_url = $profile_url ? url($profile_url) : '' )
@php( $logout_url = $logout_url ? url($logout_url) : '' )
@endif
@vite(['resources/sass/app.scss', 'resources/js/app.js'])

<!-- Scripts comunes --> 
<script src="{{ asset('js/scripts.js') }}"></script>

<!--<li class="nav-item">
    <a class="nav-link d-flex align-items-center" href="{{ route('admin.pedidos.index') }}">
        <span class="me-2">
            <i class="fas fa-shopping-cart"></i> Pedidos Nuevos
        </span>
        <span id="pedidosNuevosCount" class="badge bg-danger">{{ $pedidosNuevosCount }}</span>
    </a>
</li>-->

<li class="nav-item">
    <a class="nav-link position-relative" href="{{ route('admin.pedidos.index') }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-fill" viewBox="0 0 16 16">
            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
        </svg>
        <span id="pedidosNuevosCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ $pedidosNuevosCount }}
            <span class="visually-hidden">unread messages</span>
        </span>
    </a>
</li>

<li class="nav-item dropdown user-menu">

    {{-- User menu toggler --}}
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        @if(config('adminlte.usermenu_image'))
        <img src="{{ Auth::user()->adminlte_image() }}"
            class="user-image img-circle elevation-2"
            alt="{{ Auth::user()->name }}">
        @endif
        <span @if(config('adminlte.usermenu_image')) class="d-none d-md-inline" @endif>
            {{ Auth::user()->name }}
        </span>
    </a>

    {{-- User menu dropdown --}}
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

        {{-- User menu header --}}
        @if(!View::hasSection('usermenu_header') && config('adminlte.usermenu_header'))
        <li class="user-header {{ config('adminlte.usermenu_header_class', 'bg-primary') }}
                @if(!config('adminlte.usermenu_image')) h-auto @endif">
            @if(config('adminlte.usermenu_image'))
            <img src="{{ Auth::user()->adminlte_image() }}"
                class="img-circle elevation-2"
                alt="{{ Auth::user()->name }}">
            @endif
            <p class="@if(!config('adminlte.usermenu_image')) mt-0 @endif">
                {{ Auth::user()->name }}
                @if(config('adminlte.usermenu_desc'))
                <small>{{ Auth::user()->adminlte_desc() }}</small>
                @endif
            </p>
        </li>
        @else
        @yield('usermenu_header')
        @endif

        {{-- Configured user menu links --}}
        @each('adminlte::partials.navbar.dropdown-item', $adminlte->menu("navbar-user"), 'item')

        {{-- User menu body --}}
        @hasSection('usermenu_body')
        <li class="user-body">
            @yield('usermenu_body')
        </li>
        @endif

        {{-- User menu footer --}}
        <li class="user-footer">
            @if($profile_url)
            <a href="{{ $profile_url }}" class="nav-link btn btn-default btn-flat d-inline-block">
                <i class="fa fa-fw fa-user text-lightblue"></i>
                {{ __('adminlte::menu.profile') }}
            </a>
            @endif
            <a class="btn btn-default btn-flat float-right @if(!$profile_url) btn-block @endif"
                href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-fw fa-power-off text-red"></i>
                {{ __('adminlte::adminlte.log_out') }}
            </a>
            <form id="logout-form" action="{{ $logout_url }}" method="POST" style="display: none;">
                @if(config('adminlte.logout_method'))
                {{ method_field(config('adminlte.logout_method')) }}
                @endif
                {{ csrf_field() }}
            </form>
        </li>

    </ul>

</li>