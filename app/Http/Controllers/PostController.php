<?php

namespace App\Http\Controllers;

use App\Models\PostTags;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    private $post;
    private $tag;
    public function __construct(Post $post,Tag $tag){
        $this->post = $post;
        $this->tag = $tag;
    }

    public function index(){
        return new PostCollection($this->post->with(['tags'])->latest()->paginate(5));
    }

    public function store(Request $request){

        try{
            $post = $this->post->create([
                'title' => $request->get('title'),
                'body' => $request->get('body')
        ]);
            //import data in table post_tags
            $post->tags()->sync($request->tag_id);

            return response()->json([
                'post' => $post,
                'code' => 200,
                'message' => "Add post successfully"
            ]);
        }
        catch(\Exception $exception){
            return response()->json([
                'code' => 500,
                'message' => "Add post failed",
            ]);
        }
    }
    public function edit($id){
        try{
            $post = $this->post->with(['tags'])->find($id);
            $post->tag_ids = $post->tags->pluck('id')->toArray();
            return response()->json([
                'post' => $post,
                'code' => 200
            ]);
        }
        catch (\Exception $exception){
            return response()->json([
                'code' => 500,
            ]);
        }
    }
    public function update($id, Request $request){
        try{
            $post = $this->post->find($id);
            $post->update($request->all());

            //update data in table post_tags
            $post->tags()->sync($request->tag_ids);
            return response()->json([
                'post' => $post,
                'code' => 200,
                'message' => "Update post successfully"
            ]);
        }catch(\Exception $exception){
            return response()->json([
                'code' => 500,
                'message' => "Update post failed"
            ]);
        }
    }
    public function delete($id,Request $request){
        try {
            $post = $this->post->find($id);
            $post->delete();
            $post->tags()->detach();
            return response()->json([
                'code'=> 200,
                'message' => "Delete post successfully"
            ],200);
        }catch (\Exception $exception){
            Log::error('message' . $exception->getMessage(). '  line' .$exception->getLine());
            return response()->json([
                'code'=> 500,
                'message' => "Delete post failed"
            ],500);
        }
    }

    public function search($data){
        $data = $this->post->where('title','LIKE','%'.$data.'%')->get();
        return $data;
    }
}
