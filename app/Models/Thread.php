<?php

namespace App\Models;

use App\Traits\HasTags;
use App\Models\Category;
use App\Traits\HasAuthor;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Thread extends Model
{
    use HasFactory;
    use HasTags;
    use HasAuthor;

    protected $fillable = [
        'title',
        'body',
        'slug',
        'category_id',
        'author_id',
    ];
    protected $with = [
        'category',
        'tagsRelation',
        'authorRelation',
    ];

    public function excerpt(int $limit = 250): string
    {
        return Str::limit(strip_tags($this->body()), $limit);
    }

    public function title(): string
    {
        return $this->title;
    }
    public function slug(): string
    {
        return $this->slug;
    }
    public function body(): string
    {
        return $this->body;
    }
    public function delete()
    {
        $this->removeTags();
        parent::delete();
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
