@extends('app')
@section('head')

<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="css/landing-page.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

@endsection

@section('content')

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
                <a class="navbar-brand topnav" href="#">Home</a>
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="#recentprojects">Recent Projects</a>
                    </li>
                    <li>
                        <a href="{{ route('pbrowser.index') }}">Browse Projects</a>
                    </li>
                </ul>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                <form class="navbar-form navbar-left" role="search">
                  <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search Projects">
                  </div>
                  <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                </form>
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

<!-- Header -->
<div class="intro-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="intro-message">
                    <h1>IPL Project Browser</h1>
                    <h3>AINet PL2</h3>
                    <hr class="intro-divider">
                    <ul class="list-inline intro-social-buttons">
                        <li>
                            <i class="fa-fw"></i> <span class="network-name">Nuno Valente 2130127</span></a>
                        </li>
                        <li>
                            <i class="fa-fw"></i> <span class="network-name">Eduardo Andrade 2131105</span></a>
                        </li>
                        <li>
                            <i class="fa-fw"></i> <span class="network-name">Andreia Francisco 2121376</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 col-centered">
                <div id="carosel-landing-page" class="carousel slide carousel-border" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carosel-landing-page" data-slide-to="0" class="active"></li>
                        <li data-target="#carosel-landing-page" data-slide-to="1"></li>
                        <li data-target="#carosel-landing-page" data-slide-to="2"></li>
                    </ol>
    
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                        <img src="img/img1.png" alt="altimg1">
                            <div class="carousel-caption">
                            ...
                            </div>
                        </div>
                        <div class="item">
                            <img src="img/img2.png" alt="altimg2">
                            <div class="carousel-caption">
                            ...
                            </div>
                        </div>
                        <div class="item">
                            <img src="img/img3.png" alt="altimg2">
                            <div class="carousel-caption">
                            ...
                            </div>
                        </div>
                    </div>
                    <!-- Controls -->
                    <a class="left carousel-control" href="#carosel-landing-page" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carosel-landing-page" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->
</div>
<!-- /.intro-header -->

<!-- Page Content -->

<a  name="recentprojects"></a>
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-6">
                <hr class="section-heading-spacer">
                <div class="clearfix"></div>
                <h2 class="section-heading">Most Recent<br>Projects</h2>
                <p class="lead">Browse through recently updated projects!</p>
            </div>
            <div class="col-lg-5 col-lg-offset-2 col-sm-6">
                <div class="list-group list-group-border space-top">
                    <a href="#recentprojects" class="list-group-item">
                        <h4>Titulo do projeto</h4>
                        <p><i>Author:</i></p>
                    </a>
                    <a href="#recentprojects" class="list-group-item">
                        <h4>Titulo do projeto</h4>
                        <p><i>Author:</i></p>
                    </a>
                    <a href="#recentprojects" class="list-group-item">
                        <h4>Titulo do projeto</h4>
                        <p><i>Author:</i></p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->
</div>
<!-- /.content-section-a -->

<a  name="getintouch"></a>
<div class="banner">

    <div class="container">

        <div class="row">
            <div class="col-lg-6">
                <h2>Connect with the authors:</h2>
            </div>
            <div class="col-lg-6">
                <ul class="list-inline banner-social-buttons">
                    <li>
                        <a href="mailto:2130127@my.ipleiria.pt" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> <span class="network-name">Nuno</span></a>
                    </li>
                    <li>
                        <a href="mailto:2131105@my.ipleiria.pt" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> <span class="network-name">Eduardo</span></a>
                    </li>
                    <li>
                        <a href="mailto:2121376@my.ipleiria.pt" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> <span class="network-name">Andreia</span></a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
    <!-- /.container -->

</div>
<!-- /.banner -->

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-inline">
                    <li>
                        <a href="#">Home</a>
                    </li>
                    <li class="footer-menu-divider">&sdot;</li>
                    <li>
                        <a href="#recentprojects">Recent Projects</a>
                    </li>
                    <li class="footer-menu-divider">&sdot;</li>
                    <li>
                        <a href="{{ route('pbrowser.index') }}">Browse Projects</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

@endsection

@section('scripts')

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

@endsection
