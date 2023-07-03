<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UserProfileRequest;
use Illuminate\Validation\Rule;
use App\Rules\CurrentPasswordCheckRule;
use Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        $users = User::whereNull('deleted_at')
                        ->where('role', 2)
                        ->orderByDesc('updated_at')
                        ->paginate(9);
        return view('users.index', compact('users'));
    }

    /**
     * ユーザー作成フォーム
     */
    public function userCreate()
    {
        Gate::authorize('isAdmin');
        return view('users.userCreate');
    }

    /**
     * ユーザー作成
     */
    public function userStore(Request $request)
    {
        Gate::authorize('isAdmin');
        $request->validate([
            'name'=> 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $input = $request->all();

        User::create([
            'name' => $input['name'], 
            'email' => $input['email'], 
            'password' => Hash::make($input['password']), 
            'role' => 2
        ]);

        return redirect()->route('user.index')
                        ->with('success','ユーザー作成しました！');
    }

    /**
     * ユーザー編集フォーム
     */
    public function userEdit(User $user)
    {
        Gate::authorize('isAdmin');
        return view('users.userEdit', compact('user'));
    }

    /**
     * ユーザー編集フォーム
     */
    public function userUpdate(Request $request, User $user)
    {
        Gate::authorize('isAdmin');
        $request->validate([
            'name'=> 'required|min:3',
            'email' => 'required|email',Rule::unique((new User)->getTable())->ignore(auth()->id()),
            'password' => 'min:6', new CurrentPasswordCheckRule,
        ]);

        $input = $request->all();
        $data = User::find($user->id);

        $data->update([ 
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        return redirect()->route('user.index')
                        ->with('success','更新しました!');
    }

    /**
     * ユーザー削除フォーム
     */
    public function userDestroy(User $user)
    {
        Gate::authorize('isAdmin');
        $user->delete();

        return redirect()->route('user.index')
                        ->with('success','正常に削除されました!');
    }
}
