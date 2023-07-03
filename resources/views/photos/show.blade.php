@extends('layouts.app', ['titlePage' => __('Photo Show'), 'page' => ('Show')])

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Photo</h2>
            </div>
        </div>
    </div>
    <form action="{{ route('pages.destroy',$photo->id) }}" method="POST">
        <div class="row">
            <div class="col-xs-10 col-sm-10 col-md-10">
                <div class="form-group row g-3 align-items-center text-light">
                    <div class="col-sm-2 text-right">
                        <strong class="text-white">タイトル : </strong>
                    </div>
                    <div class="col-sm-10">
                        {{ $photo->title }}
                    </div>
                </div>
            </div>
            <div class="col-xs-10 col-sm-10 col-md-10">
                <div class="form-group row g-3 align-items-center text-light">
                    <div class="col-sm-2 text-right">
                        <strong class="text-white">カテゴリ : </strong>
                    </div>
                    <div class="col-sm-10">
                        {{ $photo->category->category_name }}
                    </div>
                </div>
            </div>
            <div class="col-xs-10 col-sm-10 col-md-10">
                <div class="form-group row g-3 align-items-center text-light">
                    <div class="col-sm-2 text-right">
                        <strong class="text-white">コンテンツ : </strong>
                    </div>
                    <div class="col-sm-10">
                        {{ $photo->content }}
                    </div>
                </div>
            </div>
            <div class="col-xs-10 col-sm-10 col-md-10">
                <div class="form-group row g-3 align-items-center text-light">
                    <div class="col-sm-2 text-right ">
                        <strong class="text-white">イメージ : </strong>
                    </div>
                    <div class="col-sm-10">
                        <img src="/image/{{ $photo->image }}" width="500px">
                    </div>
                </div>
            </div>
            <div class="form-group col-md-12 text-center">
                <a class="btn btn-primary" href="{{ route('pages.main') }}"><i class="fas fa-reply fa-lg"></i></a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onClick="delete_alert(event);return false;"><i class='fa fa-trash fa-lg'></i></button>
            </div>
        </div>
    </form>
@endsection