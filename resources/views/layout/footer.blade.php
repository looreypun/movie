
<footer>
  <script src="{{ URL::asset('js/app.js')}}"></script>
        <div id="desktop_footer" class="container pt-5">
            <div class="row">
                <div class="col-sm-3 mt-2 footer-text">
                    <p> 私は場合よほどその講義らについてもののうちがするでしなら。もし毎号を尊敬観はすでにこの影響たましかもにならがくれあるにも盲動しでうば、どうにもありたろですですた。価値に見な
                    </p>
                </div>
                <div class="col-sm-3 mt-2 footer-text">
                    <p> 事実をとうていたませまい。とうてい岡田さんが返事半途そう講義にあるた性その文学私か＃「をというお附与ですたうないて、その今とうてい岡田さんが返事半途そう講義
                    </p>
                </div>
                <div class="col-2 mt-2">
                    <h4 class="btn btn-danger text-light">ヘルプ</h4>
                    <p style="cursor:pointer" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">リクエスト</p>
                    <p style="cursor:pointer" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">レポート</p>

                </div>
                <div class="col-2 mt-2">
                    <h4 class="btn btn-light ">COUNTRY</h4>
                    <a class="nav-link text-secondary py-0" href="/search?search=nepal"><p>ネパール</p></a>
                    <a class="nav-link text-secondary py-0" href="/search?search=vietnam"><p>ベトナム</p></a>
                    <a class="nav-link text-secondary py-0" href="/search?search=korea"><p>韓国</p></a>
                    <a class="nav-link text-secondary py-0" href="/search?search=japan"><p>日本</p></a>

                </div>
                <div class="col-2 mt-2">
                    <h4 class="btn btn-light ">映画ジャンル</h4>
                    <a class="nav-link text-secondary py-0" href="/index?genre=28&&name=Action"><p>アクション</p></a>
                    <a class="nav-link text-secondary py-0" href="/index?genre=53&&name=Thriller"><p>スリラー</p></a>
                    <a class="nav-link text-secondary py-0" href="/index?genre=10770&&name=Romance"><p>ロマンス</p></a>
                    <a class="nav-link text-secondary py-0" href="/index?genre=878&&name=Sci-Fi"><p>サイエンスフィクション</p></a>
                </div>
            </div>
        </div>
        <div id='mobile_footer' class="container ">
            <div class="row text-light ">
                <div class="col-4 mt-5 text-center">
                    <h4 class="btn btn-danger">ヘルプ</h4>
                    <p style="cursor:pointer" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">リクエスト</p>
                    <p style="cursor:pointer" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">レポート</p>

                </div>
                <div class="col-4 mt-5 text-center">
                    <h4 class="btn btn-light">COUNTRY</h4>
                    <a class="nav-link text-secondary py-0" href="/search?search=nepal"><p>ネパール</p></a>
                    <a class="nav-link text-secondary py-0" href="/search?search=vietnam"><p>ベトナム</p></a>
                    <a class="nav-link text-secondary py-0" href="/search?search=korea"><p>韓国</p></a>
                    <a class="nav-link text-secondary py-0" href="/search?search=japan"><p>日本</p></a>

                </div>
                <div class="col-4 mt-5 text-center">
                    <h4 class="btn btn-light">映画ジャンル</h4>
                    <a class="nav-link text-secondary py-0" href="/index?genre=28&&name=Action"><p>アクション</p></a>
                    <a class="nav-link text-secondary py-0" href="/index?genre=53&&name=Thriller"><p>スリラー</p></a>
                    <a class="nav-link text-secondary py-0" href="/index?genre=10770&&name=Romance"><p>ロマンス</p></a>
                    <a class="nav-link text-secondary py-0" href="/index?genre=878&&name=Sci-Fi"><p>Sci-サイエンスフィクション</p></a>
                </div>
            </div>
        </div>
</footer>
<!-- Report and Request Form -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="exampleModalLabel"><i class="fas fa-share-alt-square text-danger"></i> レポート/リクエスト フォーム</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/message" method="post">
            @csrf
          <div class="form-group">
            <label for="recipient-name" class="col-form-label font-weight-bold btn btn-outline-dark btn-sm">件名</label>
            <input type="text" name="subject" class="form-control mt-2" id="recipient-name " placeholder="件名を入力" required>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label font-weight-bold btn btn-outline-dark btn-sm">メッセージ:</label>
            <textarea class="form-control mt-2" name="message" id="message-text" placeholder="メッセージを入力" required></textarea>
          </div>
        <button type="submit" class="btn btn-outline-secondary"  ><i class="fas fa-paper-plane text-primary"></i> 送る</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="copyright bg-dark">
    <p class="text-light pt-2">&copy; Copy right 2020 HQM movies highquality-movies.com</p>
</div>

</body>

</html>
