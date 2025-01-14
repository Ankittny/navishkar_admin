<?php

namespace App\Repositories;

use App\Models\Data;
use App\Contracts\Repositories\DataRepositoryInterface;

class DataRepository implements DataRepositoryInterface
{
    protected $model;

    public function __construct(Data $model)
    {
        $this->model = $model;
    }

    public function getAllEnquiries()
    {
        return $this->model->all();
    }

    public function findEnquiryById(int $id)
    {
        return $this->model->find($id);
    }

    public function createEnquiry(array $data)
    {
        return $this->model->create($data);
    }

    public function updateEnquiry(int $id, array $data)
    {
        $enquiry = $this->findEnquiryById($id);
        if ($enquiry) {
            $enquiry->update($data);
            return $enquiry;
        }
        return null;
    }

    public function deleteEnquiry(int $id)
    {
        $enquiry = $this->findEnquiryById($id);
        if ($enquiry) {
            return $enquiry->delete();
        }
        return false;
    }
}
