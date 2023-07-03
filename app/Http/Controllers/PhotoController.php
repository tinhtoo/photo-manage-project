<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Gate;

class PhotoController extends Controller
{
    /**
     * 一覧画面表示
     */
    public function main(Request $request)
    {
        $photos = Posts::whereNull('posts.deleted_at')
                        ->orderByDesc('id')
                        ->paginate(6);

        $search = $request->input('searchitem');

        // クエリビルダ
        $query = Posts::query();

        if($search) {
            // 全角スペースを半角に変換
            $spaceConversion = mb_convert_kana($search, 's');

            // 単語を半角スペースで区切り、配列にする（例："山田 翔" → ["山田", "翔"]）
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);


            // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
            foreach($wordArraySearched as $value) {
                $query->where('posts.title', 'like', '%'.$value.'%')
                        ->whereNull('deleted_at');
            }

            // 上記で取得した$queryをページネートにし、変数$usersに代入
            $photos = $query->paginate(6);
        } elseif(!$search) {
            return view('pages.main', compact('photos'));
        }

        // return view('pages.main')->with(['photos' => $photos]);
        return view('pages.main', compact('photos'));
    }

    /**
     * 検索
     */
    // public function search(Request $request)
    // {
    //     $photos = Posts::Where('posts.title', 'LIKE', $request->searchitem . '%')
    //                     ->whereNull('deleted_at')
    //                     ->paginate(5);

    //     return view('pages.main',compact('photos'));
    // }

    /**
     * 写真のアップロード画面
     */
    public function create()
    {
        $categories = Categories::get();
        return view('photos.create', compact('categories'));
    }

    /**
     * 作成した写真データを保存する
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=> 'required',
            'categoryName' => 'required',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:9120',
        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }
    
        // Posts::create($input);
        Posts::create(['title' => $input['title'], 'category_id' => $input['categoryName'], 'content' => $input['content'], 'image' => $input['image']]);
     
        return redirect()->route('pages.main')
                        ->with('success','アップロード成功しました！');
        
    }

    /**
     * 写真一覧表示
     */
    // public function show($photo)
    public function show(Posts $photo)
    {
        
        // $photo = Posts::find($photo);

        return view('photos.show',compact('photo'));
    }

    /**
     * 写真データの編集
     */
    public function edit(Posts $photo)
    {
        Gate::authorize('isAdmin');
        $categories = Categories::get();
        return view('photos.edit',compact('photo', 'categories'));
    }

    /**
     * 写真データの更新
     */
    public function update(Request $request, Posts $photo)
    {
        Gate::authorize('isAdmin');
        $request->validate([
            'title'=> 'required',
            'categoryName' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:9120',
        ]);
  
        $input = $request->all();
        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }else{
            unset($input['image']);
        }

        $photo->update($input);
        // Posts::update([
        //     'title' => $input['title'],
        //     'category_id' => $input['categoryName'],
        //     'content' => $input['content'],
        //     'image' => $input['image']
        // ]);
    
        return redirect()->route('pages.main')
                        ->with('success','写真の更新、成功しました！');
    }

    /**
     * 写真データの削除
     */
    public function destroy(Posts $photo)
    {
        Gate::authorize('isAdmin');
        $photo->delete();
        return redirect()->route('pages.main')
                        ->with('success','正常に削除されました!');
    }

    /**
     * 設定画面の表示
     */
    public function setting()
    {
        return view('photos.setting');
    }

    /**
     * カテゴリ作成画面
     */
    public function categoryCreate()
    {
        return view('photos.categoryCreate');
    }

    /**
     * カテゴリの作成
     */
    public function categoryStore(Request $request)
    {
        $request->validate([
            'newCategoryName' => 'required',
        ]);

        $input = $request->all();

        //Categories::create($input);

        Categories::create(['category_name' => $input['newCategoryName']]);
     
        return redirect()->route('photos.categoryList')
                        ->with('success','アップロード成功しました！');
        
    }

    /**
     * カテゴリリスト画面
     */
    public function categoryList()
    {
        $categories = Categories::paginate(5);
        return view('photos.categoryList', compact('categories'));
    }

    /**
     * カテゴリ編集画面
     */
    public function categoryEdit(Categories $category)
    {
        Gate::authorize('isAdmin');
        $categories = Categories::get();
        return view('photos.categoryEdit', compact('category', 'categories'));
    }

    /**
     * 新しく作成したデータを保存する
     */
    public function categoryUpdate(Request $request, Categories $category)
    {
        Gate::authorize('isAdmin');
        $request->validate([
            'newCategoryName'=> 'required',
        ]);
  
        $input = $request->all();
        
        $category = Categories::find($request->categoryId);
        $category->update([  
            "category_name" => $request->newCategoryName,  
        ]);
     
        return redirect()->route('photos.categoryList')
                        ->with('success','成功しました！');
        
    }

    /**
     * カテゴリの削除
     */
    public function categoryDestroy(Request $request,$category)
    {
        Gate::authorize('isAdmin');
        $category_id = Posts::where('category_id', $category)->first();
        
        if($category_id === null) {
            $category = Categories::find($category);
            $category->delete();
        } else {
            return redirect()->route('photos.categoryList')
                        ->with('fail','このカテゴリは使用中のため、削除できません!');
        }        
        return redirect()->route('photos.categoryList')
                        ->with('success','正常に削除されました!');
    }
}
