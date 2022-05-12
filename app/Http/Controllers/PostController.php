<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $posts = Post::where('id', $id)->get();

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
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'status' => $request->status
        ]);

        return response()->json(['success' => 'Data berhasil ditambahkan']);

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
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        Post::where('id', $id)->update([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'status' => $request->status
        ]);

        return response()->json(['success' => 'Data berhasil diubah']);
    }

    public function destroy($id)
    {
        Post::findOrFail($id)->delete();

        return response()->json(['success'=>'Data berhasil dihapus!']);
    }
}
