<?php

namespace App\Http\Controllers\Pages;

use App\Models\Tag;
use App\Models\Thread;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Tag $tag )
    {
        $threads = Thread::ForTag($tag->slug)->paginate(10);
        return view('pages.tags.index',compact('threads'));
    }

   
}
