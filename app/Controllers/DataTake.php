<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use SDPMlab\Anser\Service\Action;
use Psr\Http\Message\ResponseInterface;
use App\Models\Restaurant;
use App\Models\RestaurantPhoto;
use App\Entities\RestaurantEntity;
use App\Models\Category;
use App\Models\Reservation;

class DataTake extends BaseController
{
    /**
     * google api token
     *
     * @var string
     */
    public static $apiToken;

    /**
     * google api host
     *
     * @var string
     */
    protected static $apiHost = "https://maps.googleapis.com";

    /**
     * google place subAddress
     *
     * @var string
     */
    protected static $apiHref = "/maps/api/place/nearbysearch/json";

    /**
     * google place detail subAddress
     *
     * @var string
     */
    protected static $apiPlaceDetailHref = "maps/api/place/details/json";

    public function __construct()
    {
        static::$apiToken = getenv('API_TOKEN');
    }

    /**
     * call google api to take data
     *
     * @return void
     */
    public function index()
    {
        $categoryModel = new  Category();
        $categoryResult = $categoryModel->findAll();
        foreach ($categoryResult as $category) {
            $this->insertDataByFood($category->category_key, $category->type);
        }
    }

    /**
     * call google place api to take Level 1 data
     *
     * @param integer $categoryKey
     * @param string $categoryType
     * @return void
     */
    public function insertDataByFood(int $categoryKey, string $categoryType)
    {
        $action = (new Action(
            static::$apiHost,
            "GET",
            static::$apiHref
        ))->addOption("query", [
            "location" => "25.0338,121.5646",
            "radius" => "1000",
            "language" => "zh-TW",
            "keyword" => $categoryType,
            "key" => static::$apiToken,
        ])->doneHandler(function (
            ResponseInterface $response,
            Action $runtimeAction
        ) {
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);
            $runtimeAction->setMeaningData($data);
        });

        $data = $action->do()->getMeaningData();

        $i = 0;
        foreach ($data["results"] as $d) {
            if ($i == 6) {
                break;
            }
            $i++;
            $this->getPlaceDetailAndInsert($d["place_id"], $categoryKey);
        }
    }

    /**
     * call google place detail api to get place data
     *
     * @param string $placeID
     * @param integer $categoryKey
     * @return void
     */
    public function getPlaceDetailAndInsert(string $placeID,int $categoryKey)
    {
        $action = (new Action(
            static::$apiHost,
            "GET",
            static::$apiPlaceDetailHref
        ))->addOption("query", [
            "place_id" => $placeID,
            "language" => "zh-TW",
            "key" => static::$apiToken,
        ])->doneHandler(function (
            ResponseInterface $response,
            Action $runtimeAction
        ) {
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);
            $runtimeAction->setMeaningData($data);
        });

        $data = $action->do()->getMeaningData();

        $result = $data["result"];

        $restaurantModel      = new Restaurant();
        $restaurantPhotoModel = new RestaurantPhoto();
        $restaurantEntity     = new RestaurantEntity();
        $reservationModel     = new Reservation();

        $restaurantEntity->category_key = $categoryKey;
        $restaurantEntity->name         = $result["name"];
        $restaurantEntity->address      = $result["formatted_address"] ?? "尚無地址";
        $restaurantEntity->phoneNumber  = $result["formatted_phone_number"]?? "尚無電話";
        $restaurantEntity->weekday      = serialize($result["current_opening_hours"]["weekday_text"]) ?? serialize("尚無網站");
        $restaurantEntity->lat          = $result["geometry"]["location"]["lat"];
        $restaurantEntity->lng          = $result["geometry"]["location"]["lng"];
        $restaurantEntity->rating       = $result["rating"] ?? "尚無評等" ;
        $restaurantEntity->website      = $result["website"] ?? "尚無網站" ;
        $restaurantEntity->placeID      = $result["place_id"];

        $restaurantModel->insert($restaurantEntity);

        $insertID = $restaurantModel->getInsertID();

        $photoData = [];
        foreach ($result["photos"] as $photo) {
            $sub = [
                "restaurant_key"  => $insertID,
                "photo_reference" => $photo["photo_reference"]
            ];
            array_push($photoData, $sub);
        }

        $restaurantPhotoModel->insertBatch($photoData);

        $reservationData = [];

        if(isset($result["reviews"])){
            foreach ($result["reviews"] as $reservation) {
                $sub = [
                    "u_key"          => random_int(1, 10),
                    "restaurant_key" => $insertID,
                    "text"           => $reservation["text"],
                    "rating"         => $reservation["rating"]
                ];

                array_push($reservationData, $sub);
            }

            $reservationModel->insertBatch($reservationData);
        }
       
    }

}
