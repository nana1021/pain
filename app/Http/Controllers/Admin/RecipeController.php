<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Recipe;
use App\Category;
use App\User;
use Auth;

class RecipeController extends Controller
{
   
    public function add()
    {
        return view('admin.recipe.create');
    }
    public function create(Request $request)
    {
       $this->validate($request, Recipe::$rules);//Recipe.phpのrules変数呼び出し
       $recipe = new Recipe;//newはModelからインスタンス（レコード）を生成するメソッド
       $form = $request->all();
       
        if (isset($form['image'])) { //issetは引数の中にデータがあるかないかを判断するメソッド
        $path = $request->file('image')->store('public/image');//storeはどこのフォルダにファイルを保存するか、パスを指定するメソッド
        $recipe->image_path = basename($path);//basenameはパスではなくファイル名だけ取得するメソッド
      } else {
        $recipe->image_path = null;
    }
      
      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // フォームから送信されてきたimageを削除する
      unset($form['image']);
      
      $recipe->fill($form);
      $recipe->save();
      
      return redirect('admin/recipe/create');
    }
    
    public function index(Request $request)
    {
      $cond_title = $request->cond_title; //$cond_titleに値を代入、なければnull 下の行の$cond_title
        if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          $posts = Recipe::where('title', $cond_title)->get();
      } else {
          // それ以外はすべてのニュースを取得する
         $posts = Recipe::all();  
      }
     return view('admin.recipe.index',['posts' => $posts, 'cond_title' => $cond_title]);
    }
  
     public function getRecipeShow($id)
    {
    $recipes = Auth::user()->recipes;
    return view('admin.recipe.index',['recipes'=>$recipes]);
    }
    
    public function edit(Request $request)
  {
      // News Modelからデータを取得する
      $recipe = Recipe::find($request->id);
      if (empty($recipe)) {
        abort(404);    
      }
      return view('admin.recipe.edit', ['recipe_form' => $recipe]);
  }
  
  
  public function update(Request $request)
  {
      // Validationをかける
      $this->validate($request, Recipe::$rules);
      // News Modelからデータを取得する
      $recipe = Recipe::find($request->id);
      // 送信されてきたフォームデータを格納する
      $recipe_form = $request->all();
      if ($request->remove == 'true') {
          $recipe_form['image_path'] = null;
      } elseif ($request->file('image')) {
          $path = $request->file('image')->store('public/image');
          $recipe_form['image_path'] = basename($path);
      } else {
          $recipe_form['image_path'] = $recipe->image_path;
      }

      unset($recipe_form['image']);
      unset($recipe_form['remove']);
      unset($recipe_form['_token']);
      // 該当するデータを上書きして保存する
      $recipe->fill($recipe_form)->save();
        
      return redirect('/admin/recipe')->with('message','ルセットが更新されました。');
  }
  
  public function destroy($id)
  {
      // 該当するModelを取得
      $recipe = Recipe::find($id);
      // 削除する
      $recipe->delete();
      return redirect('/admin/recipe')->with('message','ルセットが削除されました。');
  }

     public function show($id)
    {
      $recipe = Recipe::find($id);
      
      return view('admin.recipe.show');
    }
}