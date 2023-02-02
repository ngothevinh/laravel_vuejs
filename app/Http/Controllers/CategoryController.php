<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    private $category;
    public function __construct(Category $category){
        $this->category = $category;
    }
    public function index(){
        return new CategoryCollection($this->category->latest()->get());
    }
    public function store(Request $request){
        $category = $this->category->create([
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name'))
        ]);

        return response()->json([
           'category' => $category,
           'code' => 200,
           'message' => 'successfully!!'
        ]);

    }
    public function edit($id){
        $category = $this->category->find($id);
        return response()->json([
            'category' => $category,
            'code' => 200,
        ]);
    }
    public function update($id,Request $request){
        $category = $this->category->find($id);
        $category->update($request->all());
        return response()->json([
            'category' => $category,
            'code' => 200,
            'message' => "Update post successfully"
        ]);
    }
    public function delete($id){
        $this->category->find($id)->delete();
        return response()->json([
            'code'=>200,
            'message' => "Delete post successfully"
        ],200);
    }
}
