@extends('layout.mainlayout')
@section('content')

<div class="movie_category pt-3 px-4">
    <p class="btn btn-danger">{{$name}} <span class=" ml-2">{{ $rank_order}}</span></p>
    <i id="grid" style="font-size:28px;cursor:pointer" class="fas fa-th ml-3"></i>
    <i id="list" style="font-size:28px;cursor:pointer" class="fas fa-th-list ml-2"></i>
    <a href="/index"><p class="btn btn-dark float-right ">戻る</p></a>
</div>
<div>
    <form method="get" action="/ranking">
    <div class="form-row align-items-center ml-3">
        <div class="col-auto my-1">
        <select name="ranking_order" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
            <option selected>ランキング標準..</option>
            <option value="1">ビュー</option>
            <option value="2">評価</option>
            <option value="3">最新</option>
        </select>
        </div>
        <div class="col-auto my-1">
        <button type="submit" class="btn btn-dark">OK</button>
        </div>
    </div>
    </form>
</div>
<div class="container main_section">
@if(isset($ranking_data))
    <div class=" d-flex justify-content-center mt-3">{{$ranking_data->links()}}</div>
    <div id="list-view">
    @foreach($ranking_data as $key => $item)
    @if(!empty($item->poster_path))
        <p class="font-weight-bold mt-4 ml-3  text-secondary"><span class="ml-5">{{$key+1 }}</span>{{ strtoupper($item->original_title) }}</p>
        <div id="ranking" class="row px-4">
            <div class="col-12 col-md-3 col-lg-2">
            <a href="/play/{{$item->id}}"><img class="thumbnail" src="https://image.tmdb.org/t/p/w154{{$item->poster_path}}" ></a>
            </div>

            <div class="col-12 col-md-9 col-lg-4 mt-2 ">
                <div class="row">
                    <div class="col-12" >
                        <p><span class="btn btn-outline-success btn-sm">IMDB ID :</span><span class=" ml-2 text-danger">{{ $item->id }}</span></p>
                    </div>
                    <div class="col-12"  >
                        <p style="font-family: 'Noto Serif JP', serif;"><span class="btn btn-outline-success btn-sm">リリース : </span><span class="ml-2 text-danger">{{ date("Y", strtotime($item->release_date)) }}年{{ date("m", strtotime($item->release_date)) }}月{{ date("d", strtotime($item->release_date)) }}日</span></p>
                    </div>

                    <div class="col-12" >
                        <p>
                            <span class="btn btn-outline-success btn-sm" style="font-family: 'Noto Serif JP', serif;">映画評価 :</span>
                            <span class="fa fa-star checked text-warning"></span>
                            <span class="fa fa-star checked text-warning"></span>
                            <span class="fa fa-star checked text-warning"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="text-secondary ml-2">{{ $item->vote_average }}/10</span>
                        </p>
                    </div>

                    <div class="col-12 mt-5" >
                        <a href="/play/{{$item->id}}"><p class="btn btn-danger font-weight-bold text-light">Watch <i class="far fa-play-circle"></i></p></a>
                    </div>
                </div>
            </div>
            <div class="d-none d-md-block col-md-12 col-lg-6 mt-2">
                <p class="text-center btn btn-outline-dark">Discription <i class="fas fa-eye"></i></span><span class="font-weight-bold ml-2">{{ $item->vote_count }} 人 </span></p>
                <p>{{ $item->overview}}</p>
            </div>
        </div>
    @endif
    @endforeach
    </div>


<div id="grid-view" class="d-none">
    <div id="ranking" class="row">
        @foreach($ranking_data as $item)
        @if(!empty($item->poster_path))
            <div style="relative"  class="col-6 col-md-3 col-xl-2">
            <a href="/play/{{$item->id}}"><img class="display_img" src="https://image.tmdb.org/t/p/w500{{$item->poster_path}}"  width="100%" height="100%" ></a>
            </div>

        @endif
        @endforeach
    </div>
</div>
    
@endif
    <div class="d-flex justify-content-center">{{$ranking_data->links()}}</div>

    <p class="toggle-text text-center text-secondary  mb-0  pb-3">オンライン映画の幅広いセクションが<span class="text-danger font-weight-bold"> HQM</span> MOVIESで利用できます。登録なしで無料でオンライン映画を見ることができます。</p>
</div>
@endsection
