@extends('layouts.app', ['titlePage' => __('Photo Edit'), 'page' => ('Edit')])
     
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Photo</h2>
            </div>
        </div>
    </div>
    <form action="{{ route('pages.update',$photo->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="row">
            <div class="col-md-10">
                <div class="form-group row g-3 align-items-center text-light">
                    <div class="col-sm-2 text-right ">
                        <strong class="text-white">タイトル :</strong>
                    </div>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control" placeholder="タイトル" value="{{ $photo->title }}"> 
                    </div>
                    @if ($errors->any())
                        @foreach($errors->get('title') as $message)
                            <li class='text-danger'>{{ $message }}</li>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col-md-10">
                <div class="form-group row g-3 align-items-center text-light">
                    <div class="col-sm-2 text-right ">
                        <strong class="text-white">カテゴリ : </strong>
                    </div>
                    <div class="col-sm-10">
                        <select name="categoryName" class="form-control">
                            <option value=""></option>
                            @foreach ($categories as $category)
                                <option {{ $category->category_name == $photo->category->category_name ? 'selected':'' }} value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->any())
                        @foreach($errors->get('categoryName') as $message)
                            <li class='text-danger'>{{ $message }}</li>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col-md-10">
                <div class="form-group row g-3 align-items-center text-light">
                    <div class="col-sm-2 text-right ">
                        <strong class="text-white">コンテンツ :</strong>
                    </div>
                    <div class="col-sm-10">
                        <textarea class="form-control" style="height:150px" name="content" placeholder="コンテンツ" >
                        {{ $photo->content }}
                        </textarea>
                    </div>
                    @if ($errors->any())
                        @foreach($errors->get('content') as $message)
                            <li class='text-danger'>{{ $message }}</li>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col-md-10 text-light">
                <div class="form-group row g-3 align-items-center text-light">
                    <div class="col-sm-2 text-right">
                        <strong for="formFile" class="text-white" name="image">写真 :</strong>
                    </div>
                    <div class="col-sm-10">
                        <input type="file" name="image" class="form-control" placeholder="image">
                        <img src="/image/{{ $photo->image }}" width="500px">
                    </div>
                    @if ($errors->any())
                        @foreach($errors->get('image') as $message)
                            <li class='text-danger'>{{ $message }}</li>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-md-10 text-center">
            <a class="btn btn-primary" href="{{ route('pages.main') }}"><i class="fas fa-reply fa-lg"></i></a>
            <button type="submit" class="btn btn-success" onClick="update_alert(event);return false;"><i class="fas fa-save fa-lg"></i></button>
            </div>
        </div>
    </form>
@endsection