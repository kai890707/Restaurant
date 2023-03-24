<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\RestaurantEntity;

class Restaurant extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'restaurant';
    protected $primaryKey       = 'restaurant_key';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = RestaurantEntity::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ["restaurant_key","category_key","name","address","phoneNumber","weekday","lat","lng","rating","website","placeID"];

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
