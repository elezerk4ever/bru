<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function store(){
        if(request()->book_cat != 'novel'){
            $validated = request()->validate([
                'book_id'=>'required',
                'title'=>'required',
                'type'=>'required',
                'art_scene'=>'image',
                'cost'=>'',
                'publish_date'=>'required|date|after:today',
                'content'=>'required|mimes:pdf'
            ]);

            $path = request()->content->store('public/chapter_pdf');
            $array_path = explode('/', $path);
            $end_path = end($array_path);
            $newpath = '/storage/chapter_pdf/'.$end_path;
            $validated['content'] = $newpath;
            if(request()->art_scene){
                $art_path = request()->art_scene->store('public/art_scenes');
                $art_path_array = explode('/', $art_path);
                $end_path = end($art_path_array);
                $newpath = '/storage/art_scenes/'.$end_path;
                $validated['art_scene'] = $newpath;
            }
            Chapter::create($validated);
            return back()->withSuccess('Done!');

            
        }else {
            $validated = request()->validate([
                'book_id'=>'required',
                'title'=>'required',
                'type'=>'required',
                'art_scene'=>'image',
                'cost'=>'',
                'publish_date'=>'required|date|after:today',
                'content'=>'required'
            ]);
            if(request()->art_scene){
                $art_path = request()->art_scene->store('public/art_scenes');
                $art_path_array = explode('/', $art_path);
                $end_path = end($art_path_array);
                $newpath = '/storage/art_scenes/'.$end_path;
                $validated['art_scene'] = $newpath;
            }
            Chapter::create($validated);
            return back()->withSuccess('Done!');
        }
        
        
    }
}
