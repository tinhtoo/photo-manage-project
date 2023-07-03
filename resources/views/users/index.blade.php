@extends('layouts.app', ['page' => __('User Management')])

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Users</h4>
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                        </div>
                        @if (auth()->user()->role == 1) 
                        <div class="col-4 text-right">
                            <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">Add user</a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th scope="col">No:</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Creation Date</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ $users->firstItem() + $index }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        <a href="mailto:admin@black.com">{{ $user->email }}</a>
                                    </td>
                                    <td>{{ $user->updated_at->format('Y-m-d') }}</td>
                                    @if (auth()->user()->role == 1)
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item text-primary" href="{{ route('user.edit', $user->id) }}">
                                                    <i class="fa fa-edit"></i>
                                                    {{ trans('更新') }}
                                                </a>
                                            
                                                <form id="delete-{{ $user->id }}" action="{{ route('user.destroy', $user->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                </form>
                                                <a class="dropdown-item text-danger" href="#" onclick="if(confirm('{{ trans('本当に削除しますか？') }}')) document.getElementById('delete-{{ $user->id }}').submit()">
                                                    <i class="fa fa-trash"></i>
                                                    {{ trans('削除') }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="pagination justify-content-center">
                {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
