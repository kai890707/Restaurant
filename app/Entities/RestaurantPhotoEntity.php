<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class RestaurantPhotoEntity extends Entity
{
    /**
     * restaurantPhoto primary key
     *
     * @var int
     */
    protected $restaurantPhoto_key;

    /**
     * restaurant foreign key
     *
     * @var int
     */
    protected $restaurant_key;

    /**
     * Restaurant photo_reference
     *
     * @var string
     */
    protected $photo_reference;

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
        'u_key' => 'int'
    ];

    protected $dates = [];
}
