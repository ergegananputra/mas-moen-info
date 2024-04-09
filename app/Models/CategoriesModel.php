<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriesModel extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = ['name', 'slug'];

    public function articles() {
        return $this->hasMany(ArticleModel::class, 'category_id', 'id');
    }

    public function getRouteKeyName() {
        return 'slug';
    }

    public function getArticlesCountAttribute() {
        return $this->articles->count();
    }

    public function getRouteKey() {
        return $this->slug;
    }
}
