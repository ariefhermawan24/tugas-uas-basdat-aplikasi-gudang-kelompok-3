<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\middleware;
use Illuminate\Support\Facades\Hash;
use App\Models\Notification;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {

    // Jika sudah login & BUKAN habis login baru
    if (Auth::check() && !session()->has('login_success')) {

        return match (Auth::user()->role) {
            'admin'  => redirect()->route('admin'),
            'user'   => redirect()->route('user.dashboard'),
            'satpam' => redirect()->route('satpam.dashboard'),
            default  => abort(403),
        };
    }

    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.process');

Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store');

Route::middleware([middleware::class . ':admin'])->group(function () {

    Route::get('/admin/{module?}', function ($module = 'dashboard') {

        $allowedModules = [
            'dashboard',
            'orders_details',
            'orders_validation',
            'orders_history',
            'upcoming_goods',
            'outgoing_goods',
            'active_orders',
            'due_orders',
            'expired_orders',
            'user_list',
            'user_status',

        ];

        if (!in_array($module, $allowedModules)) {
            abort(404);
        }

        $notifications = Notification::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();

        return view('admin.adminpanel', [
            'module' => $module,
            'notifications' => $notifications,
        ]);

    })->name('admin');

});

Route::middleware([middleware::class . ':user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.userpanel');
    })->name('user.dashboard');
});

Route::middleware([middleware::class . ':satpam'])->group(function () {
    Route::get('/satpam/dashboard', function () {
        return view('satpam.satpampanel');
    })->name('satpam.dashboard');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')
        ->with('session_expired', 'Session Anda telah berakhir');
})->name('logout');

Route::put('/account/update', function (Request $request) {

    /** @var \App\Models\User $user */
    $user = Auth::user(); // HARUS Eloquent

    $user->fill($request->only([
        'name',
        'email',
        'company_name',
        'phone'
    ]));

    $user->save();

    // Simpan notifikasi
    Notification::create([
        'user_id' => $user->id,
        'title'   => 'Profil Diperbarui',
        'message' => 'Detail akun berhasil diperbarui',
    ]);

    return redirect()
        ->back()
        ->with('account_success', 'Account berhasil diperbarui');
})->name('account.update');

Route::put('/account/password/update', function (Request $request) {

    $request->validate([
        'current_password' => 'required',
        'password' => 'required|min:8|confirmed',
    ]);

    /** @var \App\Models\User $user */
    $user = Auth::user(); // HARUS Eloquent

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->with('account_error', 'Sandi lama tidak sesuai');
    }

    $user->password = Hash::make($request->password);
    $user->save();

    // Simpan notifikasi
    Notification::create([
        'user_id' => $user->id,
        'title'   => 'Keamanan Akun',
        'message' => 'Sandi akun berhasil diubah',
    ]);

    return back()->with('account_success', 'Sandi berhasil diperbarui');
})->name('account.password.update');

// Ambil notifikasi (untuk modal)
Route::get('/notifications', function () {

    return Notification::where('user_id', Auth::id())
        ->orderByDesc('created_at')
        ->limit(20)
        ->get();
})->name('notifications.index');


Route::post('/notifications/{id}/read', function ($id) {

    Notification::where('id', $id)
        ->where('user_id', Auth::id())
        ->update(['is_read' => 1]);

    return response()->json(['success' => true]);

})->name('notifications.read');


Route::delete('/notifications/{id}', function ($id) {

    Notification::where('id', $id)
        ->where('user_id', Auth::id())
        ->delete();

    return response()->json(['success' => true]);

})->name('notifications.delete');
