<?php

namespace App\Contracts\Repositories;

interface WorkShopRepositoryInterface
{
    public function getAllWorkShops();
    public function findWorkShopById($id);
    public function createWorkShop(array $data);
    public function updateWorkShop($id, array $data);
    public function deleteWorkShop($id);
}
