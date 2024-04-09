<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleModel extends Model
{
    use HasFactory;

    protected $table = 'articles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'description',
        'short_description',
        'price',
        'price_by',
        'contact_name',
        'whatsapp_number',
        'article_seo',
        'category_id',
        'author_id',
        'address',
        'link_google_maps',
        'embed_gmaps_link',
        'thumbnail_name',
        'thumbnail_path',
    ];

    public function photos() : HasMany 
    {
        return $this->HasMany(ArticlePhotoModel::class, 'article_id');
    }

    public function category() 
    {
        return $this->belongsTo(CategoriesModel::class, 'category_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'article_seo';
    }
}
