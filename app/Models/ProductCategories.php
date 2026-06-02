<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{
    use HasFactory;

    protected $table = 'product_categories';

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name',
        'category_desc',
    ];

    // Relasi: Category hasMany Products
    public function products()
    {
        return $this->hasMany(ProductModel::class, 'category_id', 'category_id');
    }

    // Method untuk GET semua data Categories
    public static function getCategories()
    {
        $categories = self::all();

        return $categories;
    }

    // Method untuk GET data Category by ID
    public static function getCategoryById(int $category_id)
    {
        $category = self::find($category_id);

        return $category;
    }

    // Method untuk POST (create) data Category
    public static function createCategory($data)
    {
        $category = self::create($data);

        return $category;
    }

    // Method untuk PATCH (update) data Category
    public static function updateCategory(int $category_id, $data)
    {
        $category = self::find($category_id);
        $category->update($data);

        return $category;
    }

    // Method untuk DELETE (delete) data Category
    public static function deleteCategory(int $category_id)
    {
        $category = self::find($category_id);
        $category->delete();

        return $category;
    }
}
