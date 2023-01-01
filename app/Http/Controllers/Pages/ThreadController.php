<?php

namespace App\Http\Controllers\Pages;

use App\Models\Tag;
use App\Models\Thread;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ThreadStoreRequest;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, EnsureEmailIsVerified::class])->except(['index', 'show']);
    }
    
    public function index()
    {
        $threads = Thread::orderBy('created_at','desc')->paginate(5);
        return view('pages.threads.index', compact('threads'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('pages.threads.create', compact('categories', 'tags'));
    }

    public function store(ThreadStoreRequest $request)
    {
        $thread = new Thread;
        $thread->title = $request->title;
        $thread->slug = Str::slug($request->title);
        $thread->body = Purifier::clean($request->body);
        $thread->category_id = $request->category_id;
        $thread->author_id = Auth::id();
        $thread->save();
        $thread->syncTags($request->tags);
        return redirect()->route('threads.index')->with('success', 'Thread created!');
    }


    public function show(Category $category,Thread $thread)
    {
        return view('pages.threads.show', compact('thread', 'category'));
    }

    public function edit(Thread $thread)
    {
        //
    }

    public function update(Request $request, Thread $thread)
    {
        //
    }

    public function destroy(Thread $thread)
    {
        //
    }
}
