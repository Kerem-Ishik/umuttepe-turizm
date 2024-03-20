<?php

namespace App\Controllers;

use App\Models\BiletModel;
use App\Models\SeferModel;
use App\Models\UcretModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use ReflectionException;

class OdemeController extends BaseController
{
    public function index(): string
    {
        return view('odeme');
    }

    public function odemeAl(): RedirectResponse
    {
        $gidis = $this->request->getPost('gidis');
        $donus = $this->request->getPost('donus');

        $gidisSecimler = json_decode($gidis);
        $donusSecimler = isset($donus) ? json_decode($donus) : null;

        session()->set('secimler', [$gidisSecimler, $donusSecimler]);

        $ucretModel = new UcretModel();
        $seferModel = new SeferModel();

        $gidisSefer = $seferModel->where('id', session()->get('gidisId'))->first();

        $gidisData = [
            'kalkis' => $gidisSefer['kalkis'],
            'varis' => $gidisSefer['varis'],
            'tarih' => $gidisSefer['tarih'],
        ];

        $gidisUcreti = $ucretModel
            ->where('nereden', $gidisData['kalkis'])
            ->where('nereye', $gidisData['varis'])
            ->first()['tutar'];

        session()->set('gidisUcreti', $gidisUcreti);
        session()->set('gidisData', $gidisData);

        if ($donusSecimler) {
            $donusSefer = $seferModel->where('id', session()->get('donusId'))->first();

            $donusData = [
                'kalkis' => $donusSefer['kalkis'],
                'varis' => $donusSefer['varis'],
                'tarih' => $donusSefer['tarih'],
            ];

            $donusUcreti = $ucretModel->where('nereden', $donusData['kalkis'])->where('nereye', $donusData['varis'])->first()['tutar'];
            session()->set('donusUcreti', $donusUcreti);
            session()->set('donusData', $donusData);
        }

        return redirect()->to(base_url('odeme'));
    }

    /**
     * @throws ReflectionException
     */
    public function odemeYap(): ResponseInterface
    {
        $biletModel = new BiletModel();
        $biletModel->insert([
            'userId' => session()->get('userInfo')['id'],
            'seferId' => $this->request->getPost('seferId'),
            'koltuk_no' => $this->request->getPost('koltukNo'),
            'ad' => $this->request->getPost('ad'),
            'soyadi' => $this->request->getPost('soyadi'),
            'cinsiyet' => $this->request->getPost('cinsiyet') == 'Erkek' ? 'E' : 'K',
        ]);

        return $this->response->setJSON(['message' => 'OK']);
    }

    public function onay(): string
    {
        return view('onay');
    }
}