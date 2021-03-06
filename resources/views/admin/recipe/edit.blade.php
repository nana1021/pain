@extends('layouts.admin')
@section('title', 'ルセットの編集')

@section('content')
    <div class="container">
        <div class="row">
            <div class=box-edit>
            <div class="col-md-8 mx-auto">
                <h2>ルセット編集</h2>
                <form action="{{ action('Admin\RecipeController@update') }}" method="post" enctype="multipart/form-data">
                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-2" for="image">完成写真</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="image">
                            <div class="form-text text-danger">
                                設定中: {{ $recipe_form->image_path }}
                                {{ \Str::limit($recipe_form->image, 10) }}
                                      <img src="{{ $recipe_form->image_path }}"class="rounded-circle">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="remove" value="true">画像を削除
                                </label>
                            </div>
                        </div>
                    </div>  
                   <div class="form-inline">
                    <p class="control-label">販売状況</p>
                    <div>
                    <label class="radio-inline">
                     <input type="radio" name="sales_status" value="販売中" id="sale" {{ $recipe_form->sales_status === '販売中' ? 'checked' : '' }} />販売中
                    </label>
                    </div>
                    <div>
                   <label class="radio-inline">
                    <input type="radio" name="sales_status" value="休止中" id="rest" {{ $recipe_form->sales_status === '休止中' ? 'checked' : '' }} />休止中
                   </label>
                  </div>
                  </div>   
                    <div class="form-group row" style="margin-bottom: 30px">
                        <label for="category" class="col-md-2">カテゴリー</label>
                      <select class="form-control @error('category') is-invalid @enderror col-md-10" id="category" name="category_name">
                        <option value="{{ $recipe_form->category_name }}" disabled style="display:none">{{ $recipe_form->category_name }}</option>
                    @foreach(App\Category::all() as $category)
                        <option value="{{ $category->name }}" @if($recipe_form->category_name == $category->name)selected @endif>{{ $category->name }}</option>
                    @endforeach
                      </select>
                    @error('category')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                       <div class="text-right mt-1">
                    <a type="button" href="{{ url('/admin/category/create') }}" class="btn btn-outline-warning py-1" role="button">新規追加</a>
                    <a type="button" href="{{ url('/admin/category') }}" class="btn btn-outline-danger py-1" role="button">編集</a>
                       </div>
                    </div>  
                
                    <div class="form-group row">
                        <label class="col-md-2" for="title">品名</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="title" value="{{ $recipe_form->title }}">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-2" for="material">材料</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="material" rows="5">{{ $recipe_form->material }}</textarea>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-2" for="body">作り方</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="body" rows="5">{{ $recipe_form->body }}</textarea>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-2" for="memo">メモ</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="memo" rows="5">{{ $recipe_form->memo }}</textarea>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-md-10">
                            <input type="hidden" name="id" value="{{ $recipe_form->id }}">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-success" value="更新">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection