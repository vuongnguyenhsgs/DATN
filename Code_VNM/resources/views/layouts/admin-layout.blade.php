<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gentelella Alela! | </title>

        <!-- Bootstrap -->
        <link href="/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="/vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- jQuery custom content scroller -->
        <link href="/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>
        <link href="/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="/css/custom.css" rel="stylesheet">
        <link href="/css/main.css" rel="stylesheet">
        <link href="/css/select2.css" rel="stylesheet">

        <!-- jQuery -->
        <script src="/vendors/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="/vendors/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="/vendors/nprogress/nprogress.js"></script>
        <!-- jQuery custom content scroller -->
        <script src="/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="/vendors/moment/min/moment.min.js"></script>
        <script src="/vendors/switchery/dist/switchery.min.js"></script>
        <script src="/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
        <script src="/vendors/google-code-prettify/src/prettify.js"></script>
        <script src="/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
        <script src="/js/hc.js"></script>
        <script src="/js/select2.js"></script>

    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col menu_fixed">
                    <div class="left_col scroll-view">
                        <div class="clearfix"></div>

                        <!-- menu profile quick info -->
                        <div class="profile clearfix">
                            <div class="profile_pic">
                                <img src="/images/user-icon.png" class="img-circle profile_img">
                            </div>
                            <div class="profile_info">
                                <span>Welcome,</span>
                                <h2>John Doe</h2>
                            </div>
                        </div>

                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <ul class="nav side-menu">
                                    <li>
                                        <a href="#"><i class="fa fa-list-alt"></i> Quản lý đồ uống <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="/Admin/drinks/all">Danh sách đồ uống</a></li>
                                            <li><a href="/Admin/drinks/add">Thêm mới</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <ul class="nav side-menu">
                                    <li>
                                        <a href="#"><i class="fa fa-list-alt"></i> Quản lý nguyên liệu <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="/Admin/materials/all">Danh sách nguyên liệu</a></li>
                                            <li><a href="/Admin/materials/add">Thêm mới</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <ul class="nav side-menu">
                                    <li>
                                        <a href="#"><i class="fa fa-list-alt"></i> Nhà cung cấp <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="/Admin/productions/all">Danh sách nhà cung cấp</a></li>
                                            <li><a href="/Admin/productions/add">Thêm mới</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <ul class="nav side-menu">
                                    <li>
                                        <a href="#"><i class="fa fa-list-alt"></i>Đơn hàng<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="/Admin/bills/all">Danh sách đơn hàng</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <br />
                    </div>
                </div>

                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav navbar-nav" style="margin: 15px">
                                <label style="font-size: 20px">@yield('page-name')</label>
                            </div>
                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <img src="/images/user-icon.png" alt="">John Doe
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                                        <li><a href="javascript:;"> Profile</a></li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="badge bg-red pull-right">50%</span>
                                                <span>Settings</span>
                                            </a>
                                        </li>
                                        <li><a href="javascript:;">Help</a></li>
                                        <li><a href="/login"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                    </ul>
                                </li>

                                <li role="presentation" class="dropdown">
                                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-envelope-o"></i>
                                        <span class="badge bg-green">6</span>
                                    </a>
                                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                        <li>
                                            <a>
                                                <span class="image"><img src="/images/user-icon.png" alt="Profile Image" /></span>
                                                <span>
                                                    <span>John Smith</span>
                                                    <span class="time">3 mins ago</span>
                                                </span>
                                                <span class="message">
                                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">
                    @yield('page-content')
                </div>
                <!-- /page content -->

                <!-- footer content -->
                <footer>
                    <div class="pull-right">
                        Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>
        <!-- Custom Theme Scripts -->
        <script src="/js/custom.js"></script>
    </body>
</html>

