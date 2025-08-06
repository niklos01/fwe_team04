<?php

namespace App\Controllers;

use App\Models\UmsatzModel;
use CodeIgniter\RESTful\ResourceController;

class Umsatz extends BaseController
{
    protected $umsatzModel;

    public function __construct()
    {
        $this->umsatzModel = new UmsatzModel();
    }

    public function last12Months()
    {
        $data = $this->umsatzModel->getLast12Months();
        return $this->response->setJSON($data);
    }

    public function currentMonthComparison()
    {
        $data = $this->umsatzModel->getCurrentMonthComparison();
        return $this->response->setJSON($data);
    }


}
