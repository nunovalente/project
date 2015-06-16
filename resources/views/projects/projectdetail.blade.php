@extends('app')

@section('head')

    <!-- Custom CSS -->
    <link href="{{ asset('css/portfolio-item.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
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
                @if (Auth::guest())
                    <a class="navbar-brand topnav" href="{{ route('guestlanding') }}">Home</a>
                @else
                    <a class="navbar-brand topnav" href="{{ route('authlanding') }}">Home</a>
                @endif
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="{{ route('pbrowser.index') }}">Browse Projects</a>
                    </li>
                </ul>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ url('/auth/login') }}">Login</a></li>
                        <li><a href="{{ url('/auth/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> {{ Auth::user()->name }} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">
        <!-- Portfolio Item Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{ $project->name }}
                    <br><small class="pretty-text small-text"><i>Project Responsible: {{ $project_creator }}</i></small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Portfolio Item Row -->
        <div class="row">

            <div class="col-md-8">
                <img class="img-responsive img-pdetail-main" src="{{ route('download', [$project->medias[0]->id]) }}" alt="{{ $project->name }}">
            </div>

            <div class="col-md-4">
                <h3 class="pretty-text">Project Description</h3>
                <p>{{ $project->description }}</p>
                <h3 class="pretty-text">Project Details</h3>
                <ul>
                    <li>Type:&nbsp&nbsp{{ $project->type }}</li>
                    <li>Theme:&nbsp&nbsp{{ $project->theme }}</li>
                    <li>Starting date:&nbsp&nbsp{{ $project->started_at }} <i>(yyyy-mm-dd)</i></li>
                </ul>
                <h3 class="pretty-text">Institutions involved</h3>
                <ul>
                    @foreach($institutions_involved_name as $inst)
                        <li>{{ $inst->name }}</li>
                    @endforeach
                </ul>
            </div>

        </div>
        <!-- /.row -->

        <!-- media buttons -->
        <br>
        <div class="row">
            <div class="col-lg-4">
                <div class="btn-group" role="group" aria-label="media-button-group">
                    <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-camera" aria-hidden="true"></span>&nbsp&nbspView Photos</button>
                    <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-film" aria-hidden="true"></span>&nbsp&nbspView Videos</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h2>Do you wish to be contacted by {{ $project_creator }}?</h2>
                <h4 class="space-text space-top"><a href="#">Click here</a> now to submit a contact request.</h4>
            </div>
        </div>

        <hr>

        <!-- Comment box -->
        <div class="row">
            <div class="col-lg-12 black-text">
                <form action="" method="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <textarea class="not-resizable text-area-fullscreen" name="projcomment" id="projcomment" maxlength="500" placeholder="Type a comment here (500chars max)"></textarea>
                    <br><br>
                    <button type="submit" class="btn btn-default">
                    Submit Comment
                    </button>
                </form>
            </div>
        </div>

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; IPL Project Browser</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

@endsection

@section('scripts')

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

</body>

@endsection
