<?php

namespace App\Controllers;

use App\Libraries\Hash;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use ReflectionException;

class AuthController extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
    }

    public function login(): string
    {
        return view('login');
    }

    public function register(): string
    {
        return view('register');
    }

    /**
     * @throws ReflectionException
     */
    public function save(): RedirectResponse|string
    {
        $validation = $this->validate([
            'kimlik_no' => [
                'rules' => 'required|min_length[11]|max_length[11]|is_unique[users.kimlik_no]|regex_match[/^[0-9]*$/]',
                'errors' => [
                    'required' => 'Kimlik numarası gereklidir',
                    'min_length' => 'Kimlik numarası 11 rakamlıdır',
                    'max_length' => 'Kimlik numarası 11 rakamlıdır',
                    'is_unique' => 'Bu kimlik numarası daha önce kaydedilmiş',
                    'regex_match' => 'Kimlik numarası sadece rakamlardan oluşur'
                ],
            ],
            'ad' => [
                'rules' => 'required|max_length[50]|regex_match[/^[a-zA-Z]*$/]',
                'errors' => [
                    'required' => 'Ad gereklidir',
                    'max_length' => 'Maksimum 50 karakter',
                    'regex_match' => 'Ad sadece harflerden oluşur'
                ],
            ],
            'soyadi' => [
                'rules' => 'required|max_length[50]|regex_match[/^[a-zA-Z]*$/]',
                'errors' => [
                    'required' => 'Soyadı gereklidir',
                    'max_length' => 'Maksimum 50 karakter',
                    'regex_match' => 'Ad sadece harflerden oluşur'
                ],
            ],
            'telefon_no' => [
                'rules' => 'required|min_length[10]|max_length[10]|is_unique[users.telefon_no]|regex_match[/^[0-9]*$/]',
                'errors' => [
                    'required' => 'Telefon numarası gereklidir',
                    'min_length' => 'Telefon numarası 10 rakamlıdır',
                    'max_length' => 'Telefon numarası 10 rakamlıdır',
                    'is_unique' => 'Bu telefon numarası daha önce kaydedilmiş',
                    'regex_match' => 'Telefon numarası sadece rakamlardan oluşur'
                ],
            ],
            'e_posta' => [
                'rules' => 'required|valid_email|is_unique[users.e_posta]',
                'errors' => [
                    'required' => 'E-posta gereklidir',
                    'valid_email' => 'Yanlış e-posta formatı',
                    'is_unique' => 'Bu e-posta daha önce kaydedilmiş'
                ],
            ],
            'sifre' => [
                'rules' => 'required|min_length[8]|max_length[50]',
                'errors' => [
                    'required' => 'Şifre gereklidir',
                    'min_length' => 'Minimum 8 karakter',
                    'max_length' => 'Maksimum 50 karakter'
                ],
            ],
            'sifre_onayi' => [
                'rules' => 'required|min_length[8]|max_length[50]|matches[sifre]',
                'errors' => [
                    'required' => 'Şifre onayı gereklidir',
                    'min_length' => 'Minimum 8 karakter',
                    'max_length' => 'Maksimum 50 karakter',
                    'matches' => 'Şifre onayı şifrenizle uyuşmuyor'
                ],
            ]
        ]);

        if (! $validation) {
            return view('register', ['validation' => $this->validator]);
        }
        else {
            $values = [
                'ad' => $this->request->getPost('ad'),
                'soyadi' => $this->request->getPost('soyadi'),
                'kimlik_no' => $this->request->getPost('kimlik_no'),
                'telefon_no' => $this->request->getPost('telefon_no'),
                'e_posta' => $this->request->getPost('e_posta'),
                'sifre' => Hash::make($this->request->getPost('sifre')),
            ];

            $userModel = new UserModel();
            $query = $userModel->insert($values);

            if (! $query) {
                return redirect()->back()->with('fail', 'Bir sorun var');
            }
            else {
                return redirect()->to(base_url('register'))->with('success', 'Başarıyla kaydedildi');
            }
        }
    }

    public function check()
    {
        $validation = $this->validate([
            'e_posta' => [
                'rules' => 'required|valid_email|is_not_unique[users.e_posta]',
                'errors' => [
                    'required' => 'E-posta gereklidir',
                    'valid_email' => 'Yanlış e-posta formatı',
                    'is_not_unique' => 'Böyle bir e-posta kaydedilmemiş',
                ],
            ],
            'sifre' => [
                'rules' => 'required|min_length[8]|max_length[50]',
                'errors' => [
                    'required' => 'Şifre gereklidir',
                    'min_length' => 'Minimum 8 karakter',
                    'max_length' => 'Maksimum 50 karakter',
                ],
            ],
        ]);

        if (! $validation) {
            return view('login', ['validation' => $this->validator]);
        }
        else {
            $e_posta = $this->request->getPost('e_posta');
            $sifre = $this->request->getPost('sifre');

            $userModel = new UserModel();

            $user_info = $userModel->where('e_posta', $e_posta)->first();

            if (! Hash::check($sifre, $user_info['sifre'])) {
                session()->setFlashdata('fail', 'Yanlış şifre');
                return redirect()->to(base_url('login'))->withInput();
            }
            else {
                $user_id = $user_info['id'];
                session()->set('loggedUser', $user_id);
                return redirect()->to(base_url('/'));
            }
        }
    }
}