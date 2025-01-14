<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Data; 
use App\Contracts\Repositories\DataRepositoryInterface; 
use Illuminate\Http\Request;
use Illuminate\View\View;

class InnovationEnquiryController extends Controller
{
    private DataRepositoryInterface $repository; 

    public function __construct(DataRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function list(): View
    {
        $data = $this->repository->getAllEnquiries(); 

        return view(
            'admin-views.innovationenquiry.list',  
            [
                'data' => $data,  
                'totalData' => $data->count(), 
            ]
        );
    }

    public function delete($id)
    {
        $this->repository->deleteEnquiry($id);  

        return redirect()->route('admin.innovationenquiry.list')  
            ->with('success', 'Data deleted successfully!');  
    }
}
