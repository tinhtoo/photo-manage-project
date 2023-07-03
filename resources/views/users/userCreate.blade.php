@extends('layouts.app', ['titlePage' => __('User Create'), 'page' => ('User Create')])

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ __('ユーザー作成') }}</h5>
            </div>
            <form method="post" action="{{ route('user.store') }}" autocomplete="off">
                <div class="card-body">
                    @csrf

                    @include('alerts.success')

                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label>{{ __('名前') }}</label>
                        <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', '') }}">
                        @if ($errors->any())
                            @foreach($errors->get('name') as $message)
                                <li class='text-danger'>{{ $message }}</li>
                            @endforeach
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label>{{ __('メールアドレス') }}</label>
                        <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email address') }}" value="{{ old('email', '') }}">
                        @if ($errors->any())
                            @foreach($errors->get('email') as $message)
                                <li class='text-danger'>{{ $message }}</li>
                            @endforeach
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label>{{ __('パスワード') }}</label>
                        <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" value="">
                        @if ($errors->any())
                            @foreach($errors->get('password') as $message)
                                <li class='text-danger'>{{ $message }}</li>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <a class="btn btn-light" href="{{ route('user.index') }}">{{ __('戻る') }}</a>
                    <button type="submit" class="btn btn-fill btn-primary">{{ __('保存') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

