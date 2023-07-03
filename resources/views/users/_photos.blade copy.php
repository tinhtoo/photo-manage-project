@extends('layouts.userApp', ['class' => 'login-page', 'page' => __('Photo View Page'), 'contentClass' => 'login-page'])


@section('content')
<div>
    <form method="GET" action="{{ route('users.search') }}">
        @csrf
        <div class="form-group">
            <input type="text" name="searchitem" class="col-md-6" placeholder="タイトルで検索" value="{{ request('searchitem', '') }}">
            <button type="submit" class="btn btn-sm btn-primary"><i class="fab fa-sistrix fa-lg"></i></button>
        </div>
    </form> 
</div>
<div class="container my-5">
    <div class="row">
    @foreach ($photoDatas as $photoData)
    <div class="col-md-4">
        <div class="card card-user">
            <div class="card-body">
                <a href="javascript:window.open('{{ route('users.detail',$photoData->id) }}', 'NewWindow','width=800,height=850,status=no,resizable=no');">
                    <img class="card-img-top" src="/image/{{ $photoData->image }}" alt="Card image cap">
                </a>
                <div class="card-description">
                    <a href="javascript:window.open('{{ route('users.detail',$photoData->id) }}', 'NewWindow','width=800,height=850,status=no,resizable=no');">
                        <h5 class="card-title">{{ $photoData->title  . $photoData->id}}</h5>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    </div>
    <div>
        <div class="pagination justify-content-center">
            {{ $photoDatas->links() }}
        </div>
    </div>
</div>

@endsection