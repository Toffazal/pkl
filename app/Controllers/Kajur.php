<?php

namespace App\Controllers;
use \App\Models\User;
use \App\Models\Permohonan;
use \App\Models\Jurusann;
use \App\Models\Kelompok;


class Kajur extends BaseController
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



    protected function nomor($currentPage, $perPage)
    {
        if (is_null($currentPage)) {
            $nomor = 1;
        } else {
            $nomor = 1 + ($perPage * ($currentPage - 1));
        }
        return $nomor;
    }



    public function index()
    {
        if(session()->get('role') != 'kajur')
        {
            return redirect()->to(base_url());
        }

        $user = $this->User->where('username', session()->get('username'))->first();
        $data = [
            'title' => 'Dashboard Kajur',
            'user' => $user,
            'validation' => \Config\Services::validation(),
            'permohonan' => $this->Permohonan->where('status', 0)->orderBy('id', 'desc')->find()
        ];

        return view('kajur/dashboard', $data);
    }




    public function setuju($id = false)
    {
        if(session()->get('role') != 'kajur')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        if(!$id)
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('kajur'));
        }

        $data = $this->Permohonan->where('id', $id)->first();
        if(!$data)
        {
            session()->setFlashdata('danied', 'Data tidak ditemukan.');
            return redirect()->to(base_url('kajur'));
        }

        $user = $this->User->where('username', session()->get('username'))->first();
        $siswa = $this->User->where('id', $data->uid)->first();

        if($user->jurusan != $siswa->jurusan)
        {
            session()->setFlashdata('danied', 'GAUSAH SOK ASIK!');
            return redirect()->to(base_url('kajur'));
        }

        $timezone = time() + (60 * 60 * 7);
        $tanggal = gmdate('d-m-Y', $timezone);

        $this->Permohonan->save([
            'id' => $id,
            'status' => 2,
            'tanggal_konfirmasi' => $tanggal
        ]);

        session()->setFlashdata('pesan', 'Permintaan telah disetujui.');
        return redirect()->to(base_url('kajur'));
    }




    public function tolak($id = false)
    {
        if(session()->get('role') != 'kajur')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        if(!$id)
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('kajur'));
        }

        $data = $this->Permohonan->where('id', $id)->first();
        if(!$data)
        {
            session()->setFlashdata('danied', 'Data tidak ditemukan.');
            return redirect()->to(base_url('kajur'));
        }

        $user = $this->User->where('username', session()->get('username'))->first();
        $siswa = $this->User->where('id', $data->uid)->first();

        if($user->jurusan != $siswa->jurusan)
        {
            session()->setFlashdata('danied', 'GAUSAH SOK ASIK!');
            return redirect()->to(base_url('kajur'));
        }

        $timezone = time() + (60 * 60 * 7);
        $tanggal = gmdate('d-m-Y', $timezone);

        $this->Permohonan->save([
            'id' => $id,
            'status' => 1,
            'alasan' => htmlspecialchars($this->request->getVar('alasan')),
            'tanggal_konfirmasi' => $tanggal
        ]);

        session()->setFlashdata('pesan', 'Permintaan telah ditolak.');
        return redirect()->to(base_url('kajur'));
    }




    public function riwayat()
    {
        if(session()->get('role') != 'kajur')
        {
            return redirect()->to(base_url());
        }

        $user = $this->User->where('username', session()->get('username'))->first();
        $data = [
            'title' => 'Riwayat Permohonan',
            'user' => $user,
            'ditolak' => $this->Permohonan->where('status', 1)->orderBy('id', 'desc')->find(),
            'setuju' => $this->Permohonan->where('status', 2)->orderBy('id', 'desc')->find(),
            'disetujui' => $this->Permohonan->where('status', 2)->orderBy('id', 'desc')->paginate(20),
            'pager' => $this->Permohonan->pager,
            'nomor' => $this->nomor($this->request->getVar('page'), 20)
        ];

        return view('kajur/riwayat', $data);
    }




    public function pembimbing()
    {
        if(session()->get('role') != 'kajur')
        {
            return redirect()->to(base_url());
        }

        $user = $this->User->where('username', session()->get('username'))->first();
        $pembimbing = $this->User->where('role', 'pembimbing')->find();
        $siswa = $this->User->where('role', 'siswa')->find();
        $data = [
            'title' => 'Pembimbing',
            'user' => $user,
            'pembimbing' => $pembimbing,
            'siswa' => $siswa,
            'validation' => \Config\Services::validation()
        ];

        return view('kajur/pembimbing', $data);
    }




    public function tambahKelompok($id = false)
    {
        if(session()->get('role') != 'kajur')
        {
            return redirect()->to(base_url());
        }

        $user = $this->User->where('username', session()->get('username'))->first();
        $pembimbing = $this->User->where('id', $id)->first();
        $permohonan = $this->Permohonan->where('status', 2)->find();
        $aktif = $this->Permohonan->where('status', 3)->find();
        $kelompok = $this->Kelompok->where(['pid' => $id, 'status' => 0])->find();

        if($kelompok)
        {
            $kel = $kelompok;
            $tempatPKL = $this->Kelompok->where('pid', $id)->orderBy('id', 'desc')->first();
        }else{
            $kel = '';
            $tempatPKL = '';
        }

        $data = [
            'title' => 'Buat Kelompok',
            'user' => $user,
            'pembimbing' => $pembimbing,
            'permohonan' => $permohonan,
            'aktif' => $aktif,
            'kel' => $kel,
            'tempatPKL' => $tempatPKL,
            'validation' => \Config\Services::validation()
        ];

        return view('kajur/tambahKelompok', $data);
    }




    public function simpanKelompok()
    {
        if(session()->get('role') != 'kajur')
        {
            return redirect()->to(base_url());
        }

        $nama = $this->request->getVar('nama');
        $pkl = $this->request->getVar('tempat_pkl');
        $pid = $this->request->getVar('pid');
        $total = count($nama);

        for($i=0; $i<$total; $i++){

            $uid = $nama[$i];
            $u = $this->Permohonan->where(['uid' => $uid, 'status' => 2])->first();

            $this->Kelompok->save([
            'pid' => $pid,
            'uid' => $uid,
            'tempat_pkl' => $pkl,
            'status' => 0
            ]);

            $data['status'] = 3;
            $this->Permohonan->update($u->id, $data);
        }

        session()->setFlashdata('pesan', 'Kelompok telah dibuat.');
        return redirect()->to(base_url('kajur/pembimbing'));

    }




    public function hapusKelompok()
    {
        if(session()->get('role') != 'kajur')
        {
            return redirect()->to(base_url());
        }

        $id = $_POST['id'];
        $kelompok = $this->Kelompok->where('uid', $id)->first();
        $permohonan = $this->Permohonan->where(['uid' => $id, 'status' => 3])->first();

        $this->Permohonan->save([
            'id' => $permohonan->id,
            'status' => 2,
        ]);

        $this->Kelompok->delete($kelompok->id);
    }





    public function akun()
    {
        if(session()->get('role') != 'kajur')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        $data = [
            'title' => 'Edit Akun',
            'user' => $this->User->where('username', session()->get('username'))->first(),
            'validation' => \Config\Services::validation()
        ];

        return view('kajur/akun', $data);
    }




    public function updateAkun()
    {
        if(session()->get('role') != 'kajur')
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
            'required' => 'Alamat tidak boleh kosong.'            
            ]
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
            return redirect()->to(base_url('kajur/akun/'))->withInput();
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
        return redirect()->to(base_url('kajur/akun'));    

    }



    
}
