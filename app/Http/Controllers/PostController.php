<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index($limit, $offset)
    {
        $posts = Post::offset($offset)->limit($limit)->get();

        return response()->json([
            'success' => true,
            'data' => $posts
        ], 200);
    }

    public function show($id)
    {
        $posts = Post::where('id', $id)->first();

        return $posts;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:20',
            'content' => 'required|min:200',
            'category' => 'required|min:3',
            'status' => 'required|in:Publish,Draft,Trash',
        ]);
        
        if ($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ]);
        }

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'status' => $request->status
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil ditambahkan'
        ]);

    }

    public function edit($id)
    {
        $posts = Post::findOrFail($id)->get();

        return 'tes';
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:20',
            'content' => 'required|min:200',
            'category' => 'required|min:3',
            'status' => 'required|in:Publish,Draft,Trash',
        ]);
        
        if ($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'message'=>$validator->errors()->all()
            ]);
        }

        Post::where('id', $id)->update([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'status' => $request->status
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diubah'
        ]);
    }

    public function destroy($id)
    {
        Post::findOrFail($id)->delete();

        return response()->json(['success'=>'Data berhasil dihapus!']);
    }
    
    public function dataPublish($limit, $offset)
    {
        $posts = Post::where('status', 'Publish')->offset($offset)->limit($limit)->get();

        return response()->json([
            'success' => true,
            'data' => $posts
        ], 200);
    }

    public function filter($status, $limit, $offset)
    {
        $posts = Post::where('status', $status)->offset($offset)->limit($limit)->get();

        return response()->json([
            'success' => true,
            'data' => $posts
        ], 200);
    }

    public function trash($id)
    {
        Post::where('id', $id)->update([
            'status' => 'Trash'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diubah'
        ]);
    }

    public function countStatus()
    {
        $publish = Post::where('status', 'Publish')->count();
        $draft = Post::where('status', 'Draft')->count();
        $trash = Post::where('status', 'Trash')->count();

        return response()->json([
            'status' => 'success',
            'countPublish' => $publish,
            'countDraft' => $draft,
            'countTrash' => $trash
        ]);
    }

    
}
