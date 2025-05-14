<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;

helper('session');

class Login extends BaseController
{
    protected $usersModel;

    public function __construct()
    {
        $this->usersModel   = new UsersModel();
    }

    public function index()
    {
        $session = session();

        if ($this->request->getMethod() === 'post') {
            $email = htmlspecialchars(trim($this->request->getPost('email')));
            $password = $this->request->getPost('password');

            $user = $this->usersModel->getByEmail($email);

            if (!$user) {
                return redirect()->back()->withInput()->with('error', 'Email tidak ditemukan.');
            }

            if (!password_verify($password, $user->password)) {
                return redirect()->back()->withInput()->with('error', 'Password salah.');
            }

            if ($user->status !== 'active') {
                return redirect()->back()->withInput()->with('error', 'Akun Anda tidak aktif.');
            }

            $session->set([
                'id'         => $user->id,
                'email'      => $user->email,
                'role'       => $user->role,
                'status'     => $user->status,
                'logged_in'  => true
            ]);

            if ($user->role === 'admin') {
                return redirect()->to('/dashboard')->with('success', 'Selamat datang');
            } else {
                return redirect()->to('/user/dashboard')->with('success', 'Selamat datang');
            }
        }

        return view('auth/login');
    }
}
