@extends('layouts.app', ['page' => __('Category Edit')])

@section('content')
    <div class="card-body">                
        <div class="">
            </form>
            <h2>Category Edit</h2>
        </div>
        <form action="{{ route('photos.categoryUpdate') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <strong class="text-white">Category Name : </strong>
                        <select name="categoryId" class="form-control">
                            @foreach ($categories as $categoryData)
                                <option {{ $categoryData->id == $category->id ? 'selected':'' }} value="{{ $categoryData->id }}">
                                    {{ $categoryData->category_name }}
                                </option>
                            @endforeach
                        </select>
                        <strong class="text-white">New Category Name : </strong>
                        @if ($errors->any())
                            @foreach($errors->get('newCategoryName') as $message)
                                <li class='text-danger'>{{ $message }}</li>
                            @endforeach
                        @endif
                        <input type="text" name="newCategoryName" class="form-control" placeholder="New Category Name" value="{{ old('newCategoryName', '') }}"> 
                        <div class="col-md-12 text-center">
                            <a class="btn btn-primary" href="{{ route('photos.categoryList') }}"><i class="fas fa-reply fa-lg"></i></a>
                            <button type="submit" class="btn btn-success" onClick="update_alert(event);return false;"><i class="fas fa-save fa-lg"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
    </div>
@endsection
