<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img width="36" src="{{ asset('images/logo.png') }}" alt="网站图标">
            cjw的小站
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link
                        @if(Route::is('topics.index') && Request::query('category_id') == '') active @endif"
                        href="{{ route('topics.index') }}">
                        全部
                    </a>
                </li>
                @foreach(\App\Models\Category::all() as $category)
                    <li class="nav-item">
                        <a class="nav-link
                            @if(Route::is('topics.index') && Request::query('category_id') == $category->id) active @endif"
                            href="{{ route('topics.index', ['category_id' => $category->id]) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach

                <form class="form-inline ml-2" action="{{ route('topics.index') }}">
                    <input name="q" value="{{ Request::query('q') }}" class="form-control" type="text" placeholder="搜索">
                    <input type="hidden" name="category_id" value="{{ Request::query('category_id') }}">
                    <button class="btn" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('github.login') }}">
                            <i class="fa fa-github"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('topics.create') }}">
                            <i class="fa fa-plus mr-2"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img width="32" class="mr-2" src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('users.edit', Auth::user()) }}">
                                <i class="fa fa-user-edit mr-2"></i>
                                编辑资料
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               data-fn="confirm" data-title="确定退出？">
                                <i class="fa fa-sign-out mr-2"></i>
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
