<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class RestaurantEntity extends Entity
{
    /**
     * restaurant key
     *
     * @var int
     */
    protected $restaurant_key;

    /**
     * category key - foreign
     *
     * @var int
     */
    protected $category_key;

    /**
     * restaurant name
     *
     * @var string
     */
    protected $name;

    /**
     * restaurant phoneNumber
     *
     * @var string
     */
    protected $phoneNumber;

    /**
     * restaurant address
     *
     * @var string
     */
    protected $address;

    /**
     * restaurant weekday
     *
     * @var string
     */
    protected $weekday;

    /**
     * lat
     *
     * @var string
     */
    protected $lat;

    /**
     * lng
     *
     * @var string
     */
    protected $lng;

    /**
     * restaurant rating
     *
     * @var string
     */
    protected $rating;

    /**
     * restaurant website
     *
     * @var string
     */
    protected $website;

    /**
     * restaurant rating
     *
     * @var string
     */
    protected $placeID;

    /**
     * 建立時間
     *
     * @var string
     */
    protected $createdAt;

    /**
     * 最後更新時間
     *
     * @var string
     */
    protected $updatedAt;

    /**
     * 刪除時間
     *
     * @var string
     */
    protected $deletedAt;

    protected $datamap = [
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
        'deletedAt' => 'deleted_at'
    ];

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
        'rating' => 'float'
    ];

    protected $dates = [];
}
