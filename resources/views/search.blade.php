@extends('layout.mainlayout')
@section('content')

  <div class="main_section px-4 pt-2">
    <div class="movie_category mt-4">
      <p><a class="btn btn-outline-dark btn-sm ml-2 float-right" onclick="window.history.back()">戻る</a></p>
      <p class="btn btn-outline-dark btn-sm ">結果 : {{strtoupper($param)}} </p>
    </div>
        <div class="d-flex justify-content-center">{{$search_data->appends(array_except(Request::query(),'search_page'))->links()}}</div>
       <div class="row mt-3">
        @foreach($search_data as $item)
            @if(!empty($item->poster_path))
            <div class="col-6 col-md-4 col-xl-2">
            <a href="/play/{{$item->id}}.'"><img class="display_img" src="https://image.tmdb.org/t/p/w500{{$item->poster_path}}"  width="100%" height="100%" ></a>
            {{-- <p style="font-size:14px" id="movie_title">{{$item->original_title}}</p> --}}
            </div>
            @endif
        @endforeach
       </div>
        <div class="d-flex justify-content-center">{{$search_data->appends(array_except(Request::query(),'search_page'))->links()}}</div>
    <p class="text-center text-dark pb-3 mb-0">A wide section of online movies are available on <span class="text-success font-weight-bold">HQM</span> MOVIES. You can watch online movies for free without registeration.</p>
</div>

@endsection
