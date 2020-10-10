<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Traits\PageView;
use App\Jobs\SlugTrans;

class Topic extends Model
{
    use PageView;

    protected $fillable = [
        'user_id', 'category_id', 'content', 'title',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function(Topic $topic) {
            $topic->content = clean($topic->content);
            $topic->summary = $topic->makeSummary();
        });

        static::saved(function(Topic $topic) {
            if(!$topic->slug || $topic->isDirty('title')) {
                dispatch(new SlugTrans($topic));
            }
        });
    }

    public function makeSummary($limit = 100)
    {
        $content = strip_tags($this->content);
        $summary = trim(preg_replace('/\r\n|\r|\n/', '', $content));
        $summary = Str::limit($summary, $limit);

        return $summary;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function link($params = [])
    {
        return route('topics.show', array_merge([$this, 'slug' => $this->slug], $params));
    }
}
