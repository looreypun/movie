
<nav class="navbar navbar-expand-lg bg-dark navbar-dark py-1">
  <a class="navbar-brand text-light px-2" href="/"><b style="font-family:'Press Start 2P', cursive;">HQM</b></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active ml-2">
        <a class="nav-link " href="/index">
          <i class="fas fa-home text-light"></i> ホーム <span class="text-danger ">|<span>
        </a>
      </li>

      <li class="nav-item active dropdown ml-2">
        <a  class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fab fa-typo3 text-light"></i> ジャンル
        </a>
        <div class="dropdown-menu " aria-labelledby="navbarDropdown">
        @foreach($genres as $key => $value)
          <a class="dropdown-item" href="/index?genre={{$key}}&name={{$value}}">{{$value}}</a>
        @endforeach
        </div>
      </li>
      @auth()
      <li class="nav-item active dropdown ml-2">
        <a  class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-globe-americas text-light"></i> 言語
        </a>
        <div class="dropdown-menu " aria-labelledby="navbarDropdown">
        @foreach($language as $key => $value)
          <a class="dropdown-item" href="/lang/{{$value}}">{{$key}}</a>
        @endforeach
        </div>
      </li>
      @endauth
      @auth()
      <li class="nav-item active dropdown ml-2">
        <a  class="nav-link  " href="/mymovie" >
          <i class="fas fa-folder text-light"></i> マイリスト
        </a>
      </li>
      @endauth
      <li class="nav-item active dropdown ml-2">
        <a  class="nav-link  " href="/ranking" >
          <i class="fas fa-crown text-warning"></i> ランキング
        </a>
      </li>
      @guest
      <li id="login" style="cursor:pointer" class="nav-item active ml-2 btn btn-danger btn-sm mb-1 py-0"><a class="nav-link ">無料お試し</a></li>
      @endguest

    </ul>
    
    <form method="GET" action="/search" class="form-inline ml-2">
      <input class="form-control mr-sm-2"  name="search" style='font-size:12px' placeholder="作品、俳優、監督名などを入力" aria-label="検索">
      <button class="btn btn-warning text-white my-2 my-sm-0 font-weight-bold" style = "font-size:12px" type="submit"><i class="fas fa-search"></i></button>
    </form>
      @guest
      @else
    <ul class="navbar-nav ml-2">
      <li class="nav-item active text-light">
      <a class="nav-link text-light font-weight-bold" href="#">
        {{ strtoupper(Auth::user()->name)}} 
        <i  class="fas fa-sign-out-alt ml-1 px-1 py-1" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"></i>
        <!-- <img class="ml-1" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" src="{{URL::asset('/images/logout.png')}}" width="20px" height="auto" alt=""> -->
      </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </div>
      </li>
      @endguest
    </ul>
  </div>

</nav>


<!--  Nav Form  -->
<div style="display:none" class="container login-container">
    <div class="row">
        <div class="col-md-6 login-form-1">
        <form action="{{ route('login') }}" method="POST" >
          @csrf
            <h3>ログイン</h3>      
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="メールアドレス" *" required value="" />
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="暗証番号*" required value="" />
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="submit" class="btnSubmit" value="ログイン" />
                </div>
                <div class="form-group">
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
        </form>
            
        </div>
        <div class="col-md-6 login-form-2">
            <div class="login-logo">
                <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
            </div>
        <form action="{{ route('register') }}" method="POST">
          @csrf
            <h3>新規登録</h3>
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="名前 *" required value="" />
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="メール *" required value="" />
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="暗証番号 *" required value="" />
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="暗証番号認証 *" required value="" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btnSubmit" value="登録"" />
                </div>
        </form>
        </div>
    </div>
</div>

<script>
$("#login").click(function() {
  $(".login-container").slideToggle("slow");
});
</script>

<div id="overlay">
    <div id="progstat"></div>
    <div id="progress"></div>
</div>
