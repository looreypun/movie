<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;

class Logic extends Model
{
    /**
    * function  for filter data sending for viewsay
    *
    * @param    json_data  of each query
    * @return      object
    */

    public function filter_data($lists,$page_name,$path){
        $data = json_decode(json_encode($lists));
        $collection = collect($data);
        $page = Input::get($page_name,1);
        $per_page = 18;
        $total = $collection->count();
        $items = $collection->slice(($page-1)*$per_page, $per_page);
        $data = new LengthAwarePaginator($items,$total,$per_page,$page,array('path'=>$path,'pageName'=>$page_name));
        return $data;
    }

    /**
    * Function for quering data and declaring required variables
    *
    * @param    json_data  of each query
    * @return    array
    */

    public function check_get_data($movie_type){
    foreach($movie_type as $key => $value){
        if(isset($value['poster_path'])&&isset($value['original_title'])&&isset($value['backdrop_path'])
        &&isset($value['vote_average'])&&isset($value['release_date'])&&isset($value['overview'])
        &&isset($value['id'])&&isset($value['genre_ids'])&&!empty($value['poster_path'])&&!empty($value['vote_count']))
        {
            $movie_type[$key] = array_only($value, array(
                'poster_path','original_title','backdrop_path',
                'vote_average','release_date','overview','id','genre_ids','vote_count'
            ));

        }
    }
    return $movie_type;
    }

    /**
    * Function for Extracting Data from  api
    *
    * @param    key of data type
    * @return   json
    */

    public function query_tmdv($param ,$search){
        $url = 'https://api.themoviedb.org/3/';
        $api_key = '?api_key=0228e2d3e85505e47f5df753920408c9&';
        $full_url = $url.$param.$api_key.$search;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_URL,$full_url);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        $result=curl_exec($ch);
        curl_close($ch);
        $response = json_decode($result, true);
        return $response;
    }

    /**
    * Function  for searching data with id
    * @param    key of data id
    * @return   json
    */

    public function query_tmdv_id($id, $lang){
        $url = 'https://api.themoviedb.org/3/movie/';
        $api_key = '?api_key=0228e2d3e85505e47f5df753920408c9&append_to_response=videos&language=';
        $full_url = $url.$id.$api_key.$lang;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$full_url);
        curl_setopt($ch, CURLOPT_ENCODING , "gzip");
        curl_setopt($ch, CURLOPT_ENCODING, '');
        $result=curl_exec($ch);
        curl_close($ch);
        $response = json_decode($result, true);
        return $response;
    }

    public function cast_crew($id, $lang){
        $url = 'https://api.themoviedb.org/3/movie/';
        $api_key = '/credits?api_key=0228e2d3e85505e47f5df753920408c9&language=';
        $full_url = $url.$id.$api_key.$lang;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$full_url);
        curl_setopt($ch, CURLOPT_ENCODING , "gzip");
        curl_setopt($ch, CURLOPT_ENCODING, '');
        $result=curl_exec($ch);
        curl_close($ch);
        $response = json_decode($result, true);
        return $response;
    }

    /**
    * Function  for searching data with id
    * @param    type of movie
    * @return   json
    */

    public function data($type,$page_name,$path){
        $result = $this->check_get_data($type);
        $data = $this->filter_data($result ,$page_name,$path);
        return $data;
        }
}
