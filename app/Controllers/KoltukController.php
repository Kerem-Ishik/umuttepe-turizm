<?php

namespace App\Controllers;

use App\Models\BiletModel;
use CodeIgniter\HTTP\RedirectResponse;

class KoltukController extends BaseController
{
    public function index(): string
    {
        return view('koltukSecimi');
    }

    public function koltukSecimi(): RedirectResponse
    {
        $gidisId = $this->request->getPost('gidis_seferi');
        $donusId = $this->request->getPost('donus_seferi');

        $biletModel = new BiletModel();

        $gidisKoltuklar = array_column($biletModel->where('seferId', $gidisId)->findAll(), 'koltuk_no');

        session()->set('gidisKoltuklar', $gidisKoltuklar);
        session()->set('gidisId', $gidisId);

        if ($donusId) {
            $donusKoltuklar = array_column($biletModel->where('seferId', $donusId)->findAll(), 'koltuk_no');
            session()->set('donusKoltuklar', $donusKoltuklar);
            session()->set('donusId', $donusId);
        }

        return redirect()->to(base_url('koltuk-secimi'));
    }
}