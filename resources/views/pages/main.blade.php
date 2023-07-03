@extends('layouts.app', ['page' => __('Photo List')])

@section('content')
    <div class="card-body">                
        <div class="">
            <form method="GET" action="{{ route('pages.main') }}">
            @csrf
                <div>
                    <input type="search" name="searchitem" class="col-md-6" placeholder="タイトルで検索" value="{{ request('searchitem', '') }}">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fab fa-sistrix fa-lg"></i></button>
                </div>
            </form> 
            <div class="text-right">
                <a href="{{ route('pages.create') }}" class="btn btn-sm btn-success"><i class="fas fa-plus fa-2x"></i></a>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <table class="table tablesorter" id="">
                <thead class="text-primary">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Image</th>
                        <th scope="col">Title</th>
                        <th scope="col">Category</th>
                        <th scope="col">Content</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($photos as $index => $photo)
                    <tr>
                        <td>{{ $photos->firstItem() + $index }}</td>
                        <td><img src="/image/{{ $photo->image }}" width="100px"></td>
                        <td>{{ $photo->title }}</td>
                        <td>
                            {{ $photo->category->category_name }}
                        </td>
                        <td>{{ $photo->content }}</td>
                        @if (auth()->user()->role == 1)
                        <td class="text-right">
                            <div class="dropdown">
                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item text-primary" href="{{ route('pages.show',$photo->id) }}">
                                        <i class="fas fa-eye"></i>
                                        {{ trans('表示') }}
                                    </a>
                                    <a class="dropdown-item text-info" href="{{ route('pages.edit', $photo->id) }}">
                                        <i class="fa fa-edit"></i>
                                        {{ trans('更新') }}
                                    </a>
                                
                                    <form id="delete-{{ $photo->id }}" action="{{ route('pages.destroy', $photo->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                    <a class="dropdown-item text-danger" href="#" onclick="if(confirm('{{ trans('本当に削除しますか？') }}')) document.getElementById('delete-{{ $photo->id }}').submit()">
                                        <i class="fa fa-trash"></i>
                                        {{ trans('削除') }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        @else
                        <td class="text-right">
                            <div class="dropdown">
                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item text-primary" href="{{ route('pages.show',$photo->id) }}">
                                        <i class="fas fa-eye fa-lg"></i>
                                        {{ trans('表示') }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination justify-content-center">
            {{ $photos->links() }}
            </div>
        </div>
    </div>
@endsection
