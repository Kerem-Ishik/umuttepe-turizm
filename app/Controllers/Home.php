<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Home extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
    }

    public function index(): string
    {
        $userModel = new UserModel();
        $loggedUserID = session()->get('loggedUser');
        session()->set('userInfo', $userModel->find($loggedUserID));

        return view('home');
    }

    public function seferAra(): RedirectResponse
    {
        $validation = $this->validate([
            'kalkis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kalkış yeri gereklidir'
                ]
            ],
            'varis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Varış yeri gereklidir'
                ]
            ],
            'gidis_tarihi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Gidiş tarihi gereklidir'
                ]
            ]
        ]);

        if (! $validation) {
            session()->setFlashdata('validation', $this->validator);

            return redirect()->to(base_url('/'))->withInput();
        }

        // Check if the return date is before the departure date
        if ($this->request->getPost('gidis_tipi') === 'gidis_donus') {
            if ($this->request->getPost('gidis_tarihi') > $this->request->getPost('donus_tarihi')) {
                session()->setFlashdata('validation', ['donus_tarihi' => 'Dönüş tarihi, gidiş tarihinden önce olamaz']);

                return redirect()->to(base_url('/'))->withInput();
            }
        }

        $values = [
            'kalkis' => $this->request->getPost('kalkis'),
            'varis' => $this->request->getPost('varis'),
            'gidis_tipi' => $this->request->getPost('gidis_tipi'),
            'gidis_tarihi' => $this->request->getPost('gidis_tarihi')
        ];

        if ($values['gidis_tipi'] === 'gidis_donus') {
            $values['donus_tarihi'] = $this->request->getPost('donus_tarihi');
        }

        session()->set('data', $values);

        return redirect()->to(base_url('seferler'));
    }

    public function seferler(): string
    {
        return view('seferler');
    }
}
