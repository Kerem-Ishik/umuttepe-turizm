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

        session()->set('gidisBiletler', $biletModel->where('seferId', $gidisId)->findAll());
        session()->set('gidisId', $gidisId);

        if ($donusId) {
            session()->set('donusBiletler', $biletModel->where('seferId', $donusId)->findAll());
            session()->set('donusId', $donusId);
        }

        return redirect()->to(base_url('koltuk-secimi'));
    }
}