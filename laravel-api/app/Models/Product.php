<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();
        static::created(function ($product) {
            $product->slug = $product->createSlug($product->name);
            $product->save();
        });
    }

    private function createSlug($product_name)
    {
        if (static::where('slug', $product_slug = Str::slug($product_name))->exists()) {
            $max = static::where('name', $product_name)->latest('id')->skip(1)->value('slug');

            if (is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function ($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }
            return "{$product_slug}-2";
        }
        return $product_slug;
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class)
            ->select(['id', 'name', 'email', 'avatar']);
    }

    public function productCategory(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_product_category', 'product_id', 'category_id')
            ->withPivot('category_id');
    }

    public function scopeWithFilters($query, $searchQuery, $category, $price, $location)
    {
        return $query->when($searchQuery, function ($query) use ($searchQuery) {
            $query->where('name', 'LIKE', '%' . $searchQuery . '%');
            $query->orWhere('slug', 'LIKE', '%' . $searchQuery . '%');
            $query->orWhereHas('productCategory', function ($q) use ($searchQuery) {
                $q->where('name', 'LIKE', '%' . $searchQuery . '%');
            });
        })->when($category, function ($query) use ($category) {
            $query->whereHas('productCategory', function ($q) use ($category) {
                $q->whereIn('id', $category);
            });
        });
    }
}
