<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class Login extends BaseController
{
    protected $usersModel;

    public function __construct()
    {
        $this->usersModel   = new UsersModel();
    }

    // public function index()
    // {
    //     $session = session();

    //     if ($this->request->getMethod() !== 'post') {
    //         return view('auth/login');
    //     }

    //     $username = trim($this->request->getPost('username'));
    //     $password = $this->request->getPost('password');

    //     $user = $this->usersModel->where('username', $username)->first();
    //     var_dump($user);
    //     die;

    //     if (!$user) {
    //         return redirect()->back()->withInput()->with('pesan', 'Username tidak ditemukan.');
    //     }

    //     if (!password_verify($password, $user->password)) {
    //         return redirect()->back()->withInput()->with('pesan', 'Password salah.');
    //     }

    //     if ($user->status !== 'active') {
    //         return redirect()->back()->withInput()->with('pesan', 'Akun Anda tidak aktif.');
    //     }

    //     $session->set([
    //         'id'         => $user->id,
    //         'username'   => $user->username,
    //         'id_guru'    => $user->id_guru,
    //         'email'      => $user->email,
    //         'role'       => $user->role,
    //         'status'     => $user->status,
    //         'logged_in'  => true
    //     ]);
    //     dd(session()->get());

    //     return redirect()->to('dashboard')->with('pesan', 'Berhasil login sebagai <strong>' . $user->username . '</strong>!');
    // }

    public function index()
    {
        if ($this->request->getMethod() === 'post') {
            dd('POST request diterima');
        }

        return view('auth/login');
    }
}
