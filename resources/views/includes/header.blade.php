<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                @if(Auth::check())
                    <a class="navbar-brand" href="{{ route('home') }}">Home</a>
                @else
                    <a class="navbar-brand" href="{{ route('registerUser') }}">Register</a>
                @endif
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                @if(Auth::check())
                    @if(Auth::user()->type == "ADMIN")
                        <ul class="nav navbar-nav">
                            <li @if(Request::path() == 'users') class="active" @endif><a
                                        href="{{ route('listUsers') }}">Users</a></li>

                        </ul>
                    @endif
                @endif
                @if(Auth::check())
                    <ul class="nav navbar-nav navbar-right">
                        @if(Auth::user()->type == "USER")
                        <li><a href="{{ route('viewAccount') }}">Account</a></li>
                        @endif
                        <li><a href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                @endif
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>