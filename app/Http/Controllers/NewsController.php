<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsComment;
use App\Models\User;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function store(Request $request)
    {
        $userId = $request->user()->id;
        if (!$userId) {
            return response()->json([
                'message' => 'Autentikasi gagal'
            ], 401);
        }

        $usercek = User::select("type")->where("id",$userId)->get();
        
        if ($usercek[0]->type != 'Admin') {
            return response()->json([
                'message' => 'Hanya admin yang bisa menambahkan berita'
            ], 403);
        }

        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]);
        
        if ($request->image) {
            $imageName  = time().'.'.$request->nik.'.'.$request->image->extension();
        }

        $news = new News();
        $news->title = $request->title;
        $news->content = $request->content;
        $news->image = $imageName ?? null;
        $news->created_by = $userId;
        $news->edited_by = $userId;
        $news->save();

        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }

    public function newsDetail()
    {
        $data = News::select("*")->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $data = News::select("*")->where('id',$id)->get();

        return response()->json([
            'success' => true,
            'data' => $data[0]
        ]);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]);

        $news = News::find($id);

        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News not found'
            ], 404);
        }

        if ($request->image) {
            $imageName  = time().'.'.$request->nik.'.'.$request->image->extension();
        }else{
            $imageName = $news->image;
        }

        $news->title = $request->title;
        $news->content = $request->content;
        $news->image = $imageName;
        $news->save();

        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }

    public function destroy($id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $news->delete();

        return response()->json([
            'success' => true
        ]);
    }

    public function addComment(Request $request)
    {
        $userId = $request->user()->id;
        if (!$userId) {
            return response()->json([
                'message' => 'Autentikasi gagal'
            ], 401);
        }

        $this->validate($request, [
            'id_news' => 'required',
            'comment' => 'required'
        ]);

        $news = new NewsComment();
        $news->id_news = $request->id_news;
        $news->comment = $request->comment;
        $news->create_by = $userId;
        $news->save();

        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }


}
