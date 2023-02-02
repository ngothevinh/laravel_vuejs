<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagCollection;
use App\Models\Tag;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class TagController extends Controller
{
    private $tag;
    public function __construct(Tag $tag){
        $this->tag = $tag;
    }
    public function index(){
        return new TagCollection($this->tag->with(['posts'])->latest()->get());
    }
    public function store(Request $request){
        try{
            $tag = $this->tag->create([
                'name' => $request->get('name'),
            ]);
            return response()->json([
                'tag' => $tag,
                'code' => 200,
                'message' => 'successfully!!'
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'code' => 500,
                'message' => 'failed'
            ]);
        }
    }
    public function edit($id){
        try{
            $tag = $this->tag->find($id);
            return response()->json([
                'tag' => $tag,
                'code' => 200,
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'code' => 500,
            ]);
        }
    }
    public function update($id,Request $request){
        $tag = $this->tag->find($id);
        $tag->update($request->all());
        return response()->json([
            'tag' => $tag,
            'code' => 200,
            'message' => "Update post successfully"
        ]);
    }
    public function delete($id){
        $tag = $this->tag->with(['posts'])->find($id);
        $tag->post_ids = $tag->posts->pluck('id')->toArray();
        if(empty($tag->post_ids)){
            $tag->delete();
            return response()->json([
                'message' =>'Xóa thành công',
                'code' => 200
            ]);
        }
        return response()->json([
            'message' =>'Xóa thất bại',
            'code' => 500
        ]);

    }
}
