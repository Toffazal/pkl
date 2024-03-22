<?php

namespace App\Controllers;
use \App\Models\User;
use \App\Models\Permohonan;
use \App\Models\Jurusann;
use \App\Models\Kelompok;


class Pembimbing extends BaseController
{
    protected $User;
    protected $Permohonan;
    protected $Jurusan;
    protected $Kelompok;


    public function __construct()
    {
        $this->User = new User;
        $this->Jurusan = new Jurusann;
        $this->Permohonan = new Permohonan;
        $this->Kelompok = new Kelompok;
    }


    public function index()
    {
        if(session()->get('role') != 'pembimbing')
        {
            return redirect()->to(base_url());
        }

        $user = $this->User->where('username', session()->get('username'))->first();
        $data = [
            'title' => 'Dashboard Pembimbing',
            'user' => $user,
            'validation' => \Config\Services::validation(),
            'permohonan' => $this->Permohonan->where('uid', $user->id)->orderBy('id', 'desc')->first()
        ];

        return view('pembimbing/dashboard', $data);
    }




    public function selesai($id = false)
    {
        if(session()->get('role') != 'pembimbing')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        if(!$id)
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('pembimbing'));
        }

        $user = $this->User->where('id', $id)->first();
        if($user->username != session()->get('username'))
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('pembimbing'));
        }

        $kelompok = $this->Kelompok->where(['pid' => $user->id, 'status' => 0])->find();
        if(!$kelompok)
        {
            return redirect()->to(base_url('pembimbing'));
        }

        $jumlahKelompok = count($kelompok);
        if($jumlahKelompok == 1)
        {
            $kel = $this->Kelompok->where(['pid' => $user->id, 'status' => 0])->first();
            $permohonan = $this->Permohonan->where(['uid' => $kel->uid, 'status' => 3])->first();
            $this->Permohonan->save([
                'id' => $permohonan->id,
                'status' => 4
            ]);

            $this->Kelompok->save([
                'id' => $kel->id,
                'status' => 1
            ]);
        }else{
            foreach($kelompok as $k)
            {
                $permohonan = $this->Permohonan->where(['uid' => $k->uid, 'status' => 3])->first();
                $this->Permohonan->save([
                    'id' => $permohonan->id,
                    'status' => 4
                ]);

                $this->Kelompok->save([
                    'id' => $k->id,
                    'status' => 1
                ]);
            }
        }
        
        session()->setFlashdata('pesan', 'Kegiatan PKL telah diselesaikan.');
        return redirect()->to(base_url('pembimbing'));
    }




    public function akun()
    {
        if(session()->get('role') != 'pembimbing')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        $data = [
            'title' => 'Edit Akun',
            'user' => $this->User->where('username', session()->get('username'))->first(),
            'validation' => \Config\Services::validation()
        ];

        return view('pembimbing/akun', $data);
    }




    public function updateAkun()
    {
        if(session()->get('role') != 'pembimbing')
        {
            return redirect()->to(base_url());
        }

        $data = $this->User->where('username', session()->get('username'))->first();

        //Validasi input
        if(!$this->validate([

        'nama' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Nama tidak boleh kosong.'
            ]
        ],

        'telepon' => [
            'rules' => 'required|numeric',
            'errors' => [
            'required' => 'Telepon tidak boleh kosong.',
            'numeric' => 'Harus angka'
            ]
        ],

        'alamat' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Alamat tidak boleh kosong.'            ]
        ],

        'username' => [
            'rules' => 'required|is_unique[user.username,id,'.$data->id.']',
            'errors' => [
            'required' => 'Username tidak boleh kosong.',
            'is_unique' => 'Username telah terdaftar'
            ]
        ],

        'foto' => [
            'rules' => 'max_size[foto,1204]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
            'errors' => [
            'max_size' => 'Ukuran file terlalu besar',
            'is_image' => 'File harus berupa gambar',
            'mime_in' => 'File harus berupa gambar'
            ]
        ]

        ])) {
            return redirect()->to(base_url('pembimbing/akun/'))->withInput();
        }


        $foto = $this->request->getFile('foto');

        if($foto->getError() ==  4){
            $namaFoto = $data->foto;
        }else{
            $namaFoto = $foto->getRandomName();
            $foto->move('public/img/', $namaFoto);

            if($data->foto != 'default.png')
            {
                unlink('public/img/'.$data->foto);
            }
        }


        if($this->request->getVar('password'))
        {
            $pass = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
        }else{
            $pass = $data->password;
        }

        $this->User->save([
        'id' => $data->id,
        'nama' => htmlspecialchars($this->request->getVar('nama')),
        'telepon' => htmlspecialchars($this->request->getVar('telepon')),
        'alamat' => htmlspecialchars($this->request->getVar('alamat')),
        'username' => htmlspecialchars($this->request->getVar('username')),
        'password' => $pass,
        'foto' => $namaFoto
        ]);


        if($this->request->getVar('password'))
        {
            session()->remove('username');
            session()->remove('role');
            session()->setFlashdata('pesan', 'Akun telah diperbarui.');
            return redirect()->to(base_url());
        }
           
        if(session()->get('username') != $this->request->getVar('username'))
        {
            session()->remove('username');
            session()->remove('role');
            session()->setFlashdata('pesan', 'Akun telah diperbarui.');
            return redirect()->to(base_url());
        }

        session()->setFlashdata('pesan', 'Akun telah diperbarui.');
        return redirect()->to(base_url('pembimbing/akun'));    

    }



    
}
