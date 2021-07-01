<?php

namespace App\Architecture\Structure\Services;

use App\Architecture\Mappers\ProductCategoryMapper;
use App\Architecture\Mappers\ProductImageMapper;
use App\Architecture\Mappers\ProductMapper;
use App\Architecture\Structure\Repositories\ProductCategoryRepository;
use App\Architecture\Structure\Repositories\ProductImageRepository;
use App\Architecture\Structure\Repositories\ProductRepository;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    protected $productRepository;
    protected $productMapper;
    protected $productImageRepository;
    protected $productImageMapper;
    protected $productCategoryRepository;
    protected $productCategoryMapper;

    public function __construct
    (
        ProductRepository $productRepository,
        ProductMapper $productMapper,
        ProductImageRepository $productImageRepository,
        ProductImageMapper $productImageMapper,
        ProductCategoryRepository $productCategoryRepository,
        ProductCategoryMapper $productCategoryMapper
    )
    {
        $this->productRepository = $productRepository;
        $this->productMapper = $productMapper;
        $this->productImageRepository = $productImageRepository;
        $this->productImageMapper = $productImageMapper;
        $this->productCategoryRepository = $productCategoryRepository;
        $this->productCategoryMapper = $productCategoryMapper;
    }

    public function getById($id)
    {
        if($id == 0) return $this->productRepository->buildEmptyModel();
        return $this->productRepository->getById($id);
    }

    public function getAllPaginateToIndex($filterText)
    {
        return  $this->productRepository->getAllPaginateToIndex(10, $filterText);
    }

    public function store($request)
    {
        $listImage = $request->get('listImage');
        $listCategory = $request->get('listCategory');
        $listImageDelete = $request->get('listImageDelete');
        $listCategoryDelete = $request->get('listCategoryDelete');

        if($request->get('id') == 0) {
            //CREATE PRODUCT
            $model = $this->productMapper->objectRequestToModel($request->all());
            $response = $this->productRepository->store($model);
            if(!is_numeric($response->id)) return false;
            if(count($listImage)>0){
                //SAVE IMAGE
                $this->saveImage($listImage, $response->id);
            }
            if(count($listCategory)>0){
                //SAVE CATEGORY
                $this->saveCategory($listCategory, $response->id);
            }
            if(count($listCategoryDelete)>0){
                //DELETE CATEGORY
                $this->deleteCategory($listCategoryDelete, $response->id);
            }
            return is_numeric($response->id) ?? false;
        }
        else {
            //EDIT PRODUCT
            $model = $this->productRepository->getById($request->get('id'));
            $model->fill($request->all());
            $response = $this->productRepository->store($model);

            if(count($listImage)>0){
                //SAVE IMAGE
                $this->saveImage($listImage, $request->get('id'));
            }
            if(count($listCategory)>0){
                //SAVE CATEGORY
                $this->saveCategory($listCategory, $response->id);
            }
            if(count($listCategoryDelete)>0){
                //DELETE CATEGORY
                $this->deleteCategory($listCategoryDelete, $response->id);
            }
            if(is_array($listImageDelete)){
                //DELETE IMAGE
                if(count($listImageDelete)>0){
                    $idImages = [];
                    $idImagesToDelete = [];
                    foreach ($request->get('images') as $image)
                    {
                        array_push($idImages, $image['id']);
                    }
                    for ($i=0; $i<count($idImages);$i++)
                    {
                        $aux = array_column($listImageDelete, 'id');
                        $index = array_search($idImages[$i], $aux);
                        if($index===false){
                            array_push($idImagesToDelete, $idImages[$i]);
                        }
                    }
                    foreach ($idImagesToDelete as $idImageToDelete)
                    {
                        $this->deleteImage($idImageToDelete);
                    }
                } else {
                    foreach ($request->get('images') as $imageToDelete)
                    {
                        $this->deleteImage($imageToDelete['id']);
                    }
                }
            }
            return is_numeric($response->id) > 0 ?? false;
        }
    }

    public function saveImage($listImage, $idProduct)
    {
        foreach ($listImage as $image)
        {
            if($image['id']!=0){
                $this->deleteImageDefault($image['id']);
            }
        }
        foreach ($listImage as $image)
        {
            $productImage = $this->productImageRepository->getById($image['id']);
            if($productImage==null){
                $productImage = $this->productImageRepository->buildEmptyModel();
                $responseImage = $this->storageImage($image['file']);
                if($responseImage[0]) {
                    $productImage['url'] = $responseImage[1];
                    $productImage['isPrincipal'] = $image['highlight'] == 1 ?? false;
                    $productImage['idProduct'] = $idProduct;
                    $productImageModel = $this->productImageMapper->objectRequestToModel($productImage);
                    $this->productImageRepository->store($productImageModel);
                }
            } else {
                $productImage['isPrincipal'] = $image['highlight'] == 1 ?? false;
                $this->productImageRepository->store($productImage);
            }
        }
    }

    public function deleteImageDefault($idProductImage)
    {
        $productImageDefault = $this->productImageRepository->getByDefault($idProductImage);
        if($productImageDefault!=null){
            $productImageDefault['isPrincipal'] = false;
            $this->productImageRepository->store($productImageDefault);
        }
    }

    public function deleteImage($idProductImage)
    {
        $productImage = $this->productImageRepository->getById($idProductImage);
        $productImage['state'] = false;
        $this->productImageRepository->store($productImage);

        Storage::disk('public')->delete($productImage['url']);
    }

    public function storageImage($img)
    {
        $folderPath = "products/";
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() . '.'.$image_type;

        $response = Storage::disk('public')->put($file, $image_base64);

        return [$response, $file];
    }

    public function addStock($idProduct, $quantity)
    {
        $product = $this->productRepository->getById($idProduct);
        $product['stock'] = $product['stock'] + $quantity;
        $this->productRepository->store($product);
    }

    public function reduceStock($idProduct, $quantity)
    {
        $product = $this->productRepository->getById($idProduct);
        $product['stock'] = $product['stock'] - $quantity;
        $this->productRepository->store($product);
    }

    public function saveCategory($listCategory, $idProduct)
    {
        foreach ($listCategory as $category)
        {
            $productCategory = $this->productCategoryRepository->getByCategoryAndProduct($idProduct, $category);
            if($productCategory==null) {
                $productCategory = $this->productCategoryRepository->buildEmptyModel();
                $productCategory['idCategory'] = $category;
                $productCategory['idProduct'] = $idProduct;
                $productCategoryModel = $this->productCategoryMapper->objectRequestToModel($productCategory);
                $this->productCategoryRepository->store($productCategoryModel);
            } else {
                $productCategory['state'] = true;
                $this->productCategoryRepository->store($productCategory);
            }
        }
    }

    public function deleteCategory($listCategoryDelete, $idProduct)
    {
        foreach ($listCategoryDelete as $category)
        {
            $productCategory = $this->productCategoryRepository->getByCategoryAndProduct($idProduct, $category['idCategory']);
            $productCategory['state'] = false;
            $this->productCategoryRepository->store($productCategory);
        }
    }
}
