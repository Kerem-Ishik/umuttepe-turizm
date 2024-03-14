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

        $sql = 'SELECT * FROM sefer WHERE kalkis = ? AND varis = ?';

        $db = db_connect();

        $query = $db->query($sql, [$values['kalkis'], $values['varis']]);

        $seferler = $query->getResultArray();

        // Filter the results based on the departure date
        // Check if the sefer's date starts with the departure date
        $seferler = array_filter($seferler, function ($sefer) use ($values) {
            return str_starts_with($sefer['tarih'], $values['gidis_tarihi']);
        });

        if ($seferler === []) {
            $SQL = 'INSERT INTO sefer (kalkis, varis, tarih) VALUES (?, ?, ?)';

            $sefer_values = [
                ['İstanbul', 'Ankara'],
                ['Ankara', 'İstanbul'],
                ['İstanbul', 'İzmir'],
                ['İzmir', 'İstanbul'],
                ['İstanbul', 'Antalya'],
                ['Antalya', 'İstanbul'],
                ['Ankara', 'İzmir'],
                ['İzmir', 'Ankara'],
                ['Ankara', 'Antalya'],
                ['Antalya', 'Ankara'],
                ['İzmir', 'Antalya'],
                ['Antalya', 'İzmir']
            ];

            $sefer_hours = [
                '00:00', '08:00', '16:00'
            ];

            foreach ($sefer_values as $sefer) {
                foreach ($sefer_hours as $hour) {
                    $db->query($SQL, [$sefer[0], $sefer[1], $values['gidis_tarihi'] . ' ' . $hour]);
                }
            }

            $query = $db->query($sql, [$values['kalkis'], $values['varis']]);

            $seferler = $query->getResultArray();

            $seferler = array_filter($seferler, function ($sefer) use ($values) {
                return str_starts_with($sefer['tarih'], $values['gidis_tarihi']);
            });
        }

        foreach ($seferler as $key => $sefer) {
            if (($sefer['kalkis'] == 'İstanbul' && $sefer['varis'] == 'Ankara') || ($sefer['kalkis'] == 'Ankara' && $sefer['varis'] == 'İstanbul')) {
                $seferler[$key]['sure'] = 5;
            }
            else if (($sefer['kalkis'] == 'İstanbul' && $sefer['varis'] == 'İzmir') || ($sefer['kalkis'] == 'İzmir' && $sefer['varis'] == 'İstanbul')) {
                $seferler[$key]['sure'] = 7;
            }
            else if (($sefer['kalkis'] == 'İstanbul' && $sefer['varis'] == 'Antalya') || ($sefer['kalkis'] == 'Antalya' && $sefer['varis'] == 'İstanbul')) {
                $seferler[$key]['sure'] = 6;
            }
            else if (($sefer['kalkis'] == 'Ankara' && $sefer['varis'] == 'İzmir') || ($sefer['kalkis'] == 'İzmir' && $sefer['varis'] == 'Ankara')) {
                $seferler[$key]['sure'] = 6;
            }
            else if (($sefer['kalkis'] == 'Ankara' && $sefer['varis'] == 'Antalya') || ($sefer['kalkis'] == 'Antalya' && $sefer['varis'] == 'Ankara')) {
                $seferler[$key]['sure'] = 4;
            }
            else if (($sefer['kalkis'] == 'İzmir' && $sefer['varis'] == 'Antalya') || ($sefer['kalkis'] == 'Antalya' && $sefer['varis'] == 'İzmir')) {
                $seferler[$key]['sure'] = 5;
            }
        }

        session()->set('data', $seferler);

        $db->close();

        return redirect()->to(base_url('seferler'));
    }

    public function seferler(): string
    {
        return view('seferler');
    }
}
