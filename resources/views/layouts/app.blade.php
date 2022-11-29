<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'intranet') }}</title>
  <!-- Fonts -->
  <link rel="dns-prefetch" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" />
  <!-- Styles -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/css/adminlte.min.css" integrity="sha512-rVZC4rf0Piwtw/LsgwXxKXzWq3L0P6atiQKBNuXYRbg2FoRbSTIY0k2DxuJcs7dk4e/ShtMzglHKBOJxW8EQyQ==" crossorigin="anonymous" />
  @stack('css')
</head>

<body class="layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
        <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
        @else
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
            {{ Auth::user()->name }} <span class="caret"></span>
          </a>


          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
            </a>


            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>
        </li>
        @endguest
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-danger elevation-4">
      <!-- Brand Logo -->
      <a href="home" class="brand-link">
        <img src="{{ asset('img/logo_kontras_cut_300_pixels_bukan_cm_karena_buat_web_bukan_baliho.png') }}" alt="KONTRAS" class="brand-image-xs logo_kontras_cut_300_pixels_bukan_cm_karena_buat_web_bukan_baliho" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ \config('app.name') }}</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ asset('img/boxed-bg.png') }}" id="sideBarProfilePic" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="{{ route('profile.index') }}" class="d-block">{{ Auth::user()->name }}</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @can('user-list', 'user-create', 'user-edit', 'user-delete', 'role-list', 'role-create', 'role-edit', 'role-delete')
            <li class="nav-item has-treeview
              @if( in_array(request()->route()->getName(), array('users.index', 'users.show', 'users.edit', 'users.create', 'roles.index', 'roles.show', 'roles.edit', 'roles.create')) )
                menu-open
              @endif">
              <a href="#" class="nav-link
                @if( in_array(request()->route()->getName(), array('users.index', 'users.show', 'users.edit', 'users.create', 'roles.index', 'roles.show', 'roles.edit', 'roles.create')) )
                  active
                @endif">
                <i class="nav-icon fas fa-user-friends"></i>
                <p>
                  Users
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview ml-3">
                @can('user-list', 'user-create', 'user-edit', 'user-delete')
                <li class="nav-item">
                  <a href="{{ route('users.index') }}" class="nav-link
                    @if( in_array(request()->route()->getName(), array('users.index', 'users.show', 'users.edit', 'users.create')) )
                      active
                    @endif">
                    <p>All User List</p>
                  </a>
                </li>
              </ul>
                @endcan
                @can('role-list', 'role-create', 'role-edit', 'role-delete')
                <li class="nav-item">
                  <a href="{{ route('roles.index') }}" class="nav-link
                    @if( in_array(request()->route()->getName(), array('roles.index', 'roles.show', 'roles.edit', 'roles.create')) )
                      active
                    @endif">
                    <p>Roles Management</p>
                  </a>
                </li>
                @endcan
            </li>
            @endcan
            <li class="nav-item">
              <a href="{{ route('post') }}" class="nav-link">
                <i class="nav-icon fas fa-newspaper"></i>
                <p>
                  Home Page
                </p>
              </a>
            </li>
            @can('absen-list', 'absen-create', 'absen-edit', 'absen-delete')
            <li class="nav-item">
              <a href="{{ route('attendances.index') }}" class="nav-link
                @if( in_array(request()->route()->getName(), array('attendances.index', 'attendances.show', 'attendances.edit', 'attendances.create')) )
                  active
                @endif">
                <i class="nav-icon fas fa-newspaper"></i>
                <p>
                  Absensi
                </p>
              </a>
            </li>
            @endcan
            
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-newspaper"></i>
                <p>
                  Files
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview ml-3">
                <li class="nav-item">
                  <a href="{{ route('formfile') }}" class="nav-link">
                    <p>Program Kerja</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('fileNotulensi') }}" class="nav-link">
                    <p>Notulensi</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('fileMemo') }}" class="nav-link">
                    <p>Memo</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('fileSOP') }}" class="nav-link">
                    <p>SOP</p>
                  </a>
                </li>
                @if(in_array("Admin", (array) app('auth')->user()->getRoleNames()[0]) ||
                    in_array("Supervisor", (array) app('auth')->user()->getRoleNames()[0]))
                <li class="nav-item">
                  <a href="{{ route('fileDoku') }}" class="nav-link">
                    <p>Dokument KontraS</p>
                  </a>
                </li>
                @endif
              </ul>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        @yield('content')
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
  </div>
  <!-- Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/js/adminlte.min.js" integrity="sha512-++c7zGcm18AhH83pOIETVReg0dr1Yn8XTRw+0bWSIWAVCAwz1s2PwnSj4z/OOyKlwSXc4RLg3nnjR22q0dhEyA==" crossorigin="anonymous"></script>
  @stack('scripts')
</body>

</html>