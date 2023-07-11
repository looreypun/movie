@extends('layout.mainlayout')
@section('content')

    <div class="content" style="background:#17202A">
        <div class="center">
                <div class="d-flex justify-content-center mt-3">
                    <h1 id="error-msg" class="text-center text-secondary">
                        @if(isset($null))
                        {{$null}}
                        @endif
                        @if(isset($noresults))
                        {{$noresults}}
                        @endif
                    </h1>
                </div>
                <div class="text-center mt-2">
                <button class="btn btn-dark"><a class="nav-link text-light" href="./">検索ページへ...</a></button>
                </div>
        </div>

    </div>
@endsection
