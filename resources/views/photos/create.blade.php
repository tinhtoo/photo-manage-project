@extends('layouts.app', ['titlePage' => __('Photo Upload'), 'page' => ('Upload')])

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2 class="text-white">写真のアップロード</h2>
        </div>
    </div>
</div>
     
<form action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
     <div class="row">
        <div class="col-md-9">
            <div class="form-group">
                <strong class="text-white">タイトル :</strong>
                <input type="text" name="title" class="form-control" placeholder="タイトル" value="{{ old('title', '') }}">
                @if ($errors->any())
                    @foreach($errors->get('title') as $message)
                        <li class='text-danger'>{{ $message }}</li>
                    @endforeach
                @endif 
            </div>
        </div>
        <div class="col-md-9">
            <div class="form-group">
                <strong class="text-white">カテゴリ : </strong>
                <select name="categoryName" class="form-control">
                    <option value=""></option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
                @if ($errors->any())
                    @foreach($errors->get('categoryName') as $message)
                        <li class='text-danger'>{{ $message }}</li>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-md-9">
            <div class="form-group">
                <strong class="text-white">コンテンツ :</strong>
                <textarea class="form-control" style="height:150px" name="content" placeholder="コンテンツ" >
                {{ old('content'), '' }}
                </textarea>
                @if ($errors->any())
                    @foreach($errors->get('content') as $message)
                        <li class='text-danger'>{{ $message }}</li>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-md-9">
            <strong for="formFile" class="text-white" name="image">写真 :</strong>
            <input class="form-control" type="file" id="formFile" name="image" value="{{ old('image', '') }}"/>
            @if ($errors->any())
                @foreach($errors->get('image') as $message)
                    <li class='text-danger'>{{ $message }}</li>
                @endforeach
            @endif
        </div>
        <div class="col-md-9 text-center">
            <a class="btn btn-primary" href="{{ route('pages.main') }}"><i class="fas fa-reply fa-lg"></i></a>
            <button type="submit" class="btn btn-success"><i class="fas fa-upload fa-lg"></i></button>
        </div>
    </div>
     
</form>
@endsection

