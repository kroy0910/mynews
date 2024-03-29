<?php

namespace App\Http\Controllers\Admin;

# 最初にterminalで下記コマンドを実行（環境変数のjsonファイルを設定）
# export GOOGLE_APPLICATION_CREDENTIALS="vision_api_key.json"
# terminalではなくphpのコード内で環境変数の変更
putenv('GOOGLE_APPLICATION_CREDENTIALS=/home/ec2-user/environment/mynews/vision_api_key.json');

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News;
use App\History;
use Carbon\Carbon;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;


class NewsController extends Controller
{
  public function add()
  {
      return view('admin.news.create');
  }

  public function create(Request $request)//どんな引数かを指定できる（してる）
  {
      // Varidationを行う
      $this->validate($request, News::$rules);

      $news = new News;
      $form = $request->all();

      // フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
      if (isset($form['image'])) {
        $path = $request->file('image')->store('public/image');
        $news->image_path = basename($path);
        
         //google vision api
        $client = new ImageAnnotatorClient();
        $response = $client->labelDetection($client->createImageObject(file_get_contents($request->image)));
        
        if(is_null($response->getError())) {
            \Debugbar::info($response);
            $annotations = $response->getLabelAnnotations();
            \Debugbar::info($annotations);
            $news->fill(['score'=>$annotations[0]->getScore(), 'anno_res'=>$annotations[0]->getDescription()]);
        } else {
            \Debugbar::info($response->getError());
            }
      } else {
        $news->image_path = null;
      }

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);//csrfの問題で_tokenを削除しないとNGになる
      // フォームから送信されてきたimageを削除する
      //unset($form['image']);

      // データベースに保存する
      $news->fill($form);
      $news->save();//DBにセーブ//コントローラーでどこまで保存するかを書く必要はない（美しくない）

      return redirect('admin/news');//指定しなければデフォルトget
  }
  
  public function index(Request $request)
  {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          $posts = News::where('title', $cond_title)->get();
      } else {
          // それ以外はすべてのニュースを取得する
          $posts = News::all();
      }
      return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }
  public function edit(Request $request)
  {
      // News Modelからデータを取得する
      $news = News::find($request->id);
      if (empty($news)) {
        abort(404);
      }
      return view("admin.news.edit", ["news_form" => $news]);
  }
  
  public function update(Request $request)
  {
      // Validationをかける
      $this->validate($request, News::$rules);
      // News Modelからデータを取得する
      $news = News::find($request->id);
      // 送信されてきたフォームデータを格納する
      $news_form = $request->all();
      
      if($request->remove == 'true'){
          $news_form['image_path'] = null;
      } elseif ($request->file('image')){
          $path = $request->file('image')->store('public/image');
          $news_form['image_path'] = basename($path);
      } else {
          $new_form['image_path'] = $news->image_path;
      }
      
      unset($news_form['_token']);
      unset($news_form['image']);
      unset($news_form['remove']);
      //該当するデータを上書きして保存する
      $news->fill($news_form)->save();
      
      $history = new History;
      $history->news_id = $news->id;
      $history->edited_at = Carbon::now();
      $history->save();
      
      return redirect('admin/news');
  }
  public function delete(Request $request)
  {
    // 該当するNews Modelを取得
    $news = News::find($request->id);
    // 削除する
    $news->delete();
    return redirect("admin/news/");
  }
}