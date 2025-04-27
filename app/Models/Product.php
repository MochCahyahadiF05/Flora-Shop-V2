<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
        'average_rating',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

     // Relasi ke gambar produk
     public function images()
     {
         return $this->hasMany(ProductImage::class);
     }
 
     // Ambil gambar utama produk
     public function mainImage()
     {
         return $this->images()->where('is_main', true)->first();
     }
}
