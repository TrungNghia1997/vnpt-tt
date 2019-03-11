<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/fonts/flag-icon-css/flag-icon.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/datatables/css/datatable.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/toastr/css/toastr.css') }}">
<link rel='stylesheet' href='https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css'>
    <title>VNPT thực tập</title>
    
    @yield('header')
</head>

<body>
    <div class="dashboard-main-wrapper">
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="index.html" style="text-transform:none;">
                    <img src="{{ asset('images/logo.jpg') }}" width="50px" alt=""> VNPT Hải Dương
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item">
                            <div id="custom-search" class="top-search-bar">
                                <input class="form-control" type="text" placeholder="Search..">
                            </div>
                        </li>
                        <li class="nav-item dropdown nav-user">
                            @if(!empty(Auth::user()))
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('/images/avatar-1.jpg') }}" alt="" class="user-avatar-md rounded-circle"> {{Auth::name()}}</a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">{{Auth::name()}}</h5>
                                    <span class="status"></span><span class="ml-2">{{Auth::job()}}</span>
                                </div>
                                <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Tài khoản</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-power-off mr-2"></i>Đăng xuất</a>
                            </div>
                            @else
                            <a href="" class="nav-link login" data-toggle="modal" data-target="#modalLogin"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
                            @endif
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div id="repon-size">
                        @if(!empty(Auth::user()))
                        <img src="{{ asset('/images/avatar-1.jpg') }}" alt="" class="user-avatar-md rounded-circle">
                        <a class="nav-link nav-user-img" href="#"> {{Auth::name()}}</a>
                        <a class="nav-link" href="#" style="border-left: 1px solid gray">Đăng xuất</a>
                        @else
                        <a href="" class="nav-link login" data-toggle="modal" data-target="#modalLogin"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
                        @endif
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link active" href="#"><i class="fas fa-newspaper"></i>Tin tức</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('contactUser.index') }}"><i class="fas fa-address-book"></i>Danh bạ nội bộ</a>
                            </li>
                            <li class="nav-divider">
                                Quản trị
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('user.index') }}"><i class="fa fa-fw fa-user-circle"></i>Quản lý nhân viên</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('post.index') }}"><i class="fas fa-book"></i>Quản lý bài viết</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('category.index') }}"><i class="fas fa-tags"></i>Quản lý chuyên mục</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('department.index') }}"><i class="fas fa-users"></i>Quản lý bộ phận</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('role.index') }}"><i class="fas fa-lock"></i>Quản lý vai trò</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('permission.index') }}"><i class="fas fa-hand-paper"></i>Quản lý quyền hạn</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    @yield('content')
                </div>
            </div>
            
            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 center">
                            Copyright © 2019. Design by NghiaNT. All rights reserved
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="modalLogin">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card ">
                    <div class="card-header text-center">
                        <img src="{{ asset('images/logo_vnpt.png') }}" width="142px" alt="">
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            <div class="form-group">
                                <input class="form-control-lg form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" type="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input class="form-control-lg form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" type="password" placeholder="Password" required>
                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Đăng nhập</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->
    <script src="{{ asset('/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    <!-- bootstap bundle js -->
    <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <!-- slimscroll js -->
    <script src="{{ asset('/vendor/slimscroll/jquery.slimscroll.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('/js/main-js.js') }}"></script>

    <script src="{{ asset('/vendor/datatables/js/datatable.min.js') }}"></script></script>
    <script src="{{ asset('/vendor/toastr/js/toastr.min.js') }}"></script>
    <script src='https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js'></script>
    
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $("body").tooltip({ selector: '[data-tooltip=tooltip]' });
        });

    </script>

    @yield('footer')
</body>

</html>