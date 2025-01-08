<?php

namespace App\Repositories;

use App\Models\WorkShopCategory;
use App\Models\WorkShopProduct;
use App\Contracts\Repositories\WorkShopRepositoryInterface;

class WorkShopRepository implements WorkShopRepositoryInterface
{
    public function getAllWorkShops()
    {
        return WorkShopCategory::all();
    }

    public function findWorkShopById($id)
    {
        return WorkShopCategory::find($id);
    }

    public function findWorkShopProductById($id)
    {
        return WorkShopProduct::find($id);
    }

    public function createWorkShop(array $data)
    {
        return WorkShopCategory::create($data);
    }
    
    public function createWorkShopproduct(array $data)
    {
        return WorkShopProduct::create($data);
    }
    public function updateWorkShop($id, array $data)
    {
        $workshop = WorkShopCategory::find($id);
        if ($workshop) {
            $workshop->update($data);
            return $workshop;
        }
        return null;
    }

    public function updateWorkShopProductData($id, array $data)
    {
        $workshop = WorkShopProduct::find($id);
        if ($workshop) {
            $workshop->update($data);
            return $workshop;
        }
        return null;
    }

    public function deleteWorkShop($id)
    {
        $workshop = WorkShopCategory::find($id);
        if ($workshop) {
            $workshop->delete();
            return true;
        }
        return false;
    }
    
    public function deleteWorkShopProduct($id)
    {
        $workshop = WorkShopProduct::find($id);
        if ($workshop) {
            $workshop->delete();
            return true;
        }
        return false;
    }
}
