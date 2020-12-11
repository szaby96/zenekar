        <!-- Sidebar  -->
        <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>Fúvószenekari Portál</h3>
                    <strong></strong>
                </div>

                <ul class="list-unstyled components">
                    <li class="{{ Request::segment(1) === 'home' || !Request::segment(1)  ? 'active' : null }}">
                        <a href="{{ url('/') }}">
                            <i class="fas fa-home"></i>
                            Kezdőlap
                        </a>
                    </li>
                    <li class="{{ (Request::segment(1) === 'posts' || Request::segment(1) === 'post') ? 'active' : null }}">
                        <a href="{{ route('posts.index')}}">
                            <i class="fas fa-newspaper"></i>
                            Posztok
                        </a>
                    </li>
                    <li class="{{ (Request::segment(1) === 'event' || Request::segment(1) === 'events') ? 'active' : null }}">
                        <a href="{{ route('events.index')}}">
                            <i class="fas fa-calendar-alt"></i>
                            Események
                        </a>
                    </li>
                    <li class="{{ (Request::segment(1) === 'profile' || Request::segment(1) === 'profiles') ? 'active' : null }}">
                        <a href="{{route('profile.index')}}">
                                <i class="fas fa-users"></i>
                                Tagok
                        </a>
                    </li>
                    <li class="{{ (Request::segment(1) === 'albums' || Request::segment(1) === 'album')  ? 'active' : null }}">
                        <a href="{{route('albums.index')}}">
                            <i class="fas fa-images"></i>
                            Képek
                        </a>
                    </li>


                        @if (Auth::check() && Auth::user()->approved_at != NULL)

                        @if (Auth::user()->instrument_id != NULL)

                            <li class="{{ (Request::segment(1) === 'sheetMusic') ? 'active' : null }}">
                                <a href="{{route('sheetMusic.index')}}">
                                    <i class="fas fa-file-alt"></i>
                                    Kották
                                </a>
                            </li>

                            <li class="{{ (Request::segment(1) === 'assignments') ? 'active' : null }}">
                                <a href="{{route('assignments.index')}}">
                                    <i class="fas fa-user-tag"></i>
                                    Szólambeosztás
                                </a>
                            </li>
                            @endif

                            @if(Auth::user()->right_id == 3)
                            <li class="{{ (Request::segment(1) === 'admin') ? 'active' : null }}">
                                <a href="#pageSubmenu3" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                    <i class="fas fa-user-shield"></i>
                                    Admin felület
                                </a>
                                <ul class="collapse list-unstyled" id="pageSubmenu3">
                                    <li>
                                        <a href="{{ route('admin.users.index')}}">Zenekari tagok listája</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.usersToApprove.index')}}">Jóváhagyandó tagok</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('compositions.index')}}">Darabok kezelése</a>
                                    </li>
                                </ul>
                            </li>
                            @endif

                        @endif
                </ul>

            </nav>

            <div id="content">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">

                        <button type="button" id="sidebarCollapse" class="btn btn-info">
                            <i class="fas fa-align-left"></i>
                        </button>
                        <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-align-justify"></i>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                             <!-- Right Side Of Navbar -->
                            <ul class="nav navbar-nav ml-auto">
                                <!-- Authentication Links -->
                                @guest
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Bejelentkezés') }}</a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}">{{ __('Regisztráció') }}</a>
                                        </li>
                                    @endif
                                @else
                                    <li class="nav-item">
                                        <img class="rounded-circle" width="35" height="35" src="{{url('/storage/avatars/'. Auth::user()->profile_picture)}}" alt="Profilkép">
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.show', Auth::user()->id) }}">{{ Auth::user()->name }} </a>
                                    </li>

                                    <li class="nav-item">
                                    <a class="nav-link" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Kijelentkezés') }}
                                    </a>
                                    </li>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>

                                @endguest
                            </ul>
                        </div>
                    </div>
                </nav>

@section('navbar-js')
<script type="text/javascript">
        $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
    });

</script>
@endsection
