<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
class ArticleController extends Controller
{
    public function addArticle(Request $request)
    {
        $rules = [
            'name' => 'required',
            'photo' => 'required',
            'type' => 'required',
            'link' => 'required',
        ];

        $this->validate($request, $rules);

        $article = new Article;
        $article->name = $request->name;
        $article->type = $request->type;
        $article->link = $request->link;
        $article->description = $request->description;

        $foto = $request->file('photo');
        $extension = $foto->getClientOriginalExtension();
        $foto->move('data_gambar',$foto->getFilename().'.'.$extension);
        $pathDefault = 'https://api.vmcafe.id/data_gambar/';
        $article->photo = $pathDefault.$foto->getFilename().'.'.$extension;

        // $foto = $request->file('photo');
        // $extension = $foto->getClientOriginalExtension();
        // $foto->move('data_gambar',$foto->getFilename().'.'.$extension);
        // $article->photo = $foto->getFilename().'.'.$extension;
        // $tujuan = 'data_gambar';
        // $article->photo->move($tujuan, $article->photo->getClientOriginalExtension());

        $article->save();

        return $this->responseSuccess($article);
    }

    public function getArticle()
    {
        $data = Article::where('type', 1)
        ->get();

        return response()
        ->json(['data' => $data], 200);
    }

    public function getArticleBig()
    {
        $data = Article::where('type', 0)
        ->get();

        return response()
        ->json(['data' => $data], 200);
    }
}
