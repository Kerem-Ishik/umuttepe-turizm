<?php

namespace App\Controllers;

use App\Models\BiletModel;
use App\Models\SeferModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use ReflectionException;

class AdminController extends BaseController
{
    protected $helpers = ['form'];

    public function index(): string
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();
        return view('admin/index', $data);
    }

    public function biletler(): string
    {
        $biletModel = new BiletModel();
        $seferModel = new SeferModel();
        $data['biletler'] = $biletModel->findAll();
        $data['seferler'] = $seferModel->findAll();
        return view('admin/biletler', $data);
    }

    /**
     * @throws ReflectionException
     */
    public function biletEdit(int $id): RedirectResponse
    {
        $biletModel = new BiletModel();
        $ad = $this->request->getPost('ad');
        $soyad = $this->request->getPost('soyad');
        $koltuk_no = $this->request->getPost('koltuk');
        $seferId = $this->request->getPost('sefer');
        $biletModel->update($id, [
            'ad' => $ad,
            'soyadi' => $soyad,
            'koltuk_no' => $koltuk_no,
            'seferId' => $seferId
        ]);
        return redirect()->to(base_url('admin/biletler'));
    }

    /**
     * @throws ReflectionException
     */
    public function userEdit(int $id): RedirectResponse
    {
        $userModel = new UserModel();
        $ad = $this->request->getPost('ad');
        $soyad = $this->request->getPost('soyadi');
        $kimlik_no = $this->request->getPost('kimlik');
        $telefon_no = $this->request->getPost('telefon');
        $e_posta = $this->request->getPost('email');
        $userModel->update($id, [
            'ad' => $ad,
            'soyadi' => $soyad,
            'kimlik_no' => $kimlik_no,
            'telefon_no' => $telefon_no,
            'e_posta' => $e_posta
        ]);
        return redirect()->to(base_url('admin'));
    }

    /**
     * @throws ReflectionException
     */
    public function userDelete(int $id): RedirectResponse
    {
        $userModel = new UserModel();
        $userModel->delete($id);
        return redirect()->to(base_url('admin'));
    }
}



