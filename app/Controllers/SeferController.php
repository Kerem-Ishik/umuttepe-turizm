<?php

namespace App\Controllers;

use App\Models\BiletModel;
use App\Models\SeferModel;
use CodeIgniter\HTTP\RedirectResponse;
use ReflectionException;

class SeferController extends BaseController
{
    protected $helpers = ['Form', 'url'];

    public function index(): string
    {
        return view('seferler');
    }

    /**
     * @throws ReflectionException
     */
    public function seferAra(): string|RedirectResponse
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
            return view('home', [
                'validation' => $this->validator
            ]);
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

        $seferModel = new SeferModel();

        $gidis_seferleri = $seferModel->where('kalkis', $values['kalkis'])->where('varis', $values['varis'])->findAll();

        // Filter the results based on the departure date
        // Check if the sefer's date starts with the departure date
        $gidis_seferleri = array_filter($gidis_seferleri, function ($sefer) use ($values) {
            return str_starts_with($sefer['tarih'], $values['gidis_tarihi']);
        });

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

        // If there are no sefer values on the specified date, insert them
        if ($gidis_seferleri === []) {
            foreach ($sefer_values as $sefer) {
                foreach ($sefer_hours as $hour) {
                    $seferModel->insert([
                        'kalkis' => $sefer[0],
                        'varis' => $sefer[1],
                        'tarih' => $values['gidis_tarihi'] . ' ' . $hour
                    ]);
                }
            }

            $gidis_seferleri = $seferModel->where('kalkis', $values['kalkis'])->where('varis', $values['varis'])->findAll();

            // Filter the results based on the departure date
            $gidis_seferleri = array_filter($gidis_seferleri, function ($sefer) use ($values) {
                return str_starts_with($sefer['tarih'], $values['gidis_tarihi']);
            });
        }

        $biletModel = new BiletModel();

        // Get the number of tickets sold for each sefer
        foreach ($gidis_seferleri as $key => $sefer) {
            $biletler = $biletModel->where('seferId', $sefer['id'])->findAll();

            $gidis_seferleri[$key]['doluluk'] = count($biletler);
            $gidis_seferleri[$key]['biletler'] = $biletler;
        }

        $this->generateSeferDuration($gidis_seferleri);

        $donus_seferleri = [];

        if ($values['gidis_tipi'] === 'gidis_donus') {
            $donus_seferleri = $seferModel->where('kalkis', $values['varis'])->where('varis', $values['kalkis'])->findAll();

            // Filter the results based on the return date
            $donus_seferleri = array_filter($donus_seferleri, function ($sefer) use ($values) {
                return str_starts_with($sefer['tarih'], $values['donus_tarihi']);
            });

            // If there are no return sefer values on the specified date, insert them
            if ($donus_seferleri === []) {
                foreach ($sefer_values as $sefer) {
                    foreach ($sefer_hours as $hour) {
                        $seferModel->insert([
                            'kalkis' => $sefer[0],
                            'varis' => $sefer[1],
                            'tarih' => $values['donus_tarihi'] . ' ' . $hour
                        ]);
                    }
                }

                $donus_seferleri = $seferModel->where('kalkis', $values['varis'])->where('varis', $values['kalkis'])->findAll();

                $donus_seferleri = array_filter($donus_seferleri, function ($sefer) use ($values) {
                    return str_starts_with($sefer['tarih'], $values['donus_tarihi']);
                });
            }

            // Get the number of tickets sold for each sefer
            foreach ($donus_seferleri as $key => $sefer) {
                $biletler = $biletModel->where('seferId', $sefer['id'])->findAll();
                $donus_seferleri[$key]['doluluk'] = count($biletler);
                $donus_seferleri[$key]['biletler'] = $biletler;
            }

            $this->generateSeferDuration($donus_seferleri);
        }

        session()->set('gidis_donus_data', [
            'gidis' => $gidis_seferleri,
            'donus' => $donus_seferleri
        ]);

        session()->set('gidis_tipi', $values['gidis_tipi']);

        return redirect()->to(base_url('seferler'));
    }

    /**
     * Generate duration for each sefer based on the departure and arrival cities
     *
     * @param array $seferler The seferler array to be modified
     * @return void
     */
    private function generateSeferDuration(array &$seferler): void
    {
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
    }
}