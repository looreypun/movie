<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Logic;
use App\User;
use App\Message;
use App\Comment;
use App\Like;
use App\LikedUser;
use App\CommentLikeDislikeStatus;
use Session;
use DB;
use Auth;

class MainController extends Controller
{

    public function main(){
        return view('main');
    }

    public function index(Request $request)
    { 
        $lang = $request->session()->get('lang', 'en-US');
        $logic = new Logic();
        $trending = $logic->query_tmdv('trending/movie/week','sort_by=vote_average.desc&page=1&language='.$lang)['results'];
        $popular = $logic->query_tmdv('discover/movie','primary_release_date.gte=2001-10-15&primary_release_date.lte=2017-12-20&sort_by=popularity.desc&page=1&language='.$lang)['results'];
        $upcoming = $logic->query_tmdv('movie/upcoming','sort_by=popularity&page=1&language='.$lang)['results'];
        $dramas = $logic->query_tmdv('discover/movie','with_genres=18&primary_release_year=2012&page=1&language='.$lang)['results'];
        $now_playing = $logic->query_tmdv('discover/movie','primary_release_date.gte=2019-07-15&primary_release_date.lte=2019-12-20&page=1&language='.$lang)['results'];
        if($request->genre){
            $genre_param = $request->input('genre');
            for($i=1; $i<5; $i++){
            $data[$i] = $logic->query_tmdv('discover/movie','with_genres='.$genre_param.'&page='.$i.'&language='.$lang)['results'];
            }
            $result = array_merge($data[1],$data[2],$data[3],$data[4]);
            $genre = $result;
            $genre_name = $request->input('name');
            $genre_data = $logic->data($genre,'genre_page','/index');
        }else{
            $genre_data = null;
            $genre_name = null;
        }


        $carousel_data = $logic ->data($trending,'carousel_page','index');
        $popular_data = $logic ->data($popular,'popular_page','index');
        $trending_data = $logic ->data($trending,'trending_page','index');
        $now_playing_data = $logic ->data($now_playing,'now_playing_page','index');
        $dramas_data = $logic ->data($dramas,'daramas_page','index');
        $upcoming_data = $logic ->data($upcoming,'upcoming_page','index');
        return view('index',
        compact('carousel_data','popular_data','trending_data','now_playing_data','dramas_data','genre_data','genre_name','upcoming_data','lang'));
    }


    public function play(Request $request, $movie_id){
        $lang = $request->session()->get('lang', 'en-US');
        $logic = new Logic();
        $id = $movie_id;
        $results_default = $logic->query_tmdv_id($id,'en-US');
        foreach($results_default as $result){
            if(!empty($results_default['videos']['results'])){
                $video = $results_default['videos']['results'][0]['key'];
            }else{
                $video=null;
            }
        }
        $member_results = $logic->cast_crew($id, $lang);
        for($i=0; $i<4; $i++){
            $members[] = $member_results['cast'][$i];
        }

        $created_members = $logic->cast_crew($id, $lang)['crew'];
        foreach($created_members as $member){
            if($member['job']=='Director'){
                $extra_cast['director']= $member['name'];
            }
            if($member['job']=='Producer'){
                $extra_cast['producer'] = $member['name'];
            }
            if($member['job']=='Editor'){
                $extra_cast['editor'] = $member['name'];
            }
            if($member['job']=='Story'){
                $extra_cast['story'] = $member['name'];
            }
        }
        $results = $logic->query_tmdv_id($id, $lang);
        $play_data = [];
        foreach($results as $result){
            
            $play_data['poster'] = $results['poster_path'];
            $play_data['title'] = $results['title'];
            $play_data['years'] = $results['release_date'];
            $play_data['discription'] = $results['overview'];
            $play_data['background'] = $results['backdrop_path'];
            $play_data['rating'] = $results['vote_average'];
            $play_data['genre'] = $results['genres'];
            $play_data['homepage'] = $results['homepage'];
            $play_data['status'] = $results['status'];
            $play_data['production_companies'] = $results['production_companies'];
            $play_data['production_countries'] = $results['production_countries'];
            $play_data['belongs_to_collection'] = $results['belongs_to_collection'];
            $play_data['budget'] = $results['budget'];
            $play_data['runtime'] = $results['runtime'];
            $play_data['revenue'] = $results['revenue'];
            $play_data['popularity'] = $results['popularity'];
            $play_data['id'] = $id;    

        }

        $play_data['video_id'] = $video;
        $play_data['genre'] = array_slice($play_data['genre'],1,1);

        $similar = $logic->query_tmdv('movie/'.$play_data['id'].'/similar',null)['results'];
        $similar_lists = $logic->check_get_data($similar);
        $similar_data = $logic->filter_data($similar_lists ,'similar_page','play');

        $posts = Comment::where('movie_id',$movie_id)->get();
        $total_likes = DB::table('likes')->where('movie_id',$movie_id)->value('count');

        return view('play')->with('play_data',$play_data)->with('similar_data',$similar_data)
                            ->with('id',$play_data['id'])->with('posts',$posts)->with('total_likes',$total_likes)
                            ->with('lang',$lang)->with('members',$members)->with('extra_cast',$extra_cast);


    }

    public function search(Request $request){
        $lang = $request->session()->get('lang', 'en-US');
        $logic = new Logic();
        $param = $request->search;
        $param_movie = $param;
        $param_person = explode(' ',$param);
        $search_movie = $logic->query_tmdv('search/movie','query="'.$param_movie.'"')['results'];
        if(count($param_person)>1){
            $search_person = $logic->query_tmdv('search/person','query="'.$param_person[0].'+'.$param_person[1].'"')['results'];
            if(!empty($search_person)){
                $search_person = $search_person[0]['known_for'];
            }else{
                $search_person=[];
            }
        }else{
            $search_person=[];
        }
        $search = array_merge($search_movie,$search_person);
        $search_lists = $logic->check_get_data($search);
        $search_data = $logic->filter_data($search_lists,'search_page','search');
        $null = '映画の名前を入力してください';
        $noresults = '申し訳ございません映画が見つかりません';
        if(!$param)
        {
            return view('errors/errors')->withNull($null);
            exit;
        }
        if(!$search_data->total())
        {   return view('errors/errors')->withNoresults($noresults);
            exit;
        }
        return view('search',compact('search_data','null','noresults','param'));
    }

    public function message(Request $request){
       $messages = new Message();
       $messages->subject = $request->subject;
       $messages->message = $request->message;
       $messages->save();
       Session::put('message','sent');
       return back();
    }
    public function comment(Request $request){

        $movie_id = $request->movie_id;
        $comments = new Comment();
        $name = Auth::user()->name;
        $comments->name = $name;
        // $comments->comment = $this->stringToEmoji($request->comment);
        $comments->comment = $request->comment;
        $comments->movie_id = $movie_id;
        $comments->save();
        Session::put('comment','message');
        return redirect()->back();
    }
 
    public function like(Request $request){
        $movie_id = $request->movie_id;
        $likes_data = DB::table('likes')->where('movie_id',$movie_id)->first();
        $likes_now = DB::table('likes')->where('movie_id',$movie_id)->value('count');

        if($likes_data){
            return $likes_now;
        }

        if (is_null($likes_data)) {
            $likes = new Like();
            $likes->movie_id = $movie_id;
            $likes->count = 1;
            $likes->save();

        }else{
        DB::table('likes')->where('movie_id', $movie_id)->update(['count' => DB::raw('count+1')]);    
        }
        $total_likes = DB::table('likes')->where('movie_id',$movie_id)->value('count');
        Session::put('like','message');
       return $total_likes;
    }
    public function add(Request $request){
        $movie_id = $request->movie_id;
        $added = LikedUser::where('user_name',Auth::user()->name)->where('movie_id',$movie_id)->first();
        if($added){
            Session::put('already_added','message');
            return back();
        }

        if (!$added) {
            $addUser = new LikedUser();
            $addUser->user_name = Auth::user()->name;
            $addUser->movie_id = $movie_id;
            $addUser->save();
            Session::put('added','message');
            return back();
        }
        // Session::put('like','message');
      
    }
    public function remove_movie(Request $request){
        $movie_id = $request->movie_id;
        $movie = LikedUser::where('user_name',Auth::user()->name)->where('movie_id',$movie_id)->delete();
        Session::put('delete','message');
        return back();
    
        // Session::put('like','message');
      
    }

    public function myMovie(Request $request){
        $lang = $request->session()->get('lang', 'en-US');
        $logic = new Logic();
        $my_movie_ids = DB::table('liked_users')->where('user_name',Auth::user()->name)->get();
        // dd(count($my_movie_ids));
        if(count($my_movie_ids)>0){
            foreach($my_movie_ids as $list){
                $my_movie_list[] = $list->movie_id;
            }
            foreach($my_movie_list as $data){
                $liked_list[] = $logic->query_tmdv_id($data,$lang);
            }
            return view('mymovielist')->with('liked_list',$liked_list)->with('lang',$lang);
        }
        $liked_list = null;
        return view('mymovielist')->with('liked_list',$liked_list)->with('lang',$lang);
        

    }
    public function ranking(Request $request){
        $order = $request->ranking_order;
        $lang = $request->session()->get('lang', 'en-US');
        $logic = new Logic();

        $result1 = $logic->query_tmdv('trending/movie/week','sort_by=vote_average.desc&language='.$lang)['results'];
        $result2 = $logic->query_tmdv('discover/movie','primary_release_date.gte=2001-10-15&primary_release_date.lte=2017-12-20&sort_by=popularity.desc&language='.$lang)['results'];
        $result3= $logic->query_tmdv('discover/movie','primary_release_date.gte=2018-10-15&primary_release_date.lte=2019-11-28&language='.$lang)['results'];
        $result4 = $logic->query_tmdv('movie/upcoming','sort_by=popularity&language='.$lang)['results'];
        $ranking = array_merge($result1,$result2,$result3,$result4);

        if($order == 2){
            $sort = [];
            foreach($ranking as $k=>$v) {
                $sort['vote_average'][$k] = $v['vote_average'];
            }
            array_multisort($sort['vote_average'], SORT_DESC, $ranking);
            $ranking_data = $logic->data($ranking,'ranking_page','ranking');
            return view('ranking')->with('ranking_data',$ranking_data)->with('name','ランキング : ')->with('rank_order','評価順');
        }elseif($order == 3){
            $sort = [];
            foreach($ranking as $k=>$v) {
                $sort['release_date'][$k] = $v['release_date'];
            }
            array_multisort($sort['release_date'], SORT_DESC, $ranking);
            $ranking_data = $logic->data($ranking,'ranking_page','ranking');
            return view('ranking')->with('ranking_data',$ranking_data)->with('name','ランキング : ')->with('rank_order','最新順');
        }else{
            $sort = [];
            foreach($ranking as $k=>$v) {
                $sort['vote_count'][$k] = $v['vote_count'];
            }
            array_multisort($sort['vote_count'], SORT_DESC, $ranking);
            $ranking_data = $logic->data($ranking,'ranking_page','ranking');
            return view('ranking')->with('ranking_data',$ranking_data)->with('name','ランキング : ')->with('rank_order','ビュー順');
        }
    }

    public function commentLike(Request $request){
        $commenter_id = $request->commenter_id;
        $user_id = Auth::user()->id;
        $status = $request->status;
        $likeDislike = new CommentLikeDislikeStatus();
        if($status=='like'){
            $likeDislike->commenter_id = $commenter_id;
            $likeDislike->user_id = $user_id;
            $likeDislike->like_status = 'liked';
            $likeDislike->dislike_status = 0;
            $likeDislike->save();
        }elseif($status == 'dislike'){
            $likeDislike->commenter_id = $commenter_id;
            $likeDislike->user_id = $user_id;
            $likeDislike->like_status = 0;
            $likeDislike->dislike_status = 'disliked';
            $likeDislike->save();
        
        }

        return back();
    }     


    public function language($lang){
        Session::put('lang',$lang);
        return redirect()->back();
    }     
}