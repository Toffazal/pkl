<?php

namespace App\Controllers;
use \App\Models\User;
use \App\Models\Permohonan;
use \App\Models\Jurusann;
use \App\Models\Penilaian;
use \App\Models\Kelompok;
use \App\Models\Nilai;


class Admin extends BaseController
{
    protected $User;
    protected $Permohonan;
    protected $Jurusan;
    protected $Penilaian;
    protected $Kelompok;
    protected $Nilai;


    public function __construct()
    {
        $this->User = new User;
        $this->Jurusan = new Jurusann;
        $this->Permohonan = new Permohonan;
        $this->Penilaian = new Penilaian;
        $this->Kelompok = new Kelompok;
        $this->Nilai = new Nilai;
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



    public function dashboard()
    {
        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        $data = [
            'title' => 'Dashboard Admin',
            'user' => $this->User->where('username', session()->get('username'))->first(),
            'validation' => \Config\Services::validation(),
            'jurusan' => $this->Jurusan->findAll(),
            'siswa' => $this->User->where('role', 'siswa')->find()
        ];

        return view('admin/dashboard', $data);
    }




    public function uploadBerkas()
    {

        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }


        //Validasi input
        if(!$this->validate([
        'berkas' => [
            'rules' => 'uploaded[berkas]|max_size[berkas,2408]|mime_in[berkas,application/pdf]',
            'errors' => [
            'uploaded' => 'Bukti harus diupload',
            'max_size' => 'Ukuran file terlalu besar',
            'mime_in' => 'File harus berupa PDF'
            ]
        ]

        ])) {
            return redirect()->to(base_url('admin/'))->withInput();
        }

        $berkas = $this->request->getFile('berkas');

        if($berkas->getError() ==  4){
            session()->setFlashdata('danied', 'File tidak dapat diupload.');
            return redirect()->to(base_url('admin'));
        }else{
            unlink('public/berkas/permohonan.pdf');
            $namaBerkas = 'permohonan.pdf';
            $berkas->move('public/berkas/', $namaBerkas);
        }

        session()->setFlashdata('pesan', 'Dokumen permohonan telah diupload.');
        return redirect()->to(base_url('admin'));
    }




    public function jurusan()
    {
        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        $data = [
            'title' => 'Kelola Jurusan',
            'user' => $this->User->where('username', session()->get('username'))->first(),
            'jurusan' => $this->Jurusan->findAll()
        ];

        return view('admin/jurusan', $data);
    }




    public function tambahJurusan()
    {
        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        $nama = htmlspecialchars($this->request->getVar('nama'));

        $this->Jurusan->save([
            'nama' => $nama
        ]);

        session()->setFlashdata('pesan', 'Jurusan telah ditambah.');
        return redirect()->to(base_url('admin/jurusan'));
    }




    public function updateJurusan()
    {
        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        $id = htmlspecialchars($this->request->getVar('id'));
        $nama = htmlspecialchars($this->request->getVar('nama'));

        $this->Jurusan->save([
            'id' => $id,
            'nama' => $nama
        ]);

        session()->setFlashdata('pesan', 'Jurusan telah diubah.');
        return redirect()->to(base_url('admin/jurusan'));
    }




    public function penilaian($nama = false)
    {
        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        if(!$nama)
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('admin'));
        }

        $jurusan = $this->Jurusan->where('nama', $nama)->first();
        if(!$jurusan)
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('admin'));
        }

        $nonTeknis = $this->Penilaian->where(['jid' => $jurusan->id, 'kategori' => 'non-teknis'])->find();
        $teknis = $this->Penilaian->where(['jid' => $jurusan->id, 'kategori' => 'teknis'])->find();

        $data = [
            'title' => 'Format Penilaian',
            'user' => $this->User->where('username', session()->get('username'))->first(),
            'validation' => \Config\Services::validation(),
            'jurusan' => $jurusan,
            'nonTeknis' => $nonTeknis,
            'teknis' => $teknis
        ];

        return view('admin/penilaian', $data);
    }




    public function simpanPenilaian()
    {

        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        $jurusan = $this->Jurusan->where('id', $this->request->getVar('jid'))->first();

        $nonTeknis = $this->request->getVar('non_teknis');
        $teknis = $this->request->getVar('teknis');

        $totalNonTeknis = count($nonTeknis);
        $totalTeknis = count($teknis);

        for($i=0; $i<$totalNonTeknis; $i++){

            $nama = $nonTeknis[$i];
            $kategori = 'non-teknis';

            if($nama != "")
            {
                $this->Penilaian->save([
                'jid' => $jurusan->id,
                'kategori' => $kategori,
                'nama' => $nama,
                ]);
            }
        }

        for($a=0; $a<$totalTeknis; $a++){

            $namaa = $teknis[$a];
            $kategorii = 'teknis';

            if($namaa != "")
            {
                $this->Penilaian->save([
                'jid' => $jurusan->id,
                'kategori' => $kategorii,
                'nama' => $namaa,
                ]);
            }
        }

        session()->setFlashdata('pesan', 'Data telah disimpan.');
        return redirect()->to(base_url('admin/jurusan/'));
    }




    public function hapusPenilaian()
    {
        if(session()->get('role') != 'admin')
        {
            return redirect()->to(base_url());
        }

        $id = $_POST['id'];
        $this->Penilaian->delete($id);
    }





    public function siswa()
    {
        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        $nama = $this->request->getVar('keyword');

        if($nama)
        {
            $siswa = $this->User->where('role', 'siswa')->like('nama', $nama)->orderBy('id', 'desc')->find();
            $view = 'siswap';
        }else{
            $siswa = $this->User->where('role', 'siswa')->orderBy('id', 'desc')->paginate(20);
            $view = 'siswa';
        }

        $data = [
            'title' => 'Kelola Siswa',
            'user' => $this->User->where('username', session()->get('username'))->first(),
            'siswa' => $siswa,
            'pager' => $this->User->pager,
            'nomor' => $this->nomor($this->request->getVar('page'), 20)
        ];

        return view('admin/'.$view, $data);
    }




    public function tambahSiswa()
    {
        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        $data = [
            'title' => 'Kelola Siswa',
            'user' => $this->User->where('username', session()->get('username'))->first(),
            'jurusan' => $this->Jurusan->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/tambahSiswa', $data);
    }




    public function simpanSiswa()
    {

        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        //Validasi input
        if(!$this->validate([

        'nama' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Nama tidak boleh kosong.'
            ]
        ],

        'nis' => [
            'rules' => 'required|is_unique[user.nis]',
            'errors' => [
            'required' => 'NIS tidak boleh kosong.',
            'is_unique' => 'NIS sudah terdaftar.'
            ]
        ],

        'jurusan' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Jurusan tidak boleh kosong.'
            ]
        ],

        'kelas' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Kelas tidak boleh kosong.'
            ]
        ],

        'telepon' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Telepon tidak boleh kosong.'
            ]
        ],

        'alamat' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Alamat tidak boleh kosong.'
            ]
        ]

        ])) {
            return redirect()->to(base_url('admin/tambahSiswa/'))->withInput();
        }

        $this->User->save([
        'nama' => htmlspecialchars($this->request->getVar('nama')),
        'nis' => htmlspecialchars($this->request->getVar('nis')),
        'jurusan' => htmlspecialchars($this->request->getVar('jurusan')),
        'kelas' => htmlspecialchars($this->request->getVar('kelas')),
        'telepon' => htmlspecialchars($this->request->getVar('telepon')),
        'alamat' => htmlspecialchars($this->request->getVar('alamat')),
        'foto' => 'default.png',
        'username' => htmlspecialchars($this->request->getVar('nis')),
        'password' => password_hash($this->request->getVar('nis'), PASSWORD_DEFAULT),
        'role' => 'siswa'
        ]);

        session()->setFlashdata('pesan', 'Data telah disimpan.');
        return redirect()->to(base_url('admin/siswa'));
    }




    public function editSiswa($id = false)
    {
        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        if(!$id)
        {
            session()->setFlashdata('danied', 'Siswa tidak ditemukan.');
            return redirect()->to(base_url('admin/siswa'));
        }

        $data = $this->User->where('id', $id)->first();
        if(!$data)
        {
            session()->setFlashdata('danied', 'Siswa tidak ditemukan.');
            return redirect()->to(base_url('admin/siswa'));
        }

        $data = [
            'title' => 'Edit Data Siswa',
            'user' => $this->User->where('username', session()->get('username'))->first(),
            'jurusan' => $this->Jurusan->findAll(),
            'data' => $data,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/editSiswa', $data);
    }




    public function updateSiswa()
    {

        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        $id = $this->request->getVar('id');

        //Validasi input
        if(!$this->validate([

        'nama' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Nama tidak boleh kosong.'
            ]
        ],

        'nis' => [
            'rules' => 'required|is_unique[user.nis,id,'.$id.']',
            'errors' => [
            'required' => 'NIS tidak boleh kosong.',
            'is_unique' => 'NIS telah terdaftar'
            ]
        ],

        'jurusan' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Jurusan tidak boleh kosong.'
            ]
        ],

        'kelas' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Kelas tidak boleh kosong.'
            ]
        ],

        'telepon' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Telepon tidak boleh kosong.'
            ]
        ],

        'alamat' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Alamat tidak boleh kosong.'
            ]
        ]

        ])) {
            return redirect()->to(base_url('admin/editSiswa/'.$id))->withInput();
        }

        $data = $this->User->where('id', $id)->first();

        $this->User->save([
        'id' => $id,
        'nama' => htmlspecialchars($this->request->getVar('nama')),
        'nis' => htmlspecialchars($this->request->getVar('nis')),
        'jurusan' => htmlspecialchars($this->request->getVar('jurusan')),
        'kelas' => htmlspecialchars($this->request->getVar('kelas')),
        'telepon' => htmlspecialchars($this->request->getVar('telepon')),
        'alamat' => htmlspecialchars($this->request->getVar('alamat'))
        ]);

        session()->setFlashdata('pesan', 'Data telah diubah.');
        return redirect()->to(base_url('admin/siswa'));
    }




    public function hapusSiswa($id = false)
    {
        if(session()->get('role') != 'admin')
        {
            return redirect()->to(base_url());
        }

        if(!$id)
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('admin/siswa'));
        }

        $data = $this->User->where('id', $id)->first();
        if(!$data)
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('admin/siswa'));
        }

        if($data->foto != 'default.png')
        {
            unlink('public/img/'.$data->foto);
        }

        $permohonan = $this->Permohonan->where('uid', $id)->find();
        foreach($permohonan as $p)
        {
            $this->Permohonan->delete($p->id);
        }

        $this->User->delete($id);

        session()->setFlashdata('pesan', 'Siswa berhasil dihapus');
        return redirect()->to(base_url('admin/siswa'));
    }




    public function pegawai()
    {
        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        $nama = $this->request->getVar('keyword');

        if($nama)
        {
            $kajur = $this->User->where('role', 'kajur')->like('nama', $nama)->orderBy('nama', 'esc')->find();
            $pembimbing = $this->User->where('role', 'pembimbing')->like('nama', $nama)->orderBy('jurusan', 'esc')->find();
        }else{
            $kajur = $this->User->where('role', 'kajur')->orderBy('nama', 'esc')->find();
            $pembimbing = $this->User->where('role', 'pembimbing')->orderBy('nama', 'esc')->find();
        }

        $data = [
            'title' => 'Kelola Pegawai',
            'user' => $this->User->where('username', session()->get('username'))->first(),
            'kajur' => $kajur,
            'pembimbing' => $pembimbing
        ];

        return view('admin/pegawai', $data);
    }




    public function tambahPegawai()
    {
        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        $data = [
            'title' => 'Kelola Pegawai',
            'user' => $this->User->where('username', session()->get('username'))->first(),
            'jurusan' => $this->Jurusan->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/tambahPegawai', $data);
    }




    public function simpanPegawai()
    {

        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        //Validasi input
        if(!$this->validate([

        'nama' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Nama tidak boleh kosong.'
            ]
        ],


        'jabatan' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Jabatan tidak boleh kosong.'
            ]
        ],

        'jurusan' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Jabatan tidak boleh kosong.'
            ]
        ],

        'telepon' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Telepon tidak boleh kosong.'
            ]
        ],

        'alamat' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Alamat tidak boleh kosong.'
            ]
        ],

        'username' => [
            'rules' => 'required|is_unique[user.username]',
            'errors' => [
            'required' => 'Username tidak boleh kosong.',
            'is_unique' => 'Username sudah terdaftar.'
            ]
        ]

        ])) {
            return redirect()->to(base_url('admin/tambahPegawai/'))->withInput();
        }

        $this->User->save([
        'nama' => htmlspecialchars($this->request->getVar('nama')),
        'jurusan' => htmlspecialchars($this->request->getVar('jurusan')),
        'telepon' => htmlspecialchars($this->request->getVar('telepon')),
        'alamat' => htmlspecialchars($this->request->getVar('alamat')),
        'foto' => 'default.png',
        'username' => htmlspecialchars($this->request->getVar('username')),
        'password' => password_hash($this->request->getVar('username'), PASSWORD_DEFAULT),
        'role' => htmlspecialchars($this->request->getVar('jabatan'))
        ]);

        session()->setFlashdata('pesan', 'Data telah disimpan.');
        return redirect()->to(base_url('admin/pegawai'));
    }




    public function editPegawai($id = false)
    {
        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        if(!$id)
        {
            session()->setFlashdata('danied', 'Pegawai tidak ditemukan.');
            return redirect()->to(base_url('admin/pegawai'));
        }

        $data = $this->User->where('id', $id)->first();
        if(!$data)
        {
            session()->setFlashdata('danied', 'Pegawai tidak ditemukan.');
            return redirect()->to(base_url('admin/pegawai'));
        }

        $data = [
            'title' => 'Edit Data Pegawai',
            'user' => $this->User->where('username', session()->get('username'))->first(),
            'jurusan' => $this->Jurusan->findAll(),
            'data' => $data,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/editPegawai', $data);
    }




    public function updatePegawai()
    {

        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        $id = $this->request->getVar('id');

        //Validasi input
        if(!$this->validate([

        'nama' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Nama tidak boleh kosong.'
            ]
        ],

        'jabatan' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Jabattan tidak boleh kosong.'
            ]
        ],

        'jurusan' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Jurusan tidak boleh kosong.'
            ]
        ],

        'telepon' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Telepon tidak boleh kosong.'
            ]
        ],

        'alamat' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Alamat tidak boleh kosong.'
            ]
        ],

        'username' => [
            'rules' => 'required|is_unique[user.username,id,'.$id.']',
            'errors' => [
            'required' => 'Username tidak boleh kosong.',
            'is_unique' => 'Username sudah terdaftar.'
            ]
        ]

        ])) {
            return redirect()->to(base_url('admin/editPegawai/'.$id))->withInput();
        }

        $data = $this->User->where('id', $id)->first();

        $password = $this->request->getVar('password');
        if($password)
        {
            $pass = password_hash($password, PASSWORD_DEFAULT);
        }else{
            $pass = $data->password;
        }

        $this->User->save([
        'id' => $id,
        'nama' => htmlspecialchars($this->request->getVar('nama')),
        'jurusan' => htmlspecialchars($this->request->getVar('jurusan')),
        'telepon' => htmlspecialchars($this->request->getVar('telepon')),
        'alamat' => htmlspecialchars($this->request->getVar('alamat')),
        'username' => htmlspecialchars($this->request->getVar('username')),
        'password' => $pass,
        'role' => htmlspecialchars($this->request->getVar('jabatan'))
        ]);

        session()->setFlashdata('pesan', 'Data telah diubah.');
        return redirect()->to(base_url('admin/pegawai'));
    }




    public function hapusPegawai($id = false)
    {
        if(session()->get('role') != 'admin')
        {
            return redirect()->to(base_url());
        }

        if(!$id)
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('admin/pegawai'));
        }

        $data = $this->User->where('id', $id)->first();
        if(!$data)
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('admin/pegawai'));
        }

        if($data->foto != 'default.png')
        {
            unlink('public/img/'.$data->foto);
        }

        $this->User->delete($id);

        session()->setFlashdata('pesan', 'Pegawai berhasil dihapus');
        return redirect()->to(base_url('admin/pegawai'));
    }




    public function nilai($id = false)
    {
        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }


        if($id)
        {
            $user = $this->User->where('id', $id)->first();
            $jurusan = $this->Jurusan->where('id', $user->jurusan)->first();
            $kelompok = $this->Permohonan->where('uid', $user->id)->first();
            $pembimbing = $this->Kelompok->where('uid', $user->id)->first();
            $p = $this->User->where('id', $pembimbing->pid)->first();
            $nonTeknis = $this->Penilaian->where(['jid' => $jurusan->id, 'kategori' => 'non-teknis'])->find();
            $teknis = $this->Penilaian->where(['jid' => $jurusan->id, 'kategori' => 'teknis'])->find();

            $data = [
                'title' => $user->nama,
                'user' => $this->User->where('username', session()->get('username'))->first(),
                'siswa' => $user,
                'kelompok' => $kelompok,
                'jurusan' => $jurusan,
                'pembimbing' => $p,
                'nonTeknis' => $nonTeknis,
                'teknis' => $teknis
            ];

            return view('admin/nilaiSiswa', $data);
        }


        $siswa = $this->Permohonan->where('status', '4')->orderBy('id', 'desc')->paginate(20);
        $data = [
            'title' => 'Penilaian Sertifikat Siswa',
            'user' => $this->User->where('username', session()->get('username'))->first(),
            'siswa' => $siswa,
            'pager' => $this->Permohonan->pager,
            'nomor' => $this->nomor($this->request->getVar('page'), 20)
        ];

        return view('admin/nilai', $data);
    }




    public function simpanNilai()
    {
        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        $user = $this->User->where('id', $this->request->getVar('uid'))->first();
        $penilaian = $this->Penilaian->where('jid', $this->request->getVar('jid'))->find();
        foreach($penilaian as $p)
        {
            $nilaiLama = $this->Nilai->where(['uid' => $user->id, 'idp' => $p->id])->first();
            $nilai = $this->request->getVar($p->id);
            if($nilaiLama)
            {
                $this->Nilai->save([
                    'id' => $nilaiLama->id,
                    'uid' => $user->id,
                    'idp' => $p->id,
                    'nilai' => $nilai
                ]);
            }

            $this->Nilai->save([
                'uid' => $user->id,
                'idp' => $p->id,
                'nilai' => $nilai
            ]);
        }

        $permohonan = $this->Permohonan->where(['uid' => $user->id, 'status' => 4])->first();
        $this->Permohonan->save([
            'id' => $permohonan->id,
            'status' => 5
        ]);

        session()->setFlashdata('pesan', 'Nilai telah diisi');
        return redirect()->to(base_url('admin/nilai'));
    }




    public function ubahNilai($id = false)
    {
        $user = $this->User->where('id', $id)->first();
        $jurusan = $this->Jurusan->where('id', $user->jurusan)->first();
        $kelompok = $this->Permohonan->where('uid', $user->id)->first();
        $pembimbing = $this->Kelompok->where('uid', $user->id)->first();
        $p = $this->User->where('id', $pembimbing->pid)->first();
        $data = [
            'title' => $user->nama,
            'user' => $this->User->where('username', session()->get('username'))->first(),
            'siswa' => $user,
            'kelompok' => $kelompok,
            'jurusan' => $jurusan,
            'pembimbing' => $p,
            'nonTeknis' => $this->Penilaian->where(['jid' => $jurusan->id, 'kategori' => 'non-teknis'])->find(),
            'teknis' => $this->Penilaian->where(['jid' => $jurusan->id, 'kategori' => 'teknis'])->find()
        ];

        return view('admin/ubahNilai', $data);
    }




    public function updateNilai()
    {
        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        $user = $this->User->where('id', $this->request->getVar('uid'))->first();
        $penilaian = $this->Penilaian->where('jid', $this->request->getVar('jid'))->find();
        foreach($penilaian as $p)
        {
            $nilaiLama = $this->Nilai->where(['uid' => $user->id, 'idp' => $p->id])->first();
            $nilai = $this->request->getVar($p->id);

            $this->Nilai->save([
                'id' => $nilaiLama->id,
                'uid' => $user->id,
                'idp' => $p->id,
                'nilai' => $nilai
            ]);

        }

        session()->setFlashdata('pesan', 'Nilai telah diubah');
        return redirect()->to(base_url('admin/sertifikat'));
    }




    public function hapusNilai($id = false)
    {
        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        if(!$id)
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('admin/nilai'));
        }

        $user = $this->User->where('id', $id)->first();
        if(!$user)
        {
            session()->setFlashdata('danied', 'Siswa tidak ditemukan');
            return redirect()->to(base_url('admin/nilai'));
        }

        $permohonan = $this->Permohonan->where(['uid' => $id, 'status' => 4])->first();
        $kelompok = $this->Kelompok->where('uid', $id)->first();

        $this->Permohonan->save([
            'id' => $permohonan->id,
            'status' => 3
        ]);

        $this->Kelompok->save([
            'id' => $kelompok->id,
            'status' => 0
        ]);

        session()->setFlashdata('pesan', 'Status siswa telah diperbarui.');
        return redirect()->to(base_url('admin/nilai'));  
    }




    public function sertifikat($id = false)
    {
        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }


        if($id)
        {
            $user = $this->User->where('id', $id)->first();
            $data = [
                'title' => $user->nama,
                'user' => $this->User->where('username', session()->get('username'))->first(),
                'siswa' => $user
            ];

            return view('admin/coverSertifikat', $data);
        }


        $siswa = $this->Permohonan->where('status', '5')->orderBy('id', 'desc')->paginate(20);
        $data = [
            'title' => 'Sertifikat Siswa',
            'user' => $this->User->where('username', session()->get('username'))->first(),
            'siswa' => $siswa,
            'pager' => $this->Permohonan->pager,
            'nomor' => $this->nomor($this->request->getVar('page'), 20)
        ];

        return view('admin/sertifikat', $data);
    }




    public function nilaiSertifikat($id = false)
    {
        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        $user = $this->User->where('id', $id)->first();
        $jurusan = $this->Jurusan->where('id', $user->jurusan)->first();

        $data = [
            'title' => $user->nama,
            'user' => $this->User->where('username', session()->get('username'))->first(),
            'siswa' => $user,
            'permohonan' => $this->Permohonan->where(['uid' => $user->id, 'status' => 5])->first(),
            'nonTeknis' => $this->Penilaian->where(['jid' => $jurusan->id, 'kategori' => 'non-teknis'])->find(),
            'teknis' => $this->Penilaian->where(['jid' => $jurusan->id, 'kategori' => 'teknis'])->find()
        ];

        return view('admin/nilaiSertifikat', $data);
    }




    public function akun()
    {
        if(session()->get('role') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url());
        }

        $data = [
            'title' => 'Edit Akun',
            'user' => $this->User->where('username', session()->get('username'))->first(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/akun', $data);
    }




    public function updateAkun()
    {
        if(session()->get('role') != 'admin')
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
            'is_unique' => 'Username sudah terdaftar'
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
            return redirect()->to(base_url('admin/akun/'))->withInput();
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
        return redirect()->to(base_url('admin/akun'));    

    }



}
