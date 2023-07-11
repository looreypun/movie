<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Logic;

class MoreController extends Controller
{
    public function trending(){
        $logic = new Logic();
        for($i=1; $i<5; $i++){
        $data[$i] = $logic->query_tmdv('trending/movie/week','sort_by=vote_average.desc&page='.$i)['results'];
        }
        $result = array_merge($data[1],$data[2],$data[3],$data[4]);
        $trending = $result;
        $trending_data = $logic ->data($trending, 'trending_page','trendingLink');
        return view('more')->with('trending_data',$trending_data)->with('name','トレンド');
    }
    public function popular(){
        $logic = new Logic();
        for($i=1; $i<8; $i++){
        $data[$i] = $logic->query_tmdv('discover/movie','primary_release_date.gte=2001-10-15&primary_release_date.lte=2017-12-20&sort_by=popularity.desc&page='.$i)['results'];
        }
        $result = array_merge($data[1],$data[2],$data[3],$data[4]);
        $popular = $result;
        $popular_data = $logic ->data($popular,'popular_page','popularLink');
        return view('more')->with('popular_data',$popular_data)->with('name','ポピュラー');
    }
    public function latest(){
        $logic = new Logic();
        for($i=1; $i<8; $i++){
        $data[$i] = $logic->query_tmdv('discover/movie','primary_release_date.gte=2018-10-15&primary_release_date.lte=2019-11-28&page='.$i)['results'];
        }
        $result = array_merge($data[1],$data[2],$data[3],$data[4]);
        $now_playing = $result;
        $now_playing_data = $logic->data($now_playing, 'now_playing_page','latestLink');
        return view('more')->with('now_playing_data',$now_playing_data)->with('name','上映中の映画');
    }
    public function commingSoon(){
        $logic = new Logic();
        for($i=1; $i<8; $i++){
        $data[$i] = $logic->query_tmdv('movie/upcoming','sort_by=popularity&page='.$i)['results'];
        }
        $result = array_merge($data[1],$data[2],$data[3],$data[4]);
        $upcoming = $result;
        $upcoming_data = $logic->data($upcoming,'upcoming_page','upcomingLink');
        return view('more')->with('upcoming_data',$upcoming_data)->with('name','今週公開の映画');
    }
    public function dramas(){
        $logic = new Logic();
        for($i=1; $i<8; $i++){
        $data[$i] = $logic->query_tmdv('discover/movie','with_genres=18&primary_release_year=2012&page='.$i)['results'];
        }
        $result = array_merge($data[1],$data[2],$data[3],$data[4]);
        $dramas = $result;
        $dramas_data = $logic->data($dramas,'dramas_page','dramasLink');
        return view('more')->with('dramas_data',$dramas_data)->with('name','ドラマ');
    }

}