<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Category;
use App\Entities\CategoryEntity;

class CategoryController extends BaseController
{
    use ResponseTrait;

    /**
     * [GET] api/category
     * 取得所有餐廳類別
     * 
     * @return void
     */
    public function index()
    {
        $categoryModel  = new Category();
        $categoryEntity = new CategoryEntity();

        $categoryEntity = $categoryModel->findAll();

        if(is_null($categoryEntity)){
            return $this->fail("Category data not found", 404);
        }

        return $this->respond([
            "status" => true,
            "data"   => $categoryEntity,
            "msg"    => "Category index method successful."
        ]);
    }

    /**
     * [GET] api/category/{categoryKey}
     *
     * @param integer $categoryKey
     * @return void
     */
    public function show(int $categoryKey)
    {
        $categoryModel  = new Category();
        $categoryEntity = new CategoryEntity();

        $categoryEntity = $categoryModel->where('category_key',$categoryKey)->find();

        if(is_null($categoryEntity)){
            return $this->fail("Category data not found", 404);
        }

        return $this->respond([
            "status" => true,
            "data"   => $categoryEntity,
            "msg"    => "Category show method successful."
        ]);
    }
}
