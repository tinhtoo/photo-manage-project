<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <h1 class="text-center simple-text logo-normal">写真管理</h1>
        </div>
        <ul class="nav">
            <li class="{{request()->is('cms/photos')? 'active' :''}}">
                <a href="{{ route('pages.main') }}">
                    <i class="tim-icons icon-camera-18"></i>
                    <p>{{ __('Photo List') }}</p>
                </a>
            </li>
            <li class="{{request()->is('cms/users')? 'active' :''}}">
                <a href="{{ route('user.index') }}">
                    <i class="tim-icons icon-bullet-list-67"></i>
                    <p>{{ __('User Management') }}</p>
                </a>
            </li>
            <li class="{{request()->is('cms/profile')? 'active' :''}}">
                <a href="{{ route('profile.edit')  }}">
                    <i class="tim-icons icon-single-02"></i>
                    <p>{{ __('Profile') }}</p>
                </a>
            </li>
            <li class="{{request()->is('cms/setting')? 'active' :''}}">
                <a href="{{ route('photos.setting') }}">
                    <i class="tim-icons icon-settings-gear-63"></i>
                    <p>{{ __('Settings') }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
