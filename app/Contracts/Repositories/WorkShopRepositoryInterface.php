<?php

namespace App\Contracts\Repositories;

interface WorkShopRepositoryInterface
{
    public function getAllWorkShops();
    public function findWorkShopById($id);
    public function findWorkShopProductById($id);
    public function createWorkShop(array $data);
    public function createWorkShopproduct(array $data);
    public function updateWorkShop($id, array $data);
    public function updateWorkShopProductData($id, array $data);
    public function deleteWorkShop($id);
    public function deleteWorkShopProduct($id);
}
