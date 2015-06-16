@extends('app')

@section('head')

    <!-- Custom CSS -->
    <link href="{{ asset('css/2-col-portfolio.css') }}" rel="stylesheet">

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

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">IPL Projects
                    <small class="pretty-text space-text"> <i>Browse through a collection of projects in which IPL was involved </i> </small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-3 col-sm-4">
                <p>Results order</p>
                <select class="form-control" name="pbrowserorder">
                    <option value="responsibleab" selected> Project's responsible </option>
                    <option value="titleab"> Project Title </option>
                    <option value="datemrf"> Date (Most Recent First) </option>
                </select>
            </div>
            <div class="col-lg-4 col-sm-4">
                <p>&nbsp</p>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    </span>
                </div>
            </div>
            <div class="col-lg-2 col-sm-3">
                <p>Search filters</p>
                <select class="form-control" name="pbrowserfilter">
                    <option value="none" selected> None </option>
                    <option value="name"> Name </option>
                    <option value="type"> Type </option>
                    <option value="thematicarea"> Thematic area </option>
                    <option value="tags"> Tags </option>
                </select>
            </div>
        </div>

        <br><br><br>

        @for($i = 0; $i <= 2; $i += 2)
            @if(isset($projects[$i]))
                <!-- Projects Row -->
                <div class="row">
                    <div class="col-md-6 portfolio-item">
                        <a href="{{ route('pbrowser.show', $projects[$i]->id) }}">
                            <img class="img-responsive img-pbrowser" src="{{ route('download', [$projects[$i]->medias[0]->id]) }}" alt="{{ $projects[$i]->name }}">
                        </a>
                        <div class="project-border">
                            <h3>
                                <a href="{{ route('pbrowser.show', $projects[$i]->id) }}">{{ $projects[$i]->name }}</a>
                            </h3>
                            <p>{{ $projects[$i]->description }}</p>
                        </div>
                    </div>
                    @if(isset($projects[$i + 1]))
                        <div class="col-md-6 portfolio-item">
                            <a href="{{ route('pbrowser.show', $projects[$i + 1]->id) }}">
                                <img class="img-responsive img-pbrowser" src="{{ route('download', [$projects[$i + 1]->medias[0]->id]) }}" alt="{{ $projects[$i + 1]->name }}">
                            </a>
                            <h3>
                                <a href="{{ route('pbrowser.show', $projects[$i + 1]->id) }}">{{ $projects[$i + 1]->name }}</a>
                            </h3>
                            <p>{{ $projects[$i + 1]->description }}</p>
                        </div>
                    @endif
                </div>
                <!-- /.row -->

                <hr>
            @endif
        @endfor

        <!-- Pagination -->
        <div class="row text-center">
            <div class="col-lg-12">
                {!! $projects->render() !!}
            </div>
        </div>
        <!-- /.row -->

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
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

@endsection
