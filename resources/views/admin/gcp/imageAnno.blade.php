@extends('layouts.admin')

{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', '画像のアップロード')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                
                <h2>画像ラベルの判読</h2>
                <form action="{{ action('Admin\GcpController@imageAnno') }}" method="get" >
                    <div class="form-group row">
                        <label class="col-md-2">判読結果</label>
<!--多分不要
                            <div class="col-md-8">
                            <input type="text" class="form-control" name="cond_title" value="{{ $cond_title }}">
                        </div>
--> 
                    </div>
                </form>
                
                <div class="row">
                    <div class="list-news col-md-12 mx-auto">
                        <div class="row">
                            <h3>{{ $score->score "の確率で" $description->label "です"}}</h3>
<<!--
                        <table class="table table-dark">
                            <tbody>
                            @foreach($ as $news)
                                <tr>
                                    <th>{{ $news->id }}</th>
                                    <td>{{ str_limit($news->label, 20) }}</td>
                                    <td>{{ str_limit($news->score, 20) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection