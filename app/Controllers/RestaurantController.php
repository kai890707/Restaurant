<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Restaurant;
use App\Entities\RestaurantEntity;

class RestaurantController extends BaseController
{
    use ResponseTrait;

    /**
     * [GET] api/restaurant
     * 取得所有餐廳資料
     * @param mixed $limit 資料筆數
     * @param mixed $offset 資料起算指標
     * @param mixed $search 店家名稱
     * @param mixed $category 店家類別ID
     * @param mixed $isRecommend 星等推薦 0=>否 | 1=>是
     * @return void
     */
    public function index()
    {
        $limit       = $this->request->getGet("limit") ?? 20;
        $offset      = $this->request->getGet("offset") ?? 0;
        $search      = $this->request->getGet("search") ?? "";
        $category    = $this->request->getGet("category") ?? "";
        $isRecommend = $this->request->getGet("isRecommend") ?? 1;

        $restaurantModel  = new Restaurant();
        $restaurantEntity = new RestaurantEntity();

        $query = $restaurantModel->orderBy("rating", $isRecommend ? "DESC" : "ASC");

        if ($search !== "") {
            $query->like("name", $search);
        }

        if($category !== ""){
            $query->where("category_key",$category);
        }

        $dataCount  = $query->countAllResults(false);
        $restaurant = $query->findAll($limit, $offset);

        $data = [
            "list"      => [],
            "dataCount" => $dataCount
        ];

        if ($restaurant) {
            foreach ($restaurant as $restaurantEntity) {
                $restaurantData = [
                    "restaurant_key" => $restaurantEntity->restaurant_key,
                    "category_key"   => $restaurantEntity->category_key,
                    "name"           => $restaurantEntity->name,
                    "address"        => $restaurantEntity->address,
                    "phoneNumber"    => $restaurantEntity->phoneNumber,
                    "weekday"        => unserialize($restaurantEntity->weekday),
                    "lat"            => $restaurantEntity->lat,
                    "lng"            => $restaurantEntity->lng,
                    "rating"         => $restaurantEntity->rating,
                    "website"        => $restaurantEntity->website,
                    "placeID"        => $restaurantEntity->placeID,
                    "createdAt"      => $restaurantEntity->createdAt,
                    "updatedAt"      => $restaurantEntity->updatedAt
                ];
                $data["list"][] = $restaurantData;
            }
        } else {
            return $this->fail("Restaurant data not found", 404);
        }

        return $this->respond([
            "status" => true,
            "data"   => $data,
            "msg"    => "Restaurant index method successful."
        ]);

    }

    /**
     * [GET] api/restaurant/{restaurantKey}
     * 取得單一餐廳資料
     * @param integer $restaurantKey
     * @return void
     */
    public function show(int $restaurantKey)
    {
        $restaurantModel  = new Restaurant();
        $restaurantEntity = new RestaurantEntity();

        $restaurantEntity = $restaurantModel->find($restaurantKey);

        if ($restaurantEntity) {
            $data = [
                "restaurant_key" => $restaurantEntity->restaurant_key,
                "category_key"   => $restaurantEntity->category_key,
                "name"           => $restaurantEntity->name,
                "address"        => $restaurantEntity->address,
                "phoneNumber"    => $restaurantEntity->phoneNumber,
                "weekday"        => unserialize($restaurantEntity->weekday),
                "lat"            => $restaurantEntity->lat,
                "lng"            => $restaurantEntity->lng,
                "rating"         => $restaurantEntity->rating,
                "website"        => $restaurantEntity->website,
                "placeID"        => $restaurantEntity->placeID,
                "createdAt"      => $restaurantEntity->createdAt,
                "updatedAt"      => $restaurantEntity->updatedAt
            ];
        } else {
            return $this->fail("Restaurant data not found", 404);
        }

        return $this->respond([
            "data" => $data,
            "msg"  => "Restaurant show method successful."
        ]);
    }
}
