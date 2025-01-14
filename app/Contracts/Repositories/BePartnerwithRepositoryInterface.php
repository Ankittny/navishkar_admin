<?php

namespace App\Contracts\Repositories;

interface BePartnerWithRepositoryInterface
{
    public function getAllEnquiries();
    public function findEnquiryById(int $id);
    public function createEnquiry(array $data);
    public function updateEnquiry(int $id, array $data);
    public function deleteEnquiry(int $id);
}
