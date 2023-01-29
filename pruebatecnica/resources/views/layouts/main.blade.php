<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Online Store</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- DevExpress -->
  <script type="text/javascript" src="{{ asset('/js/jquery.js') }}"></script>
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/dx.light.css') }}" />
  <script type="text/javascript" src="{{ asset('/js/dx.all.js') }}"></script>

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- CSS -->
  <link href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('/vendor/quill/quill.bubble.css') }}" rel="stylesheet">

  <link href="{{ asset('/css/plantilla.css') }}" rel="stylesheet">

  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
  .dx-toolbar{
        background-color: transparent !important;
        margin-bottom: 10px;
  }

  .dx-switch-container{
    height: 36px;
  }    

  .dx-switch-handle{
    height: 30px;
  }

  .dx-switch-off,
  .dx-switch-on{
    line-height: 30px;
    font-size: 20px;
  }

  @yield('estilo')

</style>
<body class="toggle-sidebar">
  <!-- ======= Header ======= -->
  
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <i class="bi bi-list toggle-sidebar-btn"></i>

        <a href="{{ url('/') }}" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block" style="margin-left: 20px">Online Store</span>
        </a>
    </div>

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{Auth::user()->first_name.' '.Auth::user()->last_name}}</span> 
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="dropdown-item d-flex align-items-center" href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Log Out</span>
                </a>
              </form>

            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('/') }}">
          <i class="bi bi-house"></i>
          <span>Home</span>
        </a>
      </li>
      
      @can('users')
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('/users') }}">
          <i class="bi bi-person-fill"></i>
          <span>Users</span>
        </a>
      </li>
      @endcan
      
      @can('stock')
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('/stock') }}">
          <i class="bi bi-box-seam"></i>
          <span>Product Stock</span>
        </a>
      </li>
      @endcan

      @can('accounting')
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('/accounting') }}">
          <i class="bi bi-currency-dollar"></i>
          <span>Accounting</span>
        </a>
      </li>
      @endcan

      @can('online_store')
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('/online_store') }}">
          <i class="bi bi-cart-fill"></i>
          <span>Online Store</span>
        </a>
      </li>
      @endcan

      
    </ul>
  </aside><!-- End Sidebar-->
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>@yield('pageTitle')</h1>

    </div><!-- End Page Title -->

    <div class="container-fluid" style="padding: 0; margin: 0;">
        @yield('content')

    </div>

  </main><!-- End #main -->



  <!-- Vendor JS Files -->


   <!--Scripts -->
   <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('/vendor/tinymce/tinymce.min.js') }}"></script>
   <script src="{{ asset('/vendor/quill/quill.min.js') }}"></script>
 
   <script src="{{ asset('/js/plantila.js') }}"></script>
</body>

</html>

@yield('script')

