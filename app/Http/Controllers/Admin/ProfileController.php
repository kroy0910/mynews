<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    //課題4 ProfileControllerの作成と以下のactionの追加
    public function add(){
        return view("admin.profile.create");
    }
    public function create(){
        return redirect("admin/profile/create");
    }
    public function edit(){
        return view("admin.profile.edit");
    }
    public function update(){
        return redirect("admin/profile/edit");
    }
}
# 課題
# 「http://XXXXXX.jp/XXX というアクセスが来たときに、 AAAControllerのbbbというAction に渡すRoutingの設定」
# Route::get(“XXX”,”AAACountroller@bbb”);


