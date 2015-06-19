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
                <ul class="nav navbar-nav navbar-left">
                    @if (isset($user) && isset($roles))
                        @if ($user->role == $roles[0])
                            <li class="bg-danger"><a href="{{ route('adminpanel') }}">Admin Dashboard</a></li>
                        @elseif($user->role == $roles[2])
                            <li class="bg-danger"><a href="{{ route('authorpanel') }}">Author Dashboard</a></li>
                        @elseif($user->role == $roles[1])
                            <li class="bg-danger"><a href="{{ route('editorpanel') }}">Editor Dashboard</a></li>
                        @endif
                    @endif
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

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">IPL Projects
                    <small class="pretty-text space-text"> <i>Browse through a collection of projects in which IPL was involved </i> </small>
                </h1>
            </div>
        </div>
        <!-- /.row -->
        <form class="inline" method="GET" action="{{ route('pbrowser.index') }}">
            <div class="row">
                <div class="col-lg-3 col-sm-4">
                    <p>Results order</p>
                    <select class="form-control" name="pbrowserorder" onchange="this.form.submit();">
                        @if (Input::get('pbrowserorder') == 'titleab')
                            <option value="titleab" selected> Project Title </option>
                        @else
                            <option value="titleab"> Project Title </option>
                        @endif
                        @if (Input::get('pbrowserorder') == 'responsibleab')
                            <option value="responsibleab" selected> Project's responsible </option>
                        @else
                            <option value="responsibleab"> Project's responsible </option>
                        @endif
                        @if (Input::get('pbrowserorder') == 'datemrf')
                            <option value="datemrf" selected> Date (Most Recent First) </option>
                        @else
                            <option value="datemrf"> Date (Most Recent First) </option>
                        @endif                        
                    </select>
                </div>
                <div class="col-lg-4 col-sm-4">
                    <p>&nbsp</p>
                    <div class="input-group">
                        <input type="text" name="searchbox" class="form-control" value="{{ Input::get('searchbox') }}" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default inline" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                        </span>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-4">
                    <p>Search filters</p>
                    <select class="form-control" name="pbrowserfilter">
                        @if (Input::get('pbrowserfilter') == 'name')
                            <option value="name" selected> Name </option>
                        @else
                            <option value="name"> Name </option>
                        @endif
                        @if (Input::get('pbrowserfilter') == 'description')
                            <option value="description" selected> Description </option>
                        @else
                            <option value="description"> Description </option>
                        @endif
                        @if (Input::get('pbrowserfilter') == 'responsible')
                            <option value="responsible" selected> Responsible People </option>
                        @else
                            <option value="responsible"> Responsible People </option>
                        @endif
                        @if (Input::get('pbrowserfilter') == 'startdate')
                            <option value="startdate" selected> Starting Date (yyyy-mm-dd)</option>
                        @else
                            <option value="startdate"> Starting Date (yyyy-mm-dd)</option>
                        @endif
                        @if (Input::get('pbrowserfilter') == 'type')
                            <option value="type" selected> Type </option>
                        @else
                            <option value="type"> Type </option>
                        @endif
                        @if (Input::get('pbrowserfilter') == 'thematicarea')
                            <option value="thematicarea" selected> Thematic area </option>
                        @else
                            <option value="thematicarea"> Thematic area </option>
                        @endif
                    </select>
                </div>
            </div>
        </form>

        <br><br><br>

        <!-- CONTENT -->

        @if ($error_msg == true)
            <div class="row">
                <div class="col-lg-12 center-text">
                    <h1>Sorry :(</h1>
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-lg-12 center-text">
                    <h3>No results match your search term</h3>
                    <!-- Footer -->
                    <footer>
                        <p>Copyright &copy; IPL Project Browser</p>
                    </footer>
                </div>
            </div>
        @else
            @for($i = 0; $i <= 2; $i += 2)
                @if(isset($projects[$i]))
                    <!-- Projects Row -->
                    <div class="row row-a">
                        <div class="col-md-6 portfolio-item">
                            <a href="{{ route('pbrowser.show', $projects[$i]->id) }}">
                                @if (isset($projects[$i]->medias[0]) && $projects[$i]->medias[0]->state == \App\Constants::$approved_state)
                                    <img class="img-responsive img-pbrowser" src="{{ route('download', [$projects[$i]->medias[0]->id]) }}" alt="{{ $projects[$i]->name }}">
                                @else
                                    <img class="img-responsive img-pbrowser" src="" alt="{{ $projects[$i]->name }}">
                                @endif
                            </a>
                            <h3>
                                <a href="{{ route('pbrowser.show', $projects[$i]->id) }}">{{ $projects[$i]->name }}</a>
                            </h3>
                            <p>{{ $projects[$i]->description }}</p>
                        </div>
                        @if(isset($projects[$i + 1]))
                            <div class="col-md-6 portfolio-item">
                                <a href="{{ route('pbrowser.show', $projects[$i + 1]->id) }}">
                                    @if (isset($projects[$i + 1]->medias[0]) && $projects[$i + 1]->medias[0]->state == \App\Constants::$approved_state)
                                        <img class="img-responsive img-pbrowser" src="{{ route('download', [$projects[$i + 1]->medias[0]->id]) }}" alt="{{ $projects[$i + 1]->name }}">
                                    @else
                                        <img class="img-responsive img-pbrowser" src="" alt="{{ $projects[$i + 1]->name }}">
                                    @endif
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
                    {!! $projects->appends(Input::except('page'))->render() !!}
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
        @endif

    </div>
    <!-- /.container -->

@endsection

@section('scripts')

    <!-- jQuery -->
    <script src="{{ asset('js/jquery.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

</body>

@endsection
