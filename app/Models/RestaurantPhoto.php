<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\RestaurantPhotoEntity;

class RestaurantPhoto extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'restaurantPhoto';
    protected $primaryKey       = 'restaurantPhoto_key';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = RestaurantPhotoEntity::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ["restaurantPhoto_key","restaurant_key","photo_reference"];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
