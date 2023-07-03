@extends('layouts.app', ['page' => __('Photo List')])

@section('content')
    <div class="card-body">                
        <div class="">
            </form> 
            <div>
                <a href="{{ route('photos.categoryList') }}" class="btn btn-sm btn-success">Category Manager</a>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection
