<?php

namespace App\Controllers;
use \App\Models\User;
use \App\Models\Permohonan;
use \App\Models\Jurusann;
use \App\Models\Kelompok;


class Siswa extends BaseController
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
        if(session()->get('role') != 'siswa')
        {
            return redirect()->to(base_url());
        }

        $user = $this->User->where('username', session()->get('username'))->first();
        $data = [
            'title' => 'Dashboard Siswa',
            'user' => $user,
            'validation' => \Config\Services::validation(),
            'permohonan' => $this->Permohonan->where('uid', $user->id)->orderBy('id', 'desc')->first()
        ];

        return view('siswa/dashboard', $data);
    }




    public function uploadBerkas()
    {

        if(session()->get('role') != 'siswa')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }


        //Validasi input
        if(!$this->validate([
            
            'tempat_pkl' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Tempat PKL tidak boleh kosong.'
            ]
        ],

        'berkas' => [
            'rules' => 'uploaded[berkas]|max_size[berkas,2408]|mime_in[berkas,application/pdf]',
            'errors' => [
            'uploaded' => 'Bukti harus diupload',
            'max_size' => 'Ukuran file terlalu besar',
            'mime_in' => 'File harus berupa PDF'
            ]
        ]

        ])) {
            return redirect()->to(base_url('dashboard/'))->withInput();
        }

        $berkas = $this->request->getFile('berkas');
        $pkl = htmlspecialchars($this->request->getVar('tempat_pkl'));

        if($berkas->getError() ==  4){
            session()->setFlashdata('danied', 'File tidak dapat diupload.');
            return redirect()->to(base_url('dashboard'));
        }else{
            $namaBerkas = $berkas->getRandomName();
            $berkas->move('public/berkas/', $namaBerkas);
        }

        $data = $this->User->where('username', session()->get('username'))->first();
        $timezone = time() + (60 * 60 * 7);
        $tanggal = gmdate('d-m-Y', $timezone);

        $this->Permohonan->save([
            'uid' => $data->id,
            'tempat_pkl' => $pkl,
            'berkas' => $namaBerkas,
            'tanggal_pengajuan' => $tanggal,
            'status' => 0
        ]);

        session()->setFlashdata('pesan', 'Dokumen permohonan telah diupload.');
        return redirect()->to(base_url('dashboard'));
    }




    public function akun()
    {
        if(session()->get('role') != 'siswa')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        $data = [
            'title' => 'Edit Akun',
            'user' => $this->User->where('username', session()->get('username'))->first(),
            'validation' => \Config\Services::validation()
        ];

        return view('siswa/akun', $data);
    }




    public function updateAkun()
    {
        if(session()->get('role') != 'siswa')
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

        'foto' => [
            'rules' => 'max_size[foto,1204]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
            'errors' => [
            'max_size' => 'Ukuran file terlalu besar',
            'is_image' => 'File harus berupa gambar',
            'mime_in' => 'File harus berupa gambar'
            ]
        ]

        ])) {
            return redirect()->to(base_url('siswa/akun/'))->withInput();
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
           
        session()->setFlashdata('pesan', 'Akun telah diperbarui.');
        return redirect()->to(base_url('siswa/akun'));    

    }



    
}
