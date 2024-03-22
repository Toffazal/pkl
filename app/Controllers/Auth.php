<?php

namespace App\Controllers;
use \App\Models\User;


class Auth extends BaseController
{
    protected $User;


    public function __construct()
    {
        $this->User = new User;
    }

    public function index()
    {
        if(session()->has('username'))
        {
            return redirect()->to(base_url(session()->get('role')));
        }

        $data = [
            'title' => 'Halaman Login',
            'validation' => \Config\Services::validation()
        ];

        return view('login', $data);
    }



    public function prosesLogin()
    {
        if(session()->has('username'))
        {
            return redirect()->to(base_url(session()->get('role')));
        }

        //Validasi input
        if(!$this->validate([

        'username' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Username tidak boleh kosong.'
            ]
        ],

        'password' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Password tidak boleh kosong.'
            ]
        ]

        ])) {
            return redirect()->to(base_url())->withInput();
        }

    $username = $this->request->getVar('username');
    $password = $this->request->getVar('password');

    $user = $this->User->where(['username' => $username])->first();

    if(session()->get('gagal') >= 5)
    {
        session()->setFlashdata('danied', 'ACCESS DANIED!');
        return redirect()->to(base_url());
    }

    //jika user ada
    if($user)
    {
        //cek password
        if(password_verify($password, $user->password))
        {
          session()->set('username', $user->username);
          session()->set('role', $user->role);

          if($user->role == 'siswa')
          {
            session()->setFlashdata('pesan', 'Berhasil login.');
            return redirect()->to(base_url('dashboard'));
          }else{
            session()->setFlashdata('pesan', 'Berhasil login.');
            return redirect()->to(base_url($user->role));
          }   
        }else{
            $gagal = session()->get('gagal');
            if($gagal)
            {
                $baru = session()->get('gagal') + 1;
                session()->remove('gagal');
                session()->set('gagal', $baru);
            }else{
                session()->set('gagal', 1);
            }

            session()->setFlashdata('danied', 'Akun/password salah.');
            return redirect()->to(base_url());
        }
      }else{
            $gagal = session()->get('gagal');
            if($gagal)
            {
                $baru = session()->get('gagal') + 1;
                session()->remove('gagal');
                session()->set('gagal', $baru);
            }else{
                session()->set('gagal', 1);
            }

          session()->setFlashdata('danied', 'Akun/password salah.');
          return redirect()->to(base_url());
        }
    }




    public function logout()
    {
        if(!session()->has('username'))
        {
            session()->setFlashdata('danied', 'Anda belum Login.');
            return redirect()->to(base_url());
        }

        session()->remove('username');
        session()->remove('role');

        session()->setFlashdata('pesan', 'Anda telah logout.');
        return redirect()->to(base_url());
  }



}
