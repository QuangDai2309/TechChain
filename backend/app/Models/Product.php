<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    // protected $dates = ['deleted_at']; // hoặc bạn có thể dùng 'casts'
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'stock',
        'category_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
