@extends('layouts.userApp', ['titlePage' => __('Detail'), 'page' => ('Detail')])


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Photo Details</h2>
            </div>
        </div>
    </div>
    <form>
        <div class="row">
            <div class="col-xs-10 col-sm-10 col-md-10">
                <div class="row g-3 align-items-center text-light">
                    <div class="col-sm-2 text-right">
                        <strong class="text-white">タイトル : </strong>
                    </div>
                    <div class="col-sm-6" style="width: 60%; margin-bottom: 3px; padding-left: 2%;">
                        {{ $photoData->title }}
                    </div>
                </div>
            </div>
            <div class="col-xs-10 col-sm-10 col-md-10">
                <div class="row g-3 align-items-center text-light">
                    <div class="col-sm-2 text-right">
                        <strong class="text-white">カテゴリ : </strong>
                    </div>
                    <div class="col-sm-6" style="width: 60%; margin-bottom: 3px; padding-left: 2%;">
                        {{ $photoData->category->category_name }}
                    </div>
                </div>
            </div>
            <div class="col-xs-10 col-sm-10 col-md-10">
                <div class="row g-3 align-items-center text-light">
                    <div class="col-sm-2 text-right">
                        <strong class="text-white">コンテンツ : </strong>
                    </div>
                    <div class="col-sm-6" style="width: 60%; margin-bottom: 3px; padding-left: 2%;">
                        {{ $photoData->content }}
                    </div>
                </div>
            </div>
            <div class="col-xs-10 col-sm-10 col-md-10">
                <div class="row g-3 align-items-center text-light">
                    <div class="col-sm-2 text-right ">
                        <strong class="text-white">イメージ : </strong>
                    </div>
                    <div class="col-sm-6" style="width: 60%; margin-bottom: 3px; padding-left: 2%;">
                        <img src="/image/{{ $photoData->image }}" width="500px">
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection