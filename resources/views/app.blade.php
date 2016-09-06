<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Konvert marketing</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/css/all.css">
    <link rel="stylesheet" href="/css/app.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Theme style -->
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="hold-transition skin-blue sidebar-mini" ng-app="magazijn">

<toast></toast>

<div class="wrapper" ng-controller="Ctrl">


    <header class="main-header">

        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>K</b>M</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Konvert</b>Marketing</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <li>
                        <a ng-click="changeLanguage('nl')">NL</a>
                    </li>

                    <li>
                        <a ng-click="changeLanguage('fr')">FR</a>
                    </li>

                    <!-- Notifications: style can be found in dropdown.less 
                    <li class="dropdown notifications-menu">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span ng-if="notifications.length > 0" class="label label-danger"><% notifications.length %></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header" ng-if="notifications.length > 0"><% 'NOTIFICATIONS' | translate %><a ng-click="clearNotifications()" class="pull-right" style="font-size:.8em;">lijst wissen</a></li>
                            <li class="header" ng-if="notifications.length == 0"><% 'NO_NOTIFICATIONS' | translate %></li>
                            <li>
                                 inner menu: contains the actual data 
                                <ul class="menu">
                                    <li ng-repeat="not in notifications" class="notification-item">
                                        <a ng-click="notificationDetail(not)">
                                            <i class="fa fa-flag text-aqua"></i> <% not.message %>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </li>-->

                    <!-- User Account: style can be found in dropdown.less 
                    <li class="dropdown user user-menu">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image 
                            <li class="user-header">
                                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                <p>
                                    Alexander Pierce - Web Developer
                                    <small>Member since Nov. 2012</small>
                                </p>
                            </li>
                            <!-- Menu Body 
                            <li class="user-body">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </li>
                            <!-- Menu Footer
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="/logout" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>-->
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="/logout"><i class=""> <% 'LOGOUT' | translate %></i></a>
                    </li>
                </ul>
            </div>

        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="images/K.jpg" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>

                </div>
            </div>

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">MENU</li>
                @if(!Auth::user()->admin)
                <li>
                    <a href="#/aanvragen">
                        <i class="fa fa-dashboard"></i> <span><% 'PROMO_BEURS' | translate %></span>
                    </a>
                </li>

                {{-- <li>
                    <a href="#/emailhandtekeningen">
                        <i class="fa fa-paint-brush"></i> <span>Email handtekeningen</span>
                    </a>
                </li> --}}

                <li>
                    <a href="#/logos">
                        <i class="fa fa-th"></i> <span><% 'LOGOS' | translate %></span>
                    </a>
                </li>

                {{-- <li>
                    <a href="#/drukwerk">
                        <i class="fa fa-file-text-o"></i> <span>Drukwerk</span>
                    </a>
                </li> --}}

                <!-- <li>
                    <a href="#/documenten">
                        <i class="fa fa-file-text-o"></i> <span>Documenten</span>
                    </a>
                </li> -->

                <li>
                    <a href="#/instellingen">
                        <i class="fa fa-cogs"></i> <span><% 'SETTINGS' | translate %></span>
                    </a>
                </li>

                @elseif(Auth::user()->admin)

                    <li>
                        <a href="#/admin/aanvragen">
                            <i class="fa fa-dashboard"></i> <span><% 'PROMO_BEURS' | translate %></span>
                        </a>
                    </li>

                    <li>
                        <a href="#/admin/emailhandtekeningen">
                            <i class="fa fa-paint-brush"></i> <span><% 'EMAILSIGNATURE' | translate %></span><small class="label pull-right bg-red" ng-if="amountofnewsignatures"><% amountofnewsignatures %></small>
                        </a>
                    </li>

                    {{-- <li>
                        <a href="#/admin/drukwerk">
                            <i class="fa fa-file-text-o"></i> <span>Drukwerk</span>
                        </a>
                    </li>

                    <li>
                        <a href="#/admin/documenten">
                            <i class="fa fa-file-text-o"></i> <span>Documenten</span>
                        </a>
                    </li> --}}
                    
                    <li>
                        <a href="#/admin/users">
                            <i class="fa fa-file-text-o"></i> <span>Gebruikers</span>
                        </a>
                    </li>

                    <!--<li>
                        <a href="#/admin/documenten">
                            <i class="fa fa-file-text-o"></i> <span>Documenten</span> <small class="label pull-right bg-green">new</small>
                        </a>
                    </li>-->

                        @endif

                <!--<li class="treeview">
                    <a href="#">
                        <i class="fa fa-pie-chart"></i>
                        <span>Charts</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
                        <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
                        <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
                        <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
                    </ul>
                </li>

                <li class="header">LABELS</li>
                <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
                <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
                <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
            </ul>-->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <div style="padding: 30px;" ng-view></div>

    </div><!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>v</b>0.4.2 Beta
        </div>
        <strong>Copyright &copy; 2016 - Konvert NV</strong> All rights reserved.
    </footer>

    <div class="control-sidebar-bg"></div>

</div><!-- ./wrapper -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src='https://cdn.rawgit.com/admsev/jquery-play-sound/master/jquery.playSound.js'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="{{ asset('/js/vendor.js') }}"></script>
<script src="{{ asset('/js/main.js') }}"></script>
<script src="{{ asset('/js/angular-translate.min.js') }}"></script>
<script src="{{ asset('/js/angular-translate-loader-static-files.min.js') }}"></script>
<script src="{{ asset('/app/controllers/dashboardCtrl.js') }}"></script>
<script src="{{ asset('/app/controllers/createRequestCtrl.js') }}"></script>
<script src="{{ asset('/app/controllers/createEmailhandtekeningCtrl.js') }}"></script>
<script src="{{ asset('/app/controllers/logosCtrl.js') }}"></script>
<script src="{{ asset('/app/controllers/adminCtrl.js') }}"></script>
<script src="{{ asset('/app/controllers/orderDetailCtrl.js') }}"></script>
<script src="{{ asset('/app/controllers/drukwerkCtrl.js') }}"></script>
<script src="{{ asset('/app/controllers/drukwerkDetailCtrl.js') }}"></script>
<script src="{{ asset('/app/controllers/settingsCtrl.js') }}"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="plugins/chartjs/Chart.min.js"></script>

</body>

</html>
