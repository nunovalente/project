@extends('app')

@section('head')
    <!--
        ===
        This comment should NOT be removed.

        Charisma v2.0.0

        Copyright 2012-2014 Muhammad Usman
        Licensed under the Apache License v2.0
        http://www.apache.org/licenses/LICENSE-2.0

        http://usman.it
        http://twitter.com/halalit_usman
        ===
    -->

    <!-- The styles -->
    <link id="bs-css" href="{{ asset('css/bootstrap-spacelab.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/charisma-app.css') }}" rel="stylesheet">
    <link href="{{ asset('bower_components/fullcalendar/dist/fullcalendar.css') }}" rel='stylesheet'>
    <link href="{{ asset('bower_components/fullcalendar/dist/fullcalendar.print.css') }}" rel='stylesheet' media='print'>
    <link href="{{ asset('bower_components/chosen/chosen.min.css') }}" rel='stylesheet'>
    <link href="{{ asset('bower_components/colorbox/example3/colorbox.css') }}" rel='stylesheet'>
    <link href="{{ asset('bower_components/responsive-tables/responsive-tables.css') }}" rel='stylesheet'>
    <link href="{{ asset('bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css') }}" rel='stylesheet'>
    <link href="{{ asset('css/jquery.noty.css') }}" rel='stylesheet'>
    <link href="{{ asset('css/noty_theme_default.css') }}" rel='stylesheet'>
    <link href="{{ asset('css/elfinder.min.css') }}" rel='stylesheet'>
    <link href="{{ asset('css/elfinder.theme.css') }}" rel='stylesheet'>
    <link href="{{ asset('css/jquery.iphone.toggle.css') }}" rel='stylesheet'>
    <link href="{{ asset('css/uploadify.css') }}" rel='stylesheet'>
    <link href="{{ asset('css/animate.min.css') }}" rel='stylesheet'>

    <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="{{ asset('bower_components/jquery/jquery.min.js') }}"></script>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

@endsection

@section('content')

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
        <div class="container topnav">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand topnav" href="{{ route('authlanding') }}">Website's home</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> {{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

<div class="ch-container">
    <div class="row">
        
        <!-- left menu starts -->
        <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">

                    </div>
                    <ul class="nav nav-pills nav-stacked main-menu">
                        <li class="nav-header">Admin Dashboard</li>
                        <li><a class="ajax-link" href="{{ route('adminpanel') }}"><i
                                    class="glyphicon glyphicon-edit"></i><span> User Management</span></a></li>
                        <li><a class="ajax-link" href="{{ route('admincreateuser') }}"><i
                                    class="glyphicon glyphicon-plus"></i><span> Create User</span></a></li>            
                    </ul>
                </div>
            </div>
        </div>
        <!--/span-->
        <!-- left menu ends -->

        <noscript>
            <div class="alert alert-block col-md-12">
                <h4 class="alert-heading">Warning!</h4>

                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                    enabled to use this site.</p>
            </div>
        </noscript>

        <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
            <div>
    <ul class="breadcrumb">
        <li>
            <a href="{{ route('authlanding') }}">IPL Project Browser</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-content row">
                @if (count($errors) > 0)
                    <div class="alert alert-danger margin-side">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="alert alert-info margin-side">
                    Editing user {{ $user->name }}
                </div>
                <form class="form-horizontal" role="form" method="POST" action="{{route('adminedituser-post', $user->id)}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label class="col-md-4 control-label">Name</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Role</label>
                        <div class="col-md-6">
                            <select class="form-control" name="role">
                                @if(old('role', $user->role) == \App\Constants::$no_role)
                                    <option value="{{ \App\Constants::$no_role }}" selected> Basic user </option>
                                @else
                                    <option value="{{ \App\Constants::$no_role }}"> Basic user </option>
                                @endif
                                @if(old('role', $user->role) == \App\Constants::$author_role)
                                    <option value="{{ \App\Constants::$author_role }}" selected> Author </option>
                                @else
                                    <option value="{{ \App\Constants::$author_role }}"> Author </option>
                                @endif
                                @if(old('role', $user->role) == \App\Constants::$editor_role)
                                    <option value="{{ \App\Constants::$editor_role }}" selected> Editor </option>
                                @else
                                    <option value="{{ \App\Constants::$editor_role }}"> Editor </option>
                                @endif
                                @if(old('role', $user->role) == \App\Constants::$admin_role)
                                    <option value="{{ \App\Constants::$admin_role }}" selected> Administrator </option>
                                @else
                                    <option value="{{ \App\Constants::$admin_role }}"> Administrator </option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Profile Picture</label>
                        <div class="col-md-6">
                            <input type="file" class="form-control" name="profile_pic">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">E-Mail Address</label>
                        <div class="col-md-6">
                            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Alternative E-Mail Address</label>
                        <div class="col-md-6">
                            <input type="email" class="form-control" name="alt_email" value="{{ old('alt_email', $user->alt_email) }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Confirm Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Institution</label>
                        <div class="col-md-6">
                            <select class="form-control" name="institution">
                                @foreach ($institutions as $institution)
                                    @if(old('institution') == $institution->id)
                                        <option value="{{ $institution->id }}" selected> {{ $institution->name }} </option>
                                    @else
                                        <option value="{{ $institution->id }}"> {{ $institution->name }} </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Account status</label>
                        <div class="col-md-6">
                            <select class="form-control" name="status">
                                @if (old('status') == 'enabled')
                                    <option value="enabled" selected> Enabled </option>
                                @else
                                    <option value="enabled" selected> Enabled </option>
                                @endif
                                @if (old('status') == 'disabled' || $user->flags == \App\Constants::$disabled_flag)
                                    <option value="disabled" selected> Disabled </option>
                                @else
                                    <option value="disabled"> Disabled </option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Position</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="position" value="{{ old('position', $user->position) }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Profile URL</label>
                        <div class="col-md-6">
                            <input type="url" class="form-control" name="profile_url" value="{{ old('profile_url', $user->profile_url) }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Edit User
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <footer class="row">
        <p class="col-md-9 col-sm-9 col-xs-12 copyright">&copy; <a href="http://usman.it" target="_blank">Muhammad
                Usman</a> 2012 - 2015</p>

        <p class="col-md-3 col-sm-3 col-xs-12 powered-by">Powered by: <a
                href="http://usman.it/free-responsive-admin-template">Charisma</a></p>
    </footer>

</div><!--/.fluid-container-->

@endsection

@section('scripts')
<!-- external javascript -->

<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- library for cookie management -->
<script src="js/jquery.cookie.js"></script>
<!-- calender plugin -->
<script src='bower_components/moment/min/moment.min.js'></script>
<script src='bower_components/fullcalendar/dist/fullcalendar.min.js'></script>
<!-- data table plugin -->
<script src='js/jquery.dataTables.min.js'></script>

<!-- select or dropdown enhancer -->
<script src="bower_components/chosen/chosen.jquery.min.js"></script>
<!-- plugin for gallery image view -->
<script src="bower_components/colorbox/jquery.colorbox-min.js"></script>
<!-- notification plugin -->
<script src="js/jquery.noty.js"></script>
<!-- library for making tables responsive -->
<script src="bower_components/responsive-tables/responsive-tables.js"></script>
<!-- tour plugin -->
<script src="bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js"></script>
<!-- star rating plugin -->
<script src="js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script src="js/jquery.autogrow-textarea.js"></script>
<!-- multiple file upload plugin -->
<script src="js/jquery.uploadify-3.1.min.js"></script>
<!-- history.js for cross-browser state change on ajax -->
<script src="js/jquery.history.js"></script>
<!-- application script for Charisma demo -->
<script src="js/charisma.js"></script>


</body>

@endsection
