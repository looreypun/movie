@extends('layout.mainlayout')
@section('content')
@if(session()->has('delete'))
<script>
window.onload =function(){
  swal({
        title: "映画がマイリストから削除されました",
        type: "success",
        showConfirmButton: false,
        showCancelButton: false,
        timer: 3000
    });
};
</script>
{{session()->forget('delete')}}
@endif
        {{-- Liked movies list --}}
<div class="main_section px-4">
    <div class="movie_category pt-3">
        <p class="btn btn-danger"><i class="fas fa-folder"></i>　見た映画</p>
        <a href="/index"><p class="btn btn-dark  float-right ">戻る</p></a>
    </div>
        <div class="row">
        @if(!empty($liked_list))
        @foreach($liked_list as $item)
            <div class="col-6 col-md-3 col-xl-2">
            <a href="/play/{{$item['id']}}"><img class="display_img" src="https://image.tmdb.org/t/p/w500{{$item['poster_path']}}"  width="100%" height="100%" ></a>
            <a href="/remove/movie?movie_id={{$item['id']}}" class="nav-link"><p class="btn btn-danger mt-2 d-flex justify-content-center">Remove</p><a>
            </div>
        @endforeach
        @else
        <div style="height:100vh ; width: 100%">
            <p class="text-center display-4 mt-5">申し訳ございません..マイリストに映画がありません...</p>
        </div>
        @endif

        </div>
    <p class="toggle-text text-center text-secondary  mb-0  pb-3">オンライン映画の幅広いセクションが<span class="text-danger font-weight-bold"> HQM</span> MOVIESで利用できます。登録なしで無料でオンライン映画を見ることができます。</p>
</div>
@endsection
