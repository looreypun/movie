<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;

class ViewDataComposer{
    public function compose(View $view){
        // variable declaring for genre
        $genres = ['アクション' => 28, 'アドベンチャー' => 12, 'アニメーション' => 16, 'バイオグラフィー' => 99,'コメディ' => 35, '犯罪' => 80, 'ドラマ' => 18, '家族' => 10751, 'ファンタジー' => 14, '歴史' => 36, 'ホラー' => 27, '音楽' => 10749, 'ミステリー' => 9648, 'ロマンス' => 10770, 'サイエンスフィクション' => 878, '戦争' => 10749, '
スリラー' => 53];
        $genres = array_flip($genres);
        $language =['日本語' => 'ja-JP','ネパール語'=>'na-NP','中国語' => 'zh-CN','英語' => 'en-US','韓国語' => 'ko-KR','ベトナム' => 'vi-VN','フランス語' => 'fr-FR','インド語'=>'hi-IN'];
        $view->with('genres',$genres)->with('language',$language);

    }
}