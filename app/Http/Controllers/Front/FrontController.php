<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\Categories;

class FrontController extends Controller
{
    //
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $photoDatas = Posts::whereNull('posts.deleted_at')
                            ->orderByDesc('updated_at')
                            ->paginate(10);

        $data = '';
        if ($request->ajax()) {
			foreach ($photoDatas as $photoData) {
                $data.= '<div class="col col-md-4 popup">
                            <div class="card">
                                <input type="hidden" id="postId" name="postId" value="'.$photoData->id .'" />
                                <a href="'.route('users.detail',$photoData->id) .'" target="_blank">
                                    <img class="card-img-top" src="/image/'. $photoData->image .'" alt="Card image cap">
                                </a>
                                <div class="card-body">
                                    <div class="card-description">
                                        <a href="">
                                        <h5 class="card-title">'. $photoData->title . '</h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
            return $data;
		}
        return view('users.photos', compact('photoDatas'));
    }

    /**
     * 写真一覧表示
     */
    public function detailShow(Request $request, Posts $photoData)
    {
        // dd($request->input('id'));
        return view('users.detail',compact('photoData'));
    }

    /**
     * 検索
     */
    public function searchPhotos(Request $request, Posts $photoData)
    {
        
        $photoDatas = Posts::Where('posts.title', 'LIKE', $request->searchitem . '%')
                        ->whereNull('posts.deleted_at')
                        ->orderByDesc('updated_at')
                        ->paginate(10);
                        // dd($photoDatas);

        $data = '';

        if ($request->ajax()) {
            foreach ($photoDatas as $photoData) {
                        $data.= '<div class="col col-md-4 popup">
                                    <div class="card">
                                        <input type="hidden" id="postId" name="postId" value="'.$photoData->id .'" />
                                        <a href="'.route('users.detail',$photoData->id) .'" target="_blank">
                                            <img class="card-img-top" src="/image/'. $photoData->image .'" alt="Card image cap">
                                        </a>
                                        <div class="card-body">
                                            <div class="card-description">
                                                <a href="">
                                                <h5 class="card-title">'. $photoData->title . '</h5>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
            }
            return $data;
        }

        return view('users.photos',compact('photoDatas'));
    }
}
