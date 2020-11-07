<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.5.1.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li>
                                    <form action="{{url("/")}}" method="get">
                                        <input tpye="text" name="keyword" id="keyword" placeholder="keyword" value="{{$keyword}}">
                                        <button  class="btn">
                                        Search
                                        </button>
                                    </form>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                      ADD
                                    </button>
                                    <!-- <a class="nav-link" href="">{{ __('ADD') }}</a> -->
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        <!-- ADD跳窗 -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADD</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action = "{{ url("/datas/add") }}" method="POST" onsubmit="return checkaddFrm();">
                @csrf
                  <div class="modal-body">
                    <div class="form-group">
                        <label>帳號</label>
                        <input type="text" required="required" class="add-account" name="account">
                    </div>
                    <div class="form-group">
                        <label>姓名</label>
                        <input type="text" required="required" name="name">
                    </div>
                    <div class="form-group">
                        <label>性別</label>
                        <input type="radio" required="required" name="sex" value="1">
                        <span>男性</span>
                        <input type="radio" required="required" name="sex" value="0">
                        <span>女性</span>
                    </div>
                    <div class="form-group">
                        <label>生日</label>
                        <input type="date" required="required" name="birthday">
                    </div>
                    <div class="form-group">
                        <label>信箱</label>
                        <input type="email" required="required" name="email">
                    </div>
                    <div class="form-group">
                        <label>備註</label>
                        <textarea class="form-control" name="remark" rows="5"></textarea>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Save</button>
                  </div>
                </form>
            </div>
          </div>
        </div>
    </div>
</body>
</html>
