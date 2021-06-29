<?php

namespace App\Architecture\Structure\Repositories;

use App\Models\ProductCategory;

class ProductCategoryRepository extends ProductCategory
{
    public function buildEmptyModel()
    {
        return $emptyModel = [
            'id' => 0,
            'state' => true,
            'idProduct' => 0,
            'idCategory' => 0,
        ];
    }

    public function getById($id)
    {
        return ProductCategoryRepository::select('product_category.*')
            ->where('product_category.id', $id)
            ->first();
    }

    public function store(ProductCategory $productCategory)
    {
        if($productCategory->id == 0) {
            return $productCategory->save();
        } else {
            return $productCategory->update();
        }
    }

    public function getAllByProduct($idProduct)
    {
        return ProductCategoryRepository::select('product_category.*')
            ->where('product_category.idProduct', $idProduct)
            ->where('product_category.state', true)
            ->get();
    }
}
