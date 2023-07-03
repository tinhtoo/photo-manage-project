@extends('layouts.app', ['page' => __('Category List')])

@section('content')
    <div class="card-body">                
        <div class="">
            <div class="text-right">
                <a class="btn btn-primary btn-sm" href="{{ route('photos.setting') }}"><i class="fas fa-reply fa-2x"></i></a>
                <a href="{{ route('photos.categoryCreate') }}" class="btn btn-success btn-sm"><i class="fas fa-plus fa-2x"></i></a>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @elseif ($message = Session::get('fail'))
                <div class="alert alert-warning">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <table class="table tablesorter" id="">
                <thead class="text-primary">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Category Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $index => $category)
                    <tr>
                        <td>{{ $categories->firstItem() + $index }}</td>
                        <td>{{ $category->category_name }}</td>
                        <!-- <td class="text-right">
                        <form action="{{ route('photos.categoryDestroy',$category->id) }}" method="POST">
                                <a class="btn btn-info btn-sm" href="{{ route('photos.categoryEdit',$category->id) }}"><i class="fas fa-edit fa-lg"></i></a>
                            @csrf
                            @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onClick="delete_alert(event);return false;"><i class='fa fa-trash fa-lg'> </i></button>
                        </form>
                        </td> -->
                        <td class="text-right">
                            <div class="dropdown">
                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item text-primary" href="{{ route('photos.categoryEdit', $category->id) }}">
                                        <i class="fa fa-edit"></i>
                                        {{ trans('更新') }}
                                    </a>
                                    @if (auth()->user()->role == 1)
                                    <form id="delete-{{ $category->id }}" action="{{ route('photos.categoryDestroy', $category->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                    <a class="dropdown-item text-danger" href="#" onclick="if(confirm('{{ trans('本当に削除しますか？') }}')) document.getElementById('delete-{{ $category->id }}').submit()">
                                        <i class="fa fa-trash"></i>
                                        {{ trans('削除') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination justify-content-center">
            {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection
