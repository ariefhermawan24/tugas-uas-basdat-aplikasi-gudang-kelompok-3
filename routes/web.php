<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\middleware;
use Illuminate\Support\Facades\Hash;
use App\Models\Notification;
use App\Models\Order;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {

    // Jika sudah login & BUKAN habis login baru
    if (Auth::check() && !session()->has('login_success')) {

        return match (Auth::user()->role) {
            'admin'  => redirect()->route('admin'),
            'user'   => redirect()->route('user'),
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
            'renew_request',
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

    Route::get('/user/{module?}', function ($module = 'dashboard') {

        $allowedModules = [
            'dashboard',
            'make_order',
            'orders_details',
            'orders_history',
            'renew_order',
            'active_orders',
            'due_orders',
            'expired_orders',
            'goods_in',
            'goods_out',
            'orders_create',
        ];

        if (!in_array($module, $allowedModules)) {
            abort(404);
        }

        $user = Auth::user();

        $orders = collect();

        if (in_array($module, [
            'make_order',
            'orders_details',
            'orders_history',
            'active_orders',
            'due_orders',
            'expired_orders'
        ])) {
            $orders = Order::where('user_id', $user->id)
            ->when($module === 'make_order', fn ($q) => $q->whereIn('status', ['checking', 'pending', 'approved', 'rejected']))
            ->when($module === 'orders_history', fn ($q) => $q->whereIn('status', ['outgoing', 'expired']))
            ->when($module === 'active_orders', fn ($q) => $q->where('status', 'active'))
            ->when($module === 'due_orders', fn ($q) => $q->where('status', 'due'))
            ->when($module === 'expired_orders', fn ($q) => $q->where('status', 'expired'))
            ->latest()
            ->get();
        }

        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->limit(20)
            ->get();

        return view('user.userpanel', [
            'module' => $module,
            'orders' => $orders,
            'notifications' => $notifications,
        ]);

    })->name('user');
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

Route::middleware([middleware::class . ':user'])->post(
    '/user/order/store',
    function (Illuminate\Http\Request $request) {

        $request->validate([
            'order_code'         => 'required|unique:orders,order_code',
            'item_name'          => 'required|string|max:150',
            'item_type'          => 'required|string|max:100',
            'item_size' => 'required|in:small,medium,large',
            'quantity'           => 'required|integer|min:1',
            'pallet_estimated'   => 'required|integer|min:1',
            'storage_duration'   => 'required|integer|min:1',
            'storage_end_date'   => 'required|date|after:today',
            'price'              => 'required|numeric|min:0',
        ]);

        Order::create([
            'user_id'            => Auth::id(),
            'order_code'         => $request->order_code,
            'item_name'          => $request->item_name,
            'item_type'          => $request->item_type,
            'item_size'         => $request->item_size,
            'quantity'           => $request->quantity,
            'pallet_estimated'   => $request->pallet_estimated ?? 0,
            'storage_duration'   => $request->storage_duration,
            'estimated_delivery' => $request->estimated_delivery,
            'storage_end_date'   => $request->storage_end_date,
            'price'              => $request->price ?? 0,
            'status'             => 'pending',
        ]);

        Notification::create([
            'user_id' => Auth::id(),
            'title'   => 'Pesanan Dibuat',
            'message' => 'Pesanan ' . $request->order_code . ' berhasil dibuat',
        ]);

        return redirect()
            ->route('user', 'make_order')
            ->with('account_success', 'Pesanan berhasil dibuat');
    }
)->name('user.order.store');

Route::middleware([middleware::class . ':user'])->group(function () {

    Route::get('/user/orders/{order}/edit', function (Order $order) {

    abort_if($order->user_id !== Auth::id(), 403);

    $notifications = Notification::where('user_id', Auth::id())
        ->latest()
        ->limit(20)
        ->get();

    return view('user.userpanel', [
        'module'        => 'orders_edit',
        'order'         => $order,
        'notifications' => $notifications,
    ]);

})->name('user.orders.edit');

    Route::put('/user/orders/{order}', function (Request $request, Order $order) {

        abort_if($order->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'item_name'         => 'required|string|max:255',
            'item_type'         => 'required|string|max:255',
            'quantity'          => 'required|integer|min:1',
            'item_size'         => 'required|in:small,medium,large',
            'storage_end_date'  => 'required|date|after:today',
            'pallet_estimated'  => 'required|integer|min:1',
            'storage_duration'  => 'required|integer|min:1',
            'price'             => 'required|numeric|min:0',
        ]);

        $order->update($validated);

        Notification::create([
            'user_id' => Auth::id(),
            'title'   => 'Pesanan Diperbarui',
            'message' => 'Pesanan ' . $order->order_code . ' berhasil diperbarui',
        ]);

        return redirect()
            ->route('user', 'make_order')
            ->with('account_success', 'Pesanan berhasil diperbarui');

    })->name('user.orders.update');

});
