<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleComment extends Model
{
    protected $table = 'article_comments';
    protected $fillable = ['article_id', 'commenter_name', 'content'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
