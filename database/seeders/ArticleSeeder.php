<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = json_decode(file_get_contents(public_path().'/articles.json'));
        foreach($articles as $article){
            \App\Models\Article::create([
                                'date'=>$article->date,
                                'name'=>$article->name,
                                'desc'=>$article->desc,
                                'user_id'=>random_int(1,2)
                            ]);
        }
    }
}
