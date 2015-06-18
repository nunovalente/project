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
                    @if (! \Auth::guest())
                        @if (\Auth::user()->role == \App\Constants::$admin_role)
                            <li class="bg-danger"><a href="{{ route('adminpanel') }}">Admin Dashboard</a></li>
                        @else if(\Auth::user()->role == \App\Constants::$author_role)
                            <li class="bg-danger"><a href="{{ route('authorpanel') }}">Author Dashboard</a></li>
                        @endif
                    @endif
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

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{ $proj_name }}
                    <small class="pretty-text space-text"> <i>{{ $gallery }} </i> </small>
                </h1>
            </div>
        </div>

        <br><br><br>

        @if ($gallery == 'Photo Gallery')

            <!-- PHOTO CONTENT -->
            <?php $cols = 0; $m_count = 0; ?>
            @foreach ($media as $m)
                @if ($m->mime_type == 'image/jpg' || $m->mime_type == 'image/png')
                    @if ($cols == 0)
                        <div class="row">
                        <div class="col-md-6 portfolio-item">
                            <img class="img-responsive img-pbrowser" src="{{ route('download', [$m->id]) }}" alt="{{ $m->title }}">
                        </div>
                        <?php $m_count++; ?>
                    @endif
                    @if ($cols == 1)
                        <div class="col-md-6 portfolio-item">
                            <img class="img-responsive img-pbrowser" src="{{ route('download', [$m->id]) }}" alt="{{ $m->title }}">
                        </div>
                        <?php $m_count++; ?>
                        </div>
                        <?php $cols = 0; ?>
                    @else
                        <?php $cols++; ?>
                    @endif
                @endif
            @endforeach
    
            @if ($m_count % 2 != 0)
                </div>
            @endif

            @if ($m_count == 0)
                <div class="row">
                <div class="col-lg-12 center-text">
                    <h1>Sorry :(</h1>
                </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-lg-12 center-text">
                        <h3>There are no images to show about this project</h3>
                    </div>
                </div>
            @endif

        @else
            <!-- VIDEO CONTENT -->
            <?php $cols = 0; $m_count = 0; ?>
            @foreach ($media as $m)
                @if ($m->mime_type == 'video/mp4' || $m->mime_type == 'video/x-ms-wmv' || $m->mime_type == 'video/x-msvideo')
                    @if ($cols == 0)
                        <div class="row">
                        <div class="col-md-6 portfolio-item">
                            <video class="vid-pbrowser" controls>
                                <source src="{{ route('download', [$m->id]) }}">
                            </video>
                        </div>
                        <?php $m_count++; ?>
                    @endif
                    @if ($cols == 1)
                        <div class="col-md-6 portfolio-item">
                            <video class="vid-pbrowser" controls>
                                <source src="{{ route('download', [$m->id]) }}">
                            </video>
                        </div>
                        <?php $m_count++; ?>
                        </div>
                        <?php $cols = 0; ?>
                    @else
                        <?php $cols++; ?>
                    @endif
                @endif
            @endforeach
    
            @if ($m_count % 2 != 0)
                </div>
            @endif

            @if ($m_count == 0)
                <div class="row">
                <div class="col-lg-12 center-text">
                    <h1>Sorry :(</h1>
                </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-lg-12 center-text">
                        <h3>There are no videos to show about this project</h3>
                    </div>
                </div>
            @endif
        @endif

        <!-- Pagination -->
        <div class="row text-center">
            <div class="col-lg-12">
                <!-- pagination content  -->
                {!! $media->render() !!}
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
    <script src="{{ asset('js/jquery.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

</body>

@endsection
