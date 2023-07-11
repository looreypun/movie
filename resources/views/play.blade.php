@extends('layout.mainlayout')
@section('content')
@if(session()->has('message'))
<script>
window.onload =function(){
  swal({
        title: "メッセージは正常に送信されました",
        type: "success",
        showConfirmButton: false,
        showCancelButton: false,
        timer: 3000
    });
};
</script>
{{session()->forget('message')}}
@elseif(session()->has('added'))
<script>
window.onload =function(){
  swal({
        title: "マイリストに追加されました",
        type: "success",
        showConfirmButton: false,
        showCancelButton: false,
        timer: 3000
    });
};
</script>
{{session()->forget('added')}}
@elseif(session()->has('already_added'))
<script>
window.onload =function(){
  swal({
        title: "既にこの映画は追加されてます",
        type: "warning",
        showConfirmButton: false,
        showCancelButton: false,
        timer: 3000
    });
};
</script>
{{session()->forget('already_added')}}
@endif
<div id="light-div" class="main_section">
    <div class="container">
        <a href="/index"><p class="btn btn-dark btn-sm float-right mt-2 ">戻る</p></a>
        <p class="pt-3 text-dark  ">ホーム<i class="fas fa-caret-right ml-2 text-dark"></i> 映画<i class="fas fa-caret-right ml-2 text-dark"></i><span class=" ml-2 text-success ">{{ strtoupper($play_data['title']) }}</span></p>
        @if($play_data['video_id']==null)
        <p class="text-danger">Sorry video file doesnot exist</p>
        @endif
        <div  style="position:relative" class="video-clip mt-3 ">
            <div  class="embed-responsive embed-responsive-16by9">
            <iframe id="video-play" class="advertisement mode" src="https://www.youtube.com/embed/{{ $play_data['video_id'] }} " frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div class="d-flex mt-2 px-2">
            <p class="font-weight-bold text-dark d-none d-md-block"><span class="text-primary"> WATCH </span>{{strtoupper($play_data['title'])}} <span class="btn btn-dark btn-sm text-light font-weight-bold">4K</span></p>
            @auth()
            <a href="/add?movie_id={{$play_data['id']}}"><p id="add" class="btn btn-dark btn-sm ml-2" data-toggle="tooltip" data-placement="top" title="マイリストに追加しますか?"><i class="fas fa-plus-square"></i></p></a>
            <p id="like-box-day"><i id="like" class="fas fa-thumbs-up btn btn-primary btn-sm ml-2 "> いいね {{ $total_likes }}</i></p>
            @endauth
            @guest()
            <p  class="btn btn-dark btn-sm ml-2"><i class="fas fa-plus-square"></i></p>
            <p class="ml-2" onclick="signUpToLike()"><i id="like" class="fas fa-thumbs-up btn btn-primary btn-sm ml-2 "> いいね {{ $total_likes }}</i></p>
            <script>
            function signUpToLike(){
                swal({
                    title: "最初にログインしてください",
                    type: "warning",
                    showConfirmButton: true,
                    showCancelButton: false,
                });
            }
            </script>
            @endguest

            @auth()
            <script>
                $('#like').click(function(event,index){
                $.ajax({
                url:'/like',
                type:'GET',
                data: {'movie_id':'{{ $play_data['id'] }}'},
                success: function(result) {
                    $('#like-box-day').empty();
                    $('#like-box-day').prepend('<i id="like" class="fas fa-thumbs-up btn btn-primary btn-sm ml-2 "> いいね '+ result+'</i>');
                }});});

                // $('#add').click(function(event,index){
                // $.ajax({
                // url:'/add',
                // type:'GET',
                // data: {'movie_id':'{{ $play_data['id'] }}'},
                // success: function(result) {
                //     console.log(result);
                // }});});
            </script>
            @endauth
            <p class=" font-weight-bold ml-2 "><span class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><i class="fas fa-exclamation-triangle"></i> レポート</span></p>
            <p id="nightbutton" class="ml-auto" data-toggle="tooltip" data-placement="top" title="背景を暗くする"><i class="fas fa-lightbulb text-dark"></i> <input data-size="sm" type="checkbox" checked data-toggle="toggle" data-onstyle="dark" data-on="Dark" data-off="Dark "> </p>
        </div>

        @guest()
        <div id="ad-box-light" class="bg-secondary pb-3 px-2 text-light">
            <p id="ad-close-light" style="cursor:pointer" class="text-right"><i class="fas fa-times"></i></p>
            <p class="float-right">sponsored by kyushu</p>
            <p style="font-size:24px">You May like</p>
            <div class="row ">
                <div class="col-4">
                    <img src="{{'/images/learning.jpg'}}" alt="" width="100%" height="auto">
                    <p class=".text-truncate">忙しいママから大絶賛！CMでも話題の幼児向け通信教育がすごい！</p>
                </div>
                <div class="col-4">
                    <img src="{{'/images/learn.jpg'}}" alt="" width="100%" height="auto">
                    <p class=".text-truncate">“コーチング起業”はお金をかけずに起業でき、上がった売上はほぼ利益</p>
                </div>
                <div class="col-4">
                    <img src="{{'/images/climate.jpg'}}" alt="" width="100%" height="auto">
                    <p class=".text-truncate">However, it is a nut that will need to be cracked in order to meet 2050.</p>
                </div>
            </div>
        </div>

        <script>
            $("#ad-close-light").click(function() {
            swal({
            title: 'この広告を削除しますか?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'はい'
            }).then((result) => {
            if (result.value) {
                swal(
                '削除！',
                '広告が削除されました.',
                'success'
                )
                $("#ad-box-light").addClass( "d-none" );
                setTimeout( function(){ 
                    $("#ad-box-light").removeClass( "d-none" );               
                },6000);
            }
            })
            });
        </script>
        @endguest

        <h2 class="mt-3 text-dark text-center "><span class="font-weight-bold">{{ strtoupper($play_data['title']) }}</span></h2>
        <div class="row mt-2" >
            <div class="col-sm-6  col-xl-2 ">
                <img id="poster" class="thumbnail"  src="https://image.tmdb.org/t/p/w154{{ $play_data['poster'] }}">
            </div>
            <div class="col-sm-6 col-md-12 col-xl-7 text-secondary" >
                <p>{{ $play_data['discription'] }}</p>
            </div>
            <div class="col-md-12 col-xl-3">
                <div class="row">
                    <div class="col-7 col-md-7 col-xl-12 " >
                        <p class="text-secondary font-weight-bold "><span class="btn btn-info btn-sm "> ジャンル </span><span class="font-weight-bold ml-2">@foreach($play_data['genre'] as $key => $value){{ $value['name'] }} @endforeach</span></p>
                    </div>

                    <div class="col-5 col-md-5 col-xl-12"  >
                        <p class="text-secondary font-weight-bold"><span class="btn btn-info btn-sm">リリース </span><span class="font-weight-bold ml-2">{{ date("Y", strtotime($play_data['years'])) }}年</span></p>
                    </div>

                    <div class="col-7 col-md-7 col-xl-12" >
                        <p class="text-secondary font-weight-bold"><span class="btn btn-info btn-sm">IMDB ID</span><span class="font-weight-bold ml-2">{{ $play_data['id'] }}</span></p>
                    </div>

                    <div class="col-5 col-md-5 col-xl-12" >
                        <p class="font-weight-bold">
                            <span class="btn btn-info btn-sm">映画評価</span>
                            <span class="fa fa-star checked text-warning d-none d-md-inline"></span>
                            <span class="fa fa-star checked text-warning d-none d-md-inline"></span>
                            <span class="fa fa-star checked text-warning d-none d-md-inline"></span>
                            <span class="fa fa-star d-none d-md-inline"></span>
                            <span class="fa fa-star d-none d-md-inline"></span>
                            <span class="font-weight-bold text-secondary ml-2">{{ $play_data['rating'] }}/10</span>
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <div class="d-flex justify-content-center mt-3"><h2 class="text-dark font-weight-bold">キャストメンバー</h2></div>
        <div class="row mt-3">
            @foreach($members as $member)
            <div class="col-6 col-md-3 text-center"><img class="display_img thumbnail" width="100%" height="auto" src="https://image.tmdb.org/t/p/w500{{$member['profile_path']}}" alt="">{{$member['name']}}</div>
            @endforeach
        </div>
        <p class="font-weight-bold">@if(isset($play_data['homepage']))<a href="{{$play_data['homepage']}}">HOME PAGE</a>@endif</p>
        <!-- <div class="d-flex justify-content-center mt-3"><h2 class="text-dark font-weight-bold">追加情報</h2></div> -->
        <div class="row">
            <div class="col-6 col-md-3">
                <div class="row">
                    <div class="col-12">@if(isset($extra_cast['producer']))<span class="text-danger">プロデューサー</span><br><span>  {{$extra_cast['producer'] }}</span>@endif</div>
                    <div class="col-12">@if(isset($extra_cast['director']))<span class="text-danger">監督</span><br><span>  {{$extra_cast['director'] }}</span>@endif</div>
                    <div class="col-12">@if(isset($extra_cast['story']))<span class="text-danger">ストーリーライター</span><br><span>  {{$extra_cast['story'] }}</span>@endif</div>
                    <div class="col-12">@if(isset($extra_cast['editor']))<span class="text-danger">編集者</span><br><span>  {{$extra_cast['editor'] }}</span>@endif</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="row">
                    <div class="col-12">@if(isset($play_data['budget']))<span class="text-danger">予算</span><br><span>  {{$play_data['budget']}}$</span>@endif</div>
                    <div class="col-12">@if(isset($play_data['revenue']))<span class="text-danger">収入</span><br><span>  {{$play_data['revenue'] }}</span>@endif</div>
                    <div class="col-12">@if(isset($play_data['runtime']))<span class="text-danger">ランタイム</span><br><span>  {{date('H:i',mktime(0,$play_data['runtime'])) }} m</span>@endif</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="row">
                    <div class="col-12">@if(isset($play_data['belongs_to_collection'])&&$play_data['belongs_to_collection']!= null)<span class="text-danger">コレクション</span><br><span>  {{$play_data['belongs_to_collection']['name']}}</span>@endif</div>       
                    <div class="col-12">@if(isset($play_data['production_countries']))<span class="text-danger">国</span><br>@foreach($play_data['production_countries'] as $country)<span>{{$country['name']}}</br></span>@endforeach @endif</div>
                    <div class="col-12">@if(isset($play_data['status']))<span class="text-danger">ステータス</span><br><span>  {{$play_data['status']}}</span>@endif</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="row">
                    <div class="col-12">@if(isset($play_data['popularity']))<span class="text-danger">人気</span><br><span>  {{$play_data['popularity']}}</span>@endif</div>
                    <div class="col-12">@if(isset($play_data['production_companies']))<span class="text-danger">会社</span><br>@foreach($play_data['production_companies'] as $company)<span>{{$company['name']}}</span>@endforeach @endif</div>
                </div>
            </div>
        </div>

    </div>
         @if(count($similar_data)!=0)<div class="movie_category d-flex justify-content-center mt-3"><h2 class="text-dark font-weight-bold">同様の映画</h2></div>@endif
        <div id="scroll" class="row mt-3 px-4">
            @foreach($similar_data as $item)
            <div  class="col-6 col-md-3">
            <a href="/play/{{$item->id}}"><img class="display_img" src="https://image.tmdb.org/t/p/w500{{$item->poster_path}}"  width="100%" height="100%" ></a>
            </div>
            @endforeach
        </div>
</div>
</div>


<!-- Dark Mode -->
<div id="dark-div" class="main_section d-none" style="background:black">
    <div class="container">
            <a href="/index" class="btn btn-light btn-sm  float-right mt-3 ">戻る</a>
            <p class=" pt-3 text-light  ">ホーム<i class="fas fa-caret-right ml-2 text-light"></i> 映画<i class="fas fa-caret-right ml-2 text-light"></i><span class=" ml-2 text-success ">{{ strtoupper($play_data['title']) }}</span></p>
            @if($play_data['video_id']==null)
            <p class="text-danger">Sorry video file doesnot exist</p>
            @endif
        <div style="position:relative" class="video-clip mt-3">
            <div class="embed-responsive embed-responsive-16by9">
            <iframe  src="https://www.youtube.com/embed/{{ $play_data['video_id'] }} " frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div class="d-flex mt-2 px-2">
                <p class="font-weight-bold text-light d-none d-md-block"><span class="text-primary "> WATCH </span>{{strtoupper($play_data['title'])}} <span class="btn btn-primary btn-sm text-light font-weight-bold">4K</span></p>
            @auth()
            <a href="/add?movie_id={{$play_data['id']}}"><p id="add" class="btn btn-light btn-sm ml-2" data-toggle="tooltip" data-placement="top" title="マイリストに追加しますか?"><i class="fas fa-plus-square"></i></p></a>
            <p id="dark-like-box"><i id="dark-like" class="fas fa-thumbs-up btn btn-primary btn-sm ml-2 "> いいね {{ $total_likes }}</i></p>
            @endauth
            @guest()
            <p  class="btn btn-light btn-sm ml-2"><i class="fas fa-plus-square"></i></p>
            <p onclick="signUpToLike()"><i class="fas fa-thumbs-up btn btn-primary btn-sm ml-2 data-toggle="tooltip" data-placement="top" title="SignUp to like movies""> いいね {{ $total_likes }}</i></p>
            <script>
            function signUpToLike(){
            swal({
                    title: "最初にログインしてください",
                    type: "warning",
                    showConfirmButton: true,
                    showCancelButton: false,
                });
            }
            </script>
            @endguest

            @auth()
            <script>
                $('#dark-like').click(function(event,index){
                $.ajax({
                url:'/like',
                type:'GET',
                data: {'movie_id': '{{ $play_data['id'] }}'},
                success: function(result) {
                    $('#dark-like-box').empty();
                    $('#dark-like-box').prepend('<i id="like" class="fas fa-thumbs-up btn btn-primary btn-sm ml-2 "> いいね '+ result+'</i>');
                }});})
            </script>
            @endauth
                <p class=" font-weight-bold ml-2 "><span class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><i class="fas fa-exclamation-triangle"></i> レポート</span></p>
                <p id="daybutton" class="ml-auto" data-toggle="tooltip" data-placement="top" title="背景を白くする"><i class="far fa-lightbulb text-warning"></i> <input data-size="sm" type="checkbox" checked data-toggle="toggle" data-onstyle="secondary" data-on=" Light " data-off="Light "> </p>
            </div>
        </div>
        @guest()
            <div id="ad-box-dark" class="bg-secondary pb-3 px-2 text-light ">
                <p id="ad-close-dark" style="cursor:pointer" class="text-right"><i class="fas fa-times"></i></p>
                <p class="float-right">sponsored by kyushu</p>
                <p style="font-size:24px">You May like</p>
                <div class="row ">
                    <div class="col-4">
                        <img src="{{'/images/learning.jpg'}}" alt="" width="100%" height="auto">
                        <p class=".text-truncate">忙しいママから大絶賛！CMでも話題の幼児向け通信教育がすごい！</p>
                    </div>
                    <div class="col-4">
                        <img src="{{'/images/learn.jpg'}}" alt="" width="100%" height="auto">
                        <p class=".text-truncate">“コーチング起業”はお金をかけずに起業でき、上がった売上はほぼ利益</p>
                    </div>
                    <div class="col-4">
                        <img src="{{'/images/climate.jpg'}}" alt="" width="100%" height="auto">
                        <p class=".text-truncate">However, it is a nut that will need to be cracked in order to meet 2050.</p>
                    </div>
                </div>
            </div>
            <script>
                $( "#ad-close-dark" ).click(function() {
                swal({
                title: 'この広告を削除しますか?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'はい、削除します!'
                }).then((result) => {
                if (result.value) {
                    swal(
                    '削除！',
                    '広告が削除されました.',
                    'success'
                    )
                    $("#ad-box-dark").addClass( "d-none" );
                    setTimeout( function(){ 
                        $("#ad-box-dark").removeClass( "d-none" );               
                    },6000);
                }
                })
                });
            </script>
        @endguest

        <h2 class="mt-3 text-light text-center "><span class="font-weight-bold">{{ strtoupper($play_data['title']) }}</span></h2>
        <div class="row mt-2" >
            <div class="col-sm-6  col-xl-2 ">
                <img id="poster" class="thumbnail"  src="https://image.tmdb.org/t/p/w154{{ $play_data['poster'] }}">
            </div>
            <div class="col-sm-6 col-md-12 col-xl-7 text-light" >
                <p>{{ $play_data['discription'] }}</p>
            </div>
            <div class="col-md-12 col-xl-3">
                <div class="row">
                    <div class="col-7 col-md-7 col-xl-12 " >
                        <p class=" font-weight-bold "><span class="btn btn-info btn-sm "> ジャンル </span><span class="text-light font-weight-bold ml-2">@foreach($play_data['genre'] as $key => $value){{ $value['name'] }} @endforeach</span></p>
                    </div>

                    <div class="col-5 col-md-5 col-xl-12"  >
                        <p class=" font-weight-bold"><span class="btn btn-info btn-sm">リリース </span><span class="text-light font-weight-bold ml-2">{{ date("Y", strtotime($play_data['years'])) }}年</span></p>
                    </div>

                    <div class="col-7 col-md-7 col-xl-12" >
                        <p class=" font-weight-bold"><span class="btn btn-info btn-sm">IMDB ID</span><span class="text-light font-weight-bold ml-2">{{ $play_data['id'] }}</span></p>
                    </div>

                    <div class="col-5 col-md-5 col-xl-12" >
                        <p class="font-weight-bold">
                            <span class="btn btn-info btn-sm ">映画評価</span>
                            <span class="fa fa-star checked text-warning d-none d-md-inline"></span>
                            <span class="fa fa-star checked text-warning d-none d-md-inline"></span>
                            <span class="fa fa-star checked text-warning d-none d-md-inline"></span>
                            <span class="fa fa-star text-light d-none d-md-inline"></span>
                            <span class="fa fa-star text-light d-none d-md-inline"></span>
                            <span class="font-weight-bold text-light ml-2">{{ $play_data['rating'] }}/10</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="text-light  text-center mt-3">キャストメンバー</h2>
        <div class="row mt-3">
            @foreach($members as $member)
            <div class="col-6 col-md-3 text-center text-light"><img class="display_img thumbnail" width="100%" height="auto" src="https://image.tmdb.org/t/p/w500{{$member['profile_path']}}" alt="">{{$member['name']}}</div>
            @endforeach
        </div>
        <p class="font-weight-bold">@if(isset($play_data['homepage']))<a href="{{$play_data['homepage']}}">HOME PAGE</a>@endif</p>
        <div class="row text-light">
            <div class="col-6 col-md-3">
                <div class="row">
                    <div class="col-12">@if(isset($extra_cast['producer']))<span class="text-danger">プロデューサー</span><br><span>  {{$extra_cast['producer'] }}</span>@endif</div>
                    <div class="col-12">@if(isset($extra_cast['director']))<span class="text-danger">監督</span><br><span>  {{$extra_cast['director'] }}</span>@endif</div>
                    <div class="col-12">@if(isset($extra_cast['story']))<span class="text-danger">ストーリーライター</span><br><span>  {{$extra_cast['story'] }}</span>@endif</div>
                    <div class="col-12">@if(isset($extra_cast['editor']))<span class="text-danger">編集者</span><br><span>  {{$extra_cast['editor'] }}</span>@endif</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="row">
                    <div class="col-12">@if(isset($play_data['budget']))<span class="text-danger">予算</span><br><span>  {{$play_data['budget']}}$</span>@endif</div>
                    <div class="col-12">@if(isset($play_data['revenue']))<span class="text-danger">収入</span><br><span>  {{$play_data['revenue'] }}</span>@endif</div>
                    <div class="col-12">@if(isset($play_data['runtime']))<span class="text-danger">ランタイム</span><br><span>  {{date('H:i',mktime(0,$play_data['runtime'])) }} m</span>@endif</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="row">
                    <div class="col-12">@if(isset($play_data['belongs_to_collection'])&&$play_data['belongs_to_collection']!= null)<span class="text-danger">コレクション</span><br><span>  {{$play_data['belongs_to_collection']['name']}}</span>@endif</div>       
                    <div class="col-12">@if(isset($play_data['production_countries']))<span class="text-danger">国</span><br>@foreach($play_data['production_countries'] as $country)<span>{{$country['name']}}</br></span>@endforeach @endif</div>
                    <div class="col-12">@if(isset($play_data['status']))<span class="text-danger">ステータス</span><br><span>  {{$play_data['status']}}</span>@endif</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="row">
                    <div class="col-12">@if(isset($play_data['popularity']))<span class="text-danger">人気</span><br><span>  {{$play_data['popularity']}}</span>@endif</div>
                    <div class="col-12">@if(isset($play_data['production_companies']))<span class="text-danger">会社</span><br>@foreach($play_data['production_companies'] as $company)<span>{{$company['name']}}</span>@endforeach @endif</div>
                </div>
            </div>
        </div>
        @if(count($similar_data)!=0)<div class="movie_category d-flex justify-content-center mt-3"><h2 class="text-light font-weight-bold ">同様の映画</h2></div>@endif
        <div id="scroll" class="row mt-3 px-4">
            @foreach($similar_data as $item)
            <div  class="col-6 col-md-3">
            <a href="/play/{{$item->id}}"><img class="display_img" src="https://image.tmdb.org/t/p/w500{{$item->poster_path}}"  width="100%" height="100%" ></a>
            </div>
            @endforeach
        </div>
</div>
</div>





<!-- Comment Section -->
<div id="comment-section" class="container">
    <div class="row bootstrap snippets mt-5">
        <div class="col-md-6 col-md-offset-2 col-sm-12">
            <div class="comment-wrapper">
                <div class="panel panel-info">
                    <div class="panel-heading text-secondary">
                        コメントを投稿
                    </div>
                    <div class="panel-body mt-2">
                        <form action="/comment" method="POST">
                            @csrf
                            <textarea class="form-control" name="comment" style="width:100%" placeholder="コメントを記入..." rows="5" required></textarea>
                            <input type="hidden" name="movie_id" value="{{$play_data['id']}}">
                            <br>
                            @auth()
                            <button  type="submit"  class="btn btn-info pull-right">コメント</button>
                            @endauth    
                            @guest()
                            <button type="button" onclick="signUpToCmnt()" class="btn btn-info pull-right">Post</button>
                            <script>
                            function signUpToCmnt(){
                            swal({
                                    title: "最初にログインしてください",
                                    type: "warning",
                                    showConfirmButton: true,
                                    showCancelButton: false,
                                });
                            }
                            </script>
                            @endguest
                        </form>
                        <div class="clearfix"></div>
                        <hr>
                        <ul id="cmnt-box" class="media-list">
                        @if(isset($posts)&&count($posts)>0)
                        @foreach($posts as $post)
                            <li class="media">
                                <a href="#" class="pull-left mr-3">
                                    <img src="https://bootdey.com/img/Content/user_1.jpg" alt="" class="img-circle">
                                </a>
                                <div class="media-body">
                                    <span class="text-muted pull-right">
                                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                    </span>
                                    <strong class="text-success">{{ $post->name }}</strong>
                                    <p class="text-dark">{{$post->comment}}</p>
                                    <p class="mt-0"><a href="/comment/like?commenter_id={{$post->id}}&status=like"><span><i class="far fa-thumbs-up text-primary">like</i></a></span><span><a href="/comment/dislike?commenter_id={{$post->id}}&status=dislike"><i class="far fa-thumbs-down ml-5 text-danger">dislike</i></a></span></p>
                                </div>
                            </li>
                        @endforeach
                        @endif
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <p style="position:fixed; bottom:30px; right:5px;z-index:444;opacity:0.6" class="btn btn-dark" onclick="window.scrollTo({top: 0, behavior: 'smooth'});">トップ <i class="fas fa-long-arrow-alt-up"></i></p>
   <p class="toggle-text text-center text-secondary  mb-0  pb-3">オンライン映画の幅広いセクションが<span class="text-danger font-weight-bold"> HQM</span> MOVIESで利用できます。登録なしで無料でオンライン映画を見ることができます。</p>
</div>
@endsection
