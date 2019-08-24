@extends('layouts.front')

@section('content')
    <div class="container">
        <hr color="#c0c0c0">
        @if (!is_null($prof_data))
            <div class="row">
                {{-- layout.front.scssを継承しているのでclass名は変えない --}}
                <div class="headline col-md-10 mx-auto">
                    <div class="row">
                        <div class="caption mx-auto">
                            <div class="title p-2">
                                <h1>{{ str_limit($prof_data->name, 70) }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="caption mx-auto">
                            <div class="title p-2">
                                <h1>{{ str_limit($prof_data->gender, 70) }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="caption mx-auto">
                            <div class="title p-2">
                                <h1>{{ str_limit($prof_data->hoby, 70) }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="caption mx-auto">
                            <div class="title p-2">
                                <h1>{{ str_limit($prof_data->introduction, 250) }}</h1>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        @endif
    </div>
@endsection