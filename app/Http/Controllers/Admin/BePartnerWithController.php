<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BePartnerWithUs; 
use App\Contracts\Repositories\BePartnerWithRepositoryInterface; 
use Illuminate\Http\Request;
use Illuminate\View\View;

class BePartnerWithController extends Controller
{
    private BePartnerWithRepositoryInterface $repository; 

    public function __construct(BePartnerWithRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function list(): View
    {
        $bepartnerwithus = $this->repository->getAllEnquiries()->paginate(10);

        return view(
            'admin-views.bepartnerwith.list',
            [
                'bepartnerwithus' => $bepartnerwithus,
                'totalbepartnerwithus' => $bepartnerwithus->count(),
            ]
        );
    }
    public function delete($id)
    {
        $this->repository->deleteEnquiry($id);  

        return redirect()->route('admin.bepartnerwith.list')  
            ->with('success', 'Data deleted successfully!');  
    }
}
