<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;

class ProfileController extends Controller
{
    //課題4 ProfileControllerの作成と以下のactionの追加
    public function add(){
        return view("admin.profile.create");
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
      
      return redirect("admin/profile/create");
    }
    
    public function edit(){
        return view("admin.profile.edit");
    }
    #edit actionはweb.phpからProfileController@editと呼び出し、resources/viewsのadmin/profile/edit.blade.phpを表示させる
    public function update(){
        return redirect("admin/profile/edit");
    }
}
# 課題
# 「http://XXXXXX.jp/XXX というアクセスが来たときに、 AAAControllerのbbbというAction に渡すRoutingの設定」
# Route::get(“XXX”,”AAACountroller@bbb”);


