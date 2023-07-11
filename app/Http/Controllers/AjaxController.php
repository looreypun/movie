<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Logic;

class AjaxController extends Controller
{
    public function trending(){
        $logic = new Logic();
        $trending = $logic->query_tmdv('trending/movie/week','sort_by=vote_average.desc&page=1')['results'];
        $trending_data = $logic ->data($trending, 'trending_page','index');
        return $trending_data;
    }
    public function popular(){
        $logic = new Logic();
        $popular = $logic->query_tmdv('discover/movie','primary_release_date.gte=2010-10-15&primary_release_date.lte=2014-11-28&sort_by=popularity.desc&page=1')['results'];
        $popular_data = $logic ->data($popular,'popular_page','index');
        return $popular_data;
    }
    public function latest(){
        $logic = new Logic();
        $now_playing = $logic->query_tmdv('discover/movie','primary_release_date.gte=2019-07-15&primary_release_date.lte=2019-12-20&page=1')['results'];
        $now_playing_data = $logic->data($now_playing, 'now_playing_page','index');
        return $now_playing_data;
    }
    public function commingSoon(){
        $logic = new Logic();
        $upcoming = $logic->query_tmdv('movie/upcoming','sort_by=popularity&page=1')['results'];
        $upcoming_data = $logic->data($upcoming,'upcoming_page','index');
        return $upcoming_data;
    }

}
