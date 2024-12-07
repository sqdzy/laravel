<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        $articles = json_decode(file_get_contents('articles.json'));
        return view('main.articles_json', ['articles'=>$articles]);
    }

    public function show($img, $name){
        return view('main.galery', ['img'=>$img, 'name'=>$name]);
    }
}
