<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticlePhotoModel extends Model
{
    use HasFactory;

    protected $table = 'article_photos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'article_id',
        'filename',
        'path',
    ];

    public function article() : BelongsTo {
        return $this->belongsTo(ArticleModel::class);
    }
}
