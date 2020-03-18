<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFollow\Traits\CanBeVoted;

use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class Post extends Model implements Viewable
{
    use InteractsWithViews;
    use CanBeVoted;

    protected $fillable = [
        'body', 'blog_image', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    
}
