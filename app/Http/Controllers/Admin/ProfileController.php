<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;
use App\ProfHistory;
use Carbon\Carbon;

class ProfileController extends Controller
{
    //課題4 ProfileControllerの作成と以下のactionの追加
    public function add(Request $request){
        $profile = Profile::all()->sortByDesc('updated_at');
        if(!empty($profile)){
            // 更新履歴の一番新しいデータを格納
            $prof_form =$profile->shift();
        }
        //todo create画面のviewに一つ前の入力データと更新履歴（prof_history)を表示したい
        return view("admin.profile.create",["prof_form"=>$prof_form]);
    }
    #add actionはweb.phpからProfileController@addと呼び出し、resources/viewsのadmin/profile/create.blade.phpを表示させる
    public function create(Request $request)
    {
      // Varidationを行う
      $this->validate($request, Profile::$rules);

      $profile = new Profile;
      $form = $request->all();

      // データベースに保存する
      $profile->fill($form);
      $profile->save();
      
      $history = new ProfHistory;
      $history->prof_id = $profile->id;
      $history->prof_edit_at = Carbon::now();
      $history->save();
      
      return redirect("admin/profile/create");
    }
    
    public function edit(Request $request)
    {
        // profileデータを全て取得しソート
        $profile = Profile::all()->sortByDesc('updated_at');
        if(empty($profile)){
            abort(404);
        } else { 
            // 更新履歴の一番新しいデータを格納
            $prof_form =$profile->shift();
        }
        // 一番新しいプロフィールのデータだけをviewに返す
        return view("admin.profile.edit",["prof_form" => $prof_form]);
    }
    # edit actionはweb.phpからProfileController@editと呼び出し
    # resources/viewsのadmin/profile/edit.blade.phpを表示させる
    public function update(Request $request)
    {
        $this->varlidate($request, Profile::$rules);
        $profile = Profile::find($request->id);
        $prof_form = $request->all();
        
        unset($prof_form['_token']);
        $profile->fill($prof_form)->save();
        
        $history = new ProfHistory;
        $history->prof_id = $profile->id;
        $history->prof_edit_at = Carbon::now();
        $history->save();
        
        return redirect("admin/profile/edit");
    }
}
# 課題
# 「http://XXXXXX.jp/XXX というアクセスが来たときに、 AAAControllerのbbbというAction に渡すRoutingの設定」
# Route::get(“XXX”,”AAACountroller@bbb”);


