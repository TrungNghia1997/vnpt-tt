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
                <a class="navbar-brand" href="{{ route('home') }}" style="text-transform:none;">
                    <img src="{{ asset('images/logo.jpg') }}" width="50px" alt=""> VNPT Hải Dương
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item dropdown nav-user">
                            @if(!empty(Auth::user()))
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if (Auth::user()->avatar != '')
                                    <img src="{{ asset('/images/'.Auth::user()->avatar) }}" alt="" class="user-avatar-md rounded-circle"> 
                                @else
                                    <img src="{{ asset('/images/avatar-1.jpg') }}" alt="" class="user-avatar-md rounded-circle"> 
                                @endif
                                {{Auth::user()->name}}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">{{Auth::user()->name}}</h5>
                                    <span class="status"></span><span class="ml-2">{{Auth::user()->job}}</span>
                                </div>
                                <a class="dropdown-item" data-toggle="modal" href="#modalChangePassword" id="view-change-password"><i class="fas fa-user mr-2"></i>Đổi mật khẩu</a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="fas fa-power-off mr-2"></i>Đăng xuất</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                            </div>
                            @else
                            <a href="{{ route('login') }}" class="nav-link login" ><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
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
                        <img src="{{ asset('/images/'.Auth::user()->avatar) }}" alt="" class="user-avatar-md rounded-circle">
                        <a class="nav-link nav-user-img" href="#"> {{Auth::user()->name}}</a>
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" style="border-left: 1px solid gray">Đăng xuất</a>
                        @else
                        <a href="{{ route('login') }}" class="nav-link login" ><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
                        @endif
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <a href="{{ route('home') }}" title="">
                            <li class="nav-divider nav-link {{ Request::is('/') ? 'active' : '' }}" style="line-height: 20px !important;">
                                Trang chủ
                            </li></a>

                            @if(Entrust::can(['view_user']) || Entrust::can(['view_post']) || Entrust::can(['view_category']) || Entrust::can(['view_department']) || Entrust::can(['view_role']) || Entrust::can(['view_permission']) || Entrust::can(['view_link']))
                            <li class="nav-divider">
                                Quản trị
                            </li>

                            @if(Entrust::can(['view_user']))
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('user*') ? 'active' : '' }}" href="{{ route('user.index') }}"><i class="fa fa-fw fa-user-circle"></i>Quản lý nhân viên</a>
                            </li>
                            @endif

                            @if(Entrust::can(['view_post']))
                            <li class="nav-item ">
                                <a class="nav-link {{ Request::is('post*') ? 'active' : '' }}" href="{{ route('post.index') }}"><i class="fas fa-book"></i>Quản lý bài viết</a>
                            </li>
                            @endif
                            
                            @if(Entrust::can(['view_category']))
                            <li class="nav-item ">
                                <a class="nav-link {{ Request::is('category*') ? 'active' : '' }}" href="{{ route('category.index') }}"><i class="fas fa-tags"></i>Quản lý chuyên mục</a>
                            </li>
                            @endif

                            @if(Entrust::can(['view_department']))
                            <li class="nav-item ">
                                <a class="nav-link {{ Request::is('department*') ? 'active' : '' }}" href="{{ route('department.index') }}"><i class="fas fa-users"></i>Quản lý bộ phận</a>
                            </li>
                            @endif

                            @if(Entrust::can(['view_link']))
                            <li class="nav-item ">
                                <a class="nav-link {{ Request::is('link*') ? 'active' : '' }}" href="{{ route('link.index') }}"><i class="fa fa-link"></i>Quản lý chương trình liên kết</a>
                            </li>
                            @endif

                            @if(Entrust::can(['view_role']))
                            <li class="nav-item ">
                                <a class="nav-link {{ Request::is('role*') ? 'active' : '' }}" href="{{ route('role.index') }}"><i class="fas fa-lock"></i>Quản lý vai trò</a>
                            </li>
                            @endif

                            @if(Entrust::can(['view_permission']))
                            <li class="nav-item ">
                                <a class="nav-link {{ Request::is('permission*') ? 'active' : '' }}" href="{{ route('permission.index') }}"><i class="fas fa-hand-paper"></i>Quản lý quyền hạn</a>
                            </li>
                            @endif

                            @endif
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

    <div class="modal" id="modalChangePassword">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header center">
                    <h4 class="modal-title">Đổi mật khẩu</h4>
                </div>

                <div class="modal-body">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
                            <label for="password_old">Mật khẩu cũ <span class="red-color">(*)</span></label>
                            <input type="password" class="form-control" id="password_old" value="">
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
                            <label for="password_new">Mật khẩu mới <span class="red-color">(*)</span></label>
                            <input type="password" class="form-control" id="password_new" value="">
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
                            <label for="password_confirm">Nhập lại mật khẩu mới <span class="red-color">(*)</span></label>
                            <input type="password" class="form-control" id="password_confirm" value="">
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <center>
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-sm btn-primary edit_tag" id="change-password">Cập nhật</button>
                    </center>
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

    <script>
        $('#view-change-password').click(function(){
            $('#password_old').val('');
            $('#password_new').val('');
            $('#password_new').val('');
        });

        $('#change-password').click(function(){
            $.ajax({
                type: 'POST',
                url: '{{ route('user.changePassword') }}',
                data: {
                    password_old: $('#password_old').val(),
                    password_new: $('#password_new').val(),
                    password_confirm: $('#password_confirm').val(),
                }, success: function(res){
                    if (!res.error) {
                        toastr.success('Bạn đã cập nhật mật khẩu thành công');
                        $('#modalChangePassword').modal('hide');
                    } else {
                        if (res.message.password_old || res.message.password_new || res.message.password_confirm) {
                            if (res.message.password_old) {
                                toastr.error(res.message.password_old);
                            }

                            if (res.message.password_new) {
                                toastr.error(res.message.password_new);
                            }

                            if (res.message.password_confirm) {
                                toastr.error(res.message.password_confirm);
                            }
                        } else {
                            toastr.error(res.message);
                        }
                    }
                }
            });
        });
    </script>

    @yield('footer')
</body>

</html>