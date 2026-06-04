<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'quantity',
        'quality',
        'image',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) return null;
        
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        
        $publicId = pathinfo($this->image, PATHINFO_FILENAME);
        return "https://res.cloudinary.com/doolftkw6/image/upload/{$publicId}";
    }
}