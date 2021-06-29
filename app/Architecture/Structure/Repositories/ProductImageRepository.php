<?php

namespace App\Architecture\Structure\Repositories;

use App\Architecture\Helpers\PaginatorHelper;
use App\Models\ProductImage;

class ProductImageRepository extends ProductImage
{
    public function buildEmptyModel()
    {
        return $emptyModel = [
            'id' => 0,
            'url' => '',
            'isPrincipal' => false,
            'state' => true,
            'idProduct' => 0,
        ];
    }

    public function getById($id)
    {
        return ProductImageRepository::select('product_image.*')
            ->where('product_image.id', $id)
            ->first();
    }

    public function getByDefault($id)
    {
        return ProductImageRepository::select('product_image.*')
            ->where('product_image.id', $id)
            ->where('product_image.isPrincipal', true)
            ->first();
    }

    public function store(ProductImage $productImage)
    {
        if($productImage->id == 0) {
            return $productImage->save();
        } else {
            return $productImage->update();
        }
    }

    public function getAllByProduct($idProduct)
    {
        return ProductImageRepository::select('product_image.*')
            ->where('product_image.idProduct', $idProduct)
            ->where('product_image.state', true)
            ->get();
    }
}
