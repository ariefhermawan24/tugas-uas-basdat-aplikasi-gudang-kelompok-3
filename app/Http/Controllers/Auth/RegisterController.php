<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        // =========================
        // VALIDASI
        // =========================
        $request->validate([
            'company_name' => 'required|string|max:150',
            'name'         => 'required|string|max:100',
            'email'        => 'required|email|unique:user,email',

            'phone'        => [
                'nullable',
                'regex:/^[0-9]+$/',
                'min:10',
                'max:15',
            ],

            'password'     => 'required|min:8|confirmed',
        ], [
            'company_name.required' => 'Nama perusahaan wajib diisi',
            'name.required'         => 'Nama lengkap wajib diisi',
            'email.unique'          => 'Email sudah terdaftar',

            'phone.regex'           => 'Nomor telepon hanya boleh berisi angka',
            'phone.min'             => 'Nomor telepon minimal 10 digit',
            'phone.max'             => 'Nomor telepon maksimal 15 digit',

            'password.confirmed'    => 'Konfirmasi password tidak sesuai',
        ]);

        $now = Carbon::now();
        $prefix = $now->format('mY'); // contoh: 092025

        $lastUser = User::where('user_code', 'like', $prefix . '%')
            ->orderBy('user_code', 'desc')
            ->first();

        $nextNumber = 1;

        if ($lastUser) {
            $lastNumber = (int) substr($lastUser->user_code, -4);
            $nextNumber = $lastNumber + 1;
        }

        $userCode = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        User::create([
            'user_code'    => $userCode,
            'company_name' => $request->company_name,
            'name'         => $request->name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'password'     => Hash::make($request->password),
            'role'         => 'user',
            'status'       => 'active',
        ]);

        return redirect('/login')
            ->with('open_register', true)
            ->with('success', 'Akun berhasil dibuat, silakan login.');
    }
}
