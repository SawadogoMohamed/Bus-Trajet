<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">


    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Gestion des actions des employés</title>

    <script src="{{ asset('js/jspdf.umd.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="shortcut icon" href="{{ URL::to('assets/img/logo.png') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/icons/flags/flags.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/css/bootstrap-datetimepicker.min.cs') }}s">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('fontawesome-free/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/simple-calendar/simple-calendar.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ URL::to('assets/plugins/datatables/cdn.datatables.net_1.13.6_css_jquery.dataTables.min.css') }}">
    <link rel="stylesheet"
        href="{{ URL::to('assets/plugins/datatables/cdn.datatables.net_buttons_2.4.1_css_buttons.dataTables.min.css') }}">

    <link rel="stylesheet" href="{{ URL::to('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/aos/aos.css') }}">
    {{-- message toastr --}}
    <link rel="stylesheet" href="{{ URL::to('assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ URL::to('assets/js/toastr_jquery.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/toastr.min.js') }}"></script>



    <style>
    
    /* ===== USER MENU ===== */
.user-menu {
    gap: 10px;
}

.user-dropdown .nav-link {
    cursor: pointer;
}

/* User info */
.user-info .user-name {
    font-size: 16px;
    font-weight: 600;
    color: #009640;
    line-height: 1;
}

.user-info .user-role {
    font-size: 12px;
    color: #6c757d;
}

/* Avatar */
.user-avatar {
    font-size: 36px;
    color: #009640;
}

/* Dropdown menu */
.user-dropdown-menu {
    border-radius: 12px;
    padding: 8px 0;
    min-width: 220px;
}

.user-dropdown-menu .dropdown-item {
    padding: 10px 18px;
    font-size: 14px;
    display: flex;
    align-items: center;
}

.user-dropdown-menu .dropdown-item:hover {
    background-color: #f1fdf6;
}

/* Mobile button */
.mobile_btn {
    display: none;
    font-size: 24px;
    color: #009640;
    cursor: pointer;
}

/* Responsive */
@media (max-width: 991px) {
    .mobile_btn {
        display: block;
        margin-right: 15px;
    }

    .user-info {
        display: none;
    }
}

        body {
            /*background: linear-gradient(35deg, #f4823c, #07da9763);*/



        }
    </style>


</head>

<body>
    <style>
        a .imge {

            margin: 15px;
            margin-left: 55px;
            
            margin-top: 8px;
        }

        a p {
            margin-top: 10px;
            color: #f4823c;
        }
    </style>
    <div class="main-wrapper">
        <div class="header" style="border-bottom: 2px solid #f4823c;">
            <div class="header-left">
                <a href="" class="logo">
                    <!-- Logo  -->
                     <img class="imge" src="..\images\logo_sotraco.jpeg" alt="">

                </a>


            </div>

            <div class="menu-toggle" >
                <a href="javascript:void(0);" id="toggle_btn">
                    <i class="fas fa-bars" ></i>
                </a>
            </div>

           

            <div class="top-nav-search">
                <p style="font-size: 25px; color:#009640; margin-top:12px;">Gestion des bus</p>
            </div>
            <!-- Mobile toggle -->
<a class="mobile_btn" id="mobile_btn">
    <i class="fas fa-bars"></i>
</a>

<ul class="nav user-menu align-items-center">

   

    <!-- User Dropdown -->
    <li class="nav-item dropdown user-dropdown">
        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center"
           data-bs-toggle="dropdown">

            <div class="user-info text-end me-2">
                <div class="user-name">
                    {{ Auth::user()->name }}
                </div>
                <small class="user-role">
                    {{ Session::get('role_name') }}
                </small>
            </div>

            <div class="user-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
        </a>

        <div class="dropdown-menu dropdown-menu-end shadow user-dropdown-menu">

            <a class="dropdown-item" href="{{ route('modifierMdp') }}">
                <i class="fas fa-cogs text-success me-2"></i>
                Modifier mot de passe
            </a>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item text-danger"
               href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-power-off me-2"></i>
                Déconnexion
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </li>

</ul>


        </div>
        <!-- pour le side bar-->
        {{-- side bar --}}

        @include('sidebar.sidebar')


        {{-- content page --}}




        @yield('content')
        <footer>
            <p style="border-top: 2px solid #f4823c;">Copyright © 2023 | PROCEDURE Action CiDeP <a
                    href="#">www.test.com</a></p>
        </footer>

    </div>

    <script src="jav/script.js"></script>

    <script src="{{ URL::to('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/feather.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/apexchart/chart-data.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/simple-calendar/jquery.simple-calendar.js') }}"></script>
    <script src="{{ URL::to('assets/js/calander.js') }}"></script>
    <script src="{{ URL::to('assets/js/circle-progress.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/datatables/cdn.datatables.net_1.13.6_js_jquery.dataTables.min.js') }}">
    </script>
    <script src="{{ URL::to('assets/plugins/datatables/cdn.datatables.net_buttons_2.4.1_js_dataTables.buttons.min.js') }}">
    </script>
    <script src="{{ URL::to('assets/plugins/datatables/cdnjs.cloudflare.com_ajax_libs_jszip_3.10.1_jszip.min.js') }}">
    </script>
    <script src="{{ URL::to('assets/plugins/datatables/cdnjs.cloudflare.com_ajax_libs_pdfmake_0.1.53_pdfmake.min.js') }}">
    </script>
    <script src="{{ URL::to('assets/plugins/datatables/cdnjs.cloudflare.com_ajax_libs_pdfmake_0.1.53_vfs_fonts.js') }}">
    </script>
    <script src="{{ URL::to('assets/plugins/datatables/cdn.datatables.net_buttons_2.4.1_js_buttons.html5.min.js') }}">
    </script>
    <script src="{{ URL::to('assets/plugins/datatables/cdn.datatables.net_buttons_2.4.1_js_buttons.print.min.js') }}">
    </script>

    <script src="{{ URL::to('assets/plugins/datatables/cdnjs.cloudflare.com_ajax_libs_jspdf_2.4.0_jspdf.umd.min.js') }}">
    </script>

    <script src="{{ URL::to('assets/plugins/datatables/jspdf.umd.min.js') }}"></script>

    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
    <script src="{{ URL::to('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/script.js') }}"></script>
    <script src="{{ URL::to('assets/aos/aos.js') }}"></script>
    <script src="{{ URL::to('assets/aos/aos.js') }}"></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js "></script>

    <script src="dashboard/script.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    @yield('script')





</body>

</html>
