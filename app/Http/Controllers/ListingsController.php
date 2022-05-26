<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

 // ここから追加
 use App\Models\User;
 use App\Models\Listing;
    // use Auth; ↓
 use Illuminate\Support\Facades\Auth;
 use Illuminate\Support\Facades\Validator;

 use Log;



class ListingsController extends Controller
{
    //3-2
    //===ここから追加===
    //コンストラクタ （このクラスが呼ばれると最初にこの処理をする）
    public function __construct()
    {
        // ログインしていなかったらログインページに遷移する（この処理を消すとログインしなくてもページを表示する）
        $this->middleware('auth');
    }
    //===ここまで追加===

    //===ここから追加===
    public function index()
    {
        $listings = Listing::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'asc')
            ->get();
            
         // テンプレート「listing/index.blade.php」を表示します。 リスト一覧
        return view('listing/index', ['listings' => $listings]);
    }
    //===ここまで追加===

    //===ここから追加===
    public function new()
    {
         // テンプレート「listing/new.blade.php」を表示します。　リスト新規作成
        return view('listing/new');
        
    }
    //===ここまで追加===

    //===ここから追加===　新規登録ロジック
    public function store(Request $request)
    {
        //バリデーション（入力値チェック）
        $validator = Validator::make($request->all() , ['list_name' => 'required|max:255', ]);

        //バリデーションの結果がエラーの場合
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        // Listingモデル作成
        $listings = new Listing;
        $listings->title = $request->list_name;
        $listings->user_id = Auth::user()->id;

        $listings->save();
        // 「/」 ルートにリダイレクト
        return redirect('/'); //　登録後はトップ画面
    }
    //===ここまで追加===

    //===ここから追加=== 　編集ロジック
    public function edit($listing_id)
    {
        $listing = Listing::find($listing_id);
         // テンプレート「listing/edit.blade.php」を表示します。
        return view('listing/edit', ['listing' => $listing]); //　リスト編集処理に渡す
    }

    //===ここまで追加===

    //===ここから追加===　更新処理
    public function update(Request $request)
    {
        //バリデーション（入力値チェック）
        $validator = Validator::make($request->all() , ['list_name' => 'required|max:255', ]);

        //バリデーションの結果がエラーの場合
        if ($validator->fails())
        {
          return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        
        $listing = Listing::find($request->id);
        $listing->title = $request->list_name;
        $listing->save();
        return redirect('/'); //　更新処理後はトップに返す
    }
    //===ここまで追加===

    //===ここから追加===　削除処理
    public function destroy($listing_id)
    {
        $listing = Listing::find($listing_id);
        $listing->delete();
        return redirect('/');
    }
    //===ここまで追加===

}
