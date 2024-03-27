<?php

namespace App\Controllers;

use App\Models\BiletModel;
use App\Models\SeferModel;
use CodeIgniter\HTTP\RedirectResponse;

class AdminController extends BaseController
{
    public function adminPanel(): string
    {
        $biletModel = new BiletModel();
        $seferModel = new SeferModel();
        $data['biletler'] = $biletModel->findAll();
        $data['seferler'] = $seferModel->findAll();
        return view('adminPanel', $data);
    }
    protected $helpers = ['form'];

    public function biletEdit(int $id): RedirectResponse
    {
        $biletModel = new BiletModel();
        $ad = $this->request->getPost('ad');
        $soyad = $this->request->getPost('soyad');
        $koltuk_no = $this->request->getPost('koltuk');
        $biletModel->update($id, [
            'ad' => $ad,
            'soyadi' => $soyad,
            'koltuk_no' => $koltuk_no,
        ]);
        return redirect()->to('/admin-panel');
    }
}
// this is controller for admin panel so we need to show database data to admin



