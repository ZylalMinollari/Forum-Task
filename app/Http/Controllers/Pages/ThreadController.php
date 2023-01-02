<?php

namespace App\Http\Controllers\Pages;

use App\Models\Tag;
use App\Models\Thread;
use App\Models\Category;
use App\Jobs\CreateThread;
use App\Jobs\UpdateThread;
use Illuminate\Http\Request;
use App\Policies\ThreadPolicy;
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
        $this->dispatchSync(CreateThread::fromRequest($request));
        return redirect()->route('threads.index')->with('success', 'Thread created!');
    }


    public function show(Category $category,Thread $thread)
    {
        return view('pages.threads.show', compact('thread', 'category'));
    }

    public function edit(Thread $thread)
    {
        $this->authorize(ThreadPolicy::UPDATE, $thread);
        $tags = Tag::all();
        $oldTags = $thread->tags()->pluck('id')->toArray();
        $categories = Category::all();
        $selectedCategory = $thread->category;

        return view('pages.threads.edit', compact('thread','tags','oldTags','categories','selectedCategory'));
    }

    public function update(Request $request, Thread $thread)
    {
        $this->authorize(ThreadPolicy::UPDATE, $thread);

        $this->dispatchSync(UpdateThread::fromRequest($thread, $request));

        return redirect()->route('threads.index')->with('success', 'Thread Updated!');
    }

}
