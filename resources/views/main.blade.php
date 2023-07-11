
@extends('layout.maingament')

@section('content')
<div class="content" style="background:#17202A">
    <div class="center">
        <h1 id="main-heading" style="font-weight:bold" class="text-center text-light display-3 mt-5"><span  class="text-warning">映画</span>を検索画面</h1>
        <div class="social d-flex justify-content-center mt-4">
            <div id="facebook" class="social-link text-center px-2"><i class="fab fa-facebook-square"></i> </<i></div>
            <div id="twitter" class="social-link text-center ml-2 px-2"><i class="fab fa-twitter-square"></i> </<i></div>
            <div id="instagram" class="social-link text-center ml-2 px-2"><i class="fab fa-instagram"></i> </<i></div>
        </div>
        <form method="GET" action="/search">
            <div class="d-flex justify-content-center mt-4">
                <input type="text" class="index-input form-control text-center" name="search" placeholder="作品、俳優、監督名などを入力">
            </div>
            <p class="text-center  mt-4"><button style="padding:5px 20px" type="submit" class="btn btn-primary text-light">検索</button></p>
            
        <div class="text-center mt-2">
            <button class="btn btn-success"><a class="nav-link text-light" href="./index">ホームーページ　へ</a></button>
        </div>
            <p class="text-center text-light mt-2">ツイッターで接続... <i class="fab fa-twitter-square text-info" ></i></p>

        </form>
        <div class="d-flex justify-content-center mt-2" >
            <p style="font-size:14px" class="btn btn-secondary mr-2 py-2"><i class="fab fa-app-store-ios  ml-1 "></i>　ダウンロード</p>
            <p style="font-size:14px" class="btn btn-secondary ml-2 py-2"><i class="fab fa-google-play  ml-1">　ダウンロード</i></p>
        </div>
    </div>
</div>
@endsection()
