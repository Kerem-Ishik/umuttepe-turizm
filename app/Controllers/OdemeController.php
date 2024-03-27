<?php

namespace App\Controllers;

use App\Models\BiletModel;
use App\Models\SeferModel;
use App\Models\UcretModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;
use DateTimeZone;
use Exception;
use ReflectionException;

class OdemeController extends BaseController
{
    protected $helpers = ['Form', 'form'];

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
    public function odemeKontrol(): RedirectResponse|ResponseInterface {
        $validation = $this->validate([
            'cardholder' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kart sahibi adı boş bırakılamaz.'
                ],
            ],
            'cardnumber' => [
                'rules' => 'required|exact_length[19]|regex_match[/^[0-9 ]+$/]',
                'errors' => [
                    'required' => 'Kart numarası boş bırakılamaz.',
                    'exact_length' => 'Kart numarası 16 haneli olmalıdır.',
                    'regex_match' => 'Kart numarası sadece rakamlardan oluşabilir.',
                ],
            ],
            'expirationdate' => [
                'rules' => 'required|regex_match[/^(0[1-9]|1[0-2])\/[0-9]{2}$/]',
                'errors' => [
                    'required' => 'Son kullanma tarihi boş bırakılamaz.',
                    'regex_match' => 'Geçersiz son kullanma tarihi formatı.'
                ],
            ],
            'securitycode' => [
                'rules' => 'required|numeric|exact_length[3]',
                'errors' => [
                    'required' => 'Güvenlik kodu boş bırakılamaz.',
                    'numeric' => 'Güvenlik kodu sadece rakamlardan oluşabilir.',
                    'exact_length' => 'Güvenlik kodu 3 haneli olmalıdır.'
                ],
            ],
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $biletler = json_decode($this->request->getPost('biletler'));

        foreach ($biletler as $bilet) {
            $this->odemeYap($bilet[4], $bilet[6], $bilet[1], $bilet[2], $bilet[7]);
        }

        return redirect()->to(base_url('onay'));
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function odemeYap(string $seferId, string $koltukNo, string $ad, string $soyadi, string $cinsiyet): void
    {
        $biletModel = new BiletModel();
        $seferModel = new SeferModel();

        $sefer = $seferModel->find($seferId);

        $il = '';

        switch ($sefer['kalkis']) {
            case 'İstanbul':
                $il = '34';
                break;
            case 'Ankara':
                $il = '06';
                break;
            case 'İzmir':
                $il = '35';
                break;
            case 'Antalya':
                $il= '07';
                break;
        }

        $gidisSaati = new DateTime($sefer['tarih']);

        $gidisSaati = $gidisSaati->format("H") < "12" ? "OO" : "OS";

        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('Europe/Istanbul'));
        $now = $now->format('YmdHis');

        $alfabe = range('A', 'Z');

        $peron = $alfabe[array_rand($alfabe)];

        $uc_harf = array_rand($alfabe, 3);
        $randNum = rand(1000, 9999);
        $ilk = $alfabe[$uc_harf[0]];
        $ikinci = $alfabe[$uc_harf[1]];
        $ucuncu = $alfabe[$uc_harf[2]];
        $plaka = "$il$ilk$ikinci$ucuncu$randNum";

        $biletModel->insert([
            'userId' => session()->get('userInfo')['id'],
            'seferId' => $seferId,
            'koltuk_no' => $koltukNo,
            'ad' => $ad,
            'soyadi' => $soyadi,
            'cinsiyet' => $cinsiyet == 'Erkek' ? 'E' : 'K',
            'pnr' => "$il$gidisSaati$now$peron$plaka"
        ]);
    }

    public function onay(): string
    {
        return view('onay');
    }
}