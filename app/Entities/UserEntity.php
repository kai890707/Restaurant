<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class UserEntity extends Entity
{
    /**
     * user key
     *
     * @var int
     */
    protected $u_key;

    /**
     * user name
     *
     * @var string
     */
    protected $name;

    /**
     * user email
     *
     * @var string
     */
    protected $email;

    /**
     * user password
     *
     * @var string
     */
    protected $password;

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
