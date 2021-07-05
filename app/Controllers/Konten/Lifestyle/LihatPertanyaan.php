<?php

namespace App\Controllers\Konten\Lifestyle;

use App\Controllers\BaseController;
use App\Models\Konten\Lifestyle\PertanyaanLifestyleModel;

class LihatPertanyaan extends BaseController
{
    protected $dataPertanyaanLifestyleModel;
    public function __construct()
    {
        $this->dataPertanyaanLifestyleModel = new PertanyaanLifestyleModel();
    }
    // public function index()
    // {
    //     $data = [
    //         'title' => 'Pertanyaan',
    //         'pertanyaanlifestyle' => $this->dataPertanyaanLifestyleModel->getDataPertanyaanLifestyle()
    //     ];
    //     return view('pages\konten\lifestyle\lihatpertanyaan', $data);
    // }
    public function detail($id)
    {
        $data = [
            'title' => 'Pertanyaan',
            'pertanyaanlifestyle' => $this->dataPertanyaanLifestyleModel->getDataPertanyaanLifestyle($id)
        ];
        return view('pages\konten\lifestyle\lihatpertanyaan', $data);
    }
    public function delete($id)
    {
        $this->dataPertanyaanLifestyleModel->delete($id);
        return redirect()->to('/konten/lifestyle/dashboard');
    }
}