<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Reservation;
use App\Entities\ReservationEntity;

class ReservationController extends BaseController
{
    use ResponseTrait;

    /**
     * [GET] api/reservation
     * 取得所有評論
     * @param mixed $limit 資料筆數
     * @param mixed $offset 資料起算指標
     * @param mixed $category 店家分類ID
     * @param mixed $restaurant 店家ID
     * @param mixed $isRecommend 星等推薦 0=>否 | 1=>是
     * @return void
     */
    public function index()
    {
        $limit       = $this->request->getGet("limit") ?? 20;
        $offset      = $this->request->getGet("offset") ?? 0;
        $category    = $this->request->getGet("category") ?? "";
        $restaurant  = $this->request->getGet("restaurant") ?? "";
        $isRecommend = $this->request->getGet("isRecommend") ?? 1;

        $reservationModel  = new Reservation();
        $reservationEntity = new ReservationEntity();

        $query = $reservationModel->orderBy("rating", $isRecommend ? "DESC" : "ASC");

        if($category !== ""){
            $query->where("category_key",$category);
        }

        if($restaurant !== ""){
            $query->where("restaurant_key",$restaurant);
        }

        $dataCount   = $query->countAllResults(false);
        $reservation = $query->findAll($limit, $offset);

        $data = [
            "list"      => [],
            "dataCount" => $dataCount
        ];

        if ($reservation) {
            foreach ($reservation as $reservationEntity) {
                $reservationData = [
                    "reservation_key" => $reservationEntity->reservation_key,
                    "restaurant_key"  => $reservationEntity->restaurant_key,
                    "u_key"           => $reservationEntity->u_key,
                    "text"            => $reservationEntity->text,
                    "rating"          => $reservationEntity->rating,
                    "createdAt"       => $reservationEntity->createdAt,
                    "updatedAt"       => $reservationEntity->updatedAt
                ];
                $data["list"][] = $reservationData;
            }
        } else {
            return $this->fail("Reservation data not found", 404);
        }

        return $this->respond([
            "status" => true,
            "data"   => $data,
            "msg"    => "Reservation index method successful."
        ]);

    }
    
    /**
     * [GET] api/reservation/{reservationKey}
     *
     * @param integer $reservationKey
     * @return void
     */
    public function show(int $reservationKey)
    {
        $reservationModel  = new Reservation();
        $reservationEntity = new ReservationEntity();

        $reservationEntity = $reservationModel->find($reservationKey);

        if ($reservationEntity) {
            $data = [
                "reservation_key" => $reservationEntity->reservation_key,
                "restaurant_key"  => $reservationEntity->restaurant_key,
                "u_key"           => $reservationEntity->u_key,
                "text"            => $reservationEntity->text,
                "rating"          => $reservationEntity->rating,
                "createdAt"       => $reservationEntity->createdAt,
                "updatedAt"       => $reservationEntity->updatedAt
            ];
        } else {
            return $this->fail("Reservation data not found", 404);
        }

        return $this->respond([
            "data" => $data,
            "msg"  => "Reservation show method successful."
        ]);
    }

    /**
     * [POST] api/reservation
     * 新增評論
     * @param mixed $text 評論文字
     * @param mixed $u_key 使用者主健
     * @param mixed $rating 評分 0~5
     * @param mixed $restaurant_key 店家ID
     * @return void
     */
    public function create()
    {
        $data = $this->request->getJSON(true);

        $text           = $data["text"] ?? null;
        $u_key          = $data["u_key"]   ?? null;
        $rating         = $data["rating"] ?? null;
        $restaurant_key = $data["restaurant_key"]  ?? null;

        if (is_null($text) || is_null($u_key) || is_null($rating) || is_null($restaurant_key)) {
            return $this->fail("缺少傳入資料", 404);
        }

        $reservationModel  = new Reservation();
        $reservationEntity = new ReservationEntity();

        $reservationEntity->text           = $text;
        $reservationEntity->u_key          = $u_key;
        $reservationEntity->rating         = $rating;
        $reservationEntity->restaurant_key = $restaurant_key;

        $reservationData = $reservationModel->insert($reservationEntity);

        if ($reservationData) {
            return $this->respond([
                "status" => true,
                "data"   => $reservationData,
                "msg"    => "評論建立成功"
            ]);
        } else {
            return $this->fail("評論建立失敗，請重試", 400);
        }
    }

    /**
     * [PUT] api/reservation
     * 修改評論
     * @param integer $reservationKey
     * @return void
     */
    public function update(int $reservationKey)
    {
        $data = $this->request->getJSON(true);

        $text           = $data["text"] ?? null;
        $u_key          = $data["u_key"]   ?? null;
        $rating         = $data["rating"] ?? null;

        if (is_null($text) && is_null($u_key) && is_null($rating)) {
            return $this->fail("缺少傳入資料", 404);
        }

        $reservationModel  = new Reservation();
        $reservationEntity = new ReservationEntity();

        $reservationEntity = $reservationModel->find($reservationKey);
        if (is_null($reservationEntity)) {
            return $this->fail("該評論不存在", 404);
        }

        // $reservationEntity->restaurant_key = $reservationKey;
        if (!is_null($text)) {
            $reservationEntity->text = $text;
        }
        if (!is_null($u_key)) {
            $reservationEntity->u_key = $u_key;
        }
        if (!is_null($rating)) {
            $reservationEntity->rating = $rating;
        }
        
        $result = $reservationModel->where('reservation_key', $reservationKey)
                                   ->save($reservationEntity);
        var_dump($result);
        if ($result) {
            return $this->respond([
                "status" => true,
                "msg"    => "評論更新成功"
            ]);
        } else {
            return $this->fail("評論更新失敗", 400);
        }
    }

    /**
     * [DELETE] api/reservation
     * 刪除評論
     * @param integer $reservationKey
     * @return void
     */
    public function delete(int $reservationKey)
    {
        $reservationModel  = new Reservation();

        $data  = $this->request->getJSON(true);
        $u_key = $data["u_key"] ?? null;


        $reservationEntity = $reservationModel->find($reservationKey);
        if (is_null($reservationEntity)) {
            return $this->fail("該評論不存在", 404);
        }

        if($reservationEntity->u_key != $u_key){
            return $this->fail("錯誤! 該評論非該使用者建立", 404);
        }
        $result = $reservationModel->delete($reservationKey);

        return $this->respond([
            "status" => true,
            "id"     => $result,
            "msg"    => "評論刪除成功"
        ]);
    }
}
