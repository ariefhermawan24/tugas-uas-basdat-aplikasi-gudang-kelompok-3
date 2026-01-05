<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Middleware\middleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Notification;
use App\Models\Order;
use App\Models\User;
use Illuminate\Validation\Rules\In;
use Carbon\Carbon;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {

    if (Auth::check()) {

        // CEK STATUS USER (STRING)
        if (Auth::user()->status === 'inactive') {

            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()->route('login')->with('swal', [
                'icon'  => 'error',
                'title' => 'Akun Tidak Aktif',
                'text'  => 'Akun Anda dinonaktifkan. Silakan hubungi admin.'
            ]);
        }

        // USER AKTIF → REDIRECT NORMAL
        if (!session()->has('login_success')) {
            return match (Auth::user()->role) {
                'admin'  => redirect()->route('admin'),
                'user'   => redirect()->route('user'),
                'satpam' => redirect()->route('satpam.dashboard'),
                default  => abort(403),
            };
        }
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
            'due_orders',
            'expired_orders',
            'user_list',
            'user_status',
        ];

        if (!in_array($module, $allowedModules)) {
            abort(404);
        }

        // ================= NOTIFICATIONS =================
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->limit(20)
            ->get();

        // ================= DEFAULT DATA =================
        $orders = collect();
        $users  = collect();

        // ================= DASHBOARD =================
        if ($module === 'dashboard') {

            $totalItems = Order::sum('quantity');

            $incomingToday = Order::whereDate('created_at', today())
                ->whereIn('status', ['stored', 'active'])
                ->sum('quantity');

            $outgoingToday = Order::whereDate('updated_at', today())
                ->where('status', 'outgoing')
                ->sum('quantity');

            $validateRequests = Order::whereIn('status', ['checking', 'pending'])->count();
            $renewRequests    = Order::where('status', 'renew')->count();

            $activeCount  = Order::where('status', 'stored')->count();
            $dueCount     = Order::where('status', 'due')->count();
            $expiredCount = Order::where('status', 'expired')->count();

            $totalOrders = max(
                $activeCount + $dueCount + $expiredCount,
                1
            );

            return view('admin.adminpanel', [
                'module'           => 'dashboard',

                // statistik
                'totalItems'       => $totalItems,
                'incomingToday'    => $incomingToday,
                'outgoingToday'    => $outgoingToday,

                // request
                'validateRequests' => $validateRequests,
                'renewRequests'    => $renewRequests,

                // status
                'activeCount'      => $activeCount,
                'dueCount'         => $dueCount,
                'expiredCount'     => $expiredCount,
                'totalOrders'      => $totalOrders,

                'notifications'    => $notifications,
            ]);
        }

        // ================= USER LIST =================
        if (in_array($module, ['user_list', 'user_status'])) {
            $users = User::where('role', 'user')
                ->orderBy('company_name', 'asc')
                ->get();
        }

        // ================= ORDERS =================
        if (in_array($module, [
            'orders_validation',
            'orders_details',
            'orders_history',
            'due_orders',
            'expired_orders',
            'upcoming_goods',
            'outgoing_goods',
            'renew_request'
        ])) {

            $orders = Order::with('user')
                ->when($module === 'orders_validation', fn ($q) =>
                    $q->where('status', 'pending')
                )
                ->when($module === 'orders_history', fn ($q) =>
                    $q->whereIn('status', ['outgoing', 'expired', 'canceled', 'completed'])
                )
                ->when($module === 'due_orders', fn ($q) =>
                    $q->where('status', 'due')
                )
                ->when($module === 'expired_orders', fn ($q) =>
                    $q->where('status', 'expired')
                )
                ->when($module === 'outgoing_goods', fn ($q) =>
                    $q->where('status', 'outgoing')
                )
                ->when($module === 'upcoming_goods', fn ($q) =>
                    $q->where('status', 'upcoming')
                )
                ->when($module === 'renew_request', fn ($q) =>
                    $q->where('status', 'renewed')
                )
                ->when($module === 'orders_details', fn ($q) =>
                    $q->whereNotIn('status', ['completed', 'canceled'])
                )
                ->latest()
                ->get();
        }

        // ================= FINAL VIEW =================
        return view('admin.adminpanel', [
            'module'        => $module,
            'orders'        => $orders,
            'users'         => $users,
            'notifications' => $notifications,
        ]);

    })->name('admin');

});

Route::middleware([middleware::class . ':user'])->group(function () {

    Route::get('/user/{module?}', function ($module = 'dashboard') {

        $allowedModules = [
            'dashboard',
            'make_order',
            'orders_monitoring',
            'orders_history',
            'active_orders',
            'goods_in',
            'goods_out',
            'orders_create',
        ];

        if (!in_array($module, $allowedModules)) {
            abort(404);
        }

        $user = Auth::user();

        $orders = collect();

        $admin = User::where('role', 'admin')
            ->whereNotNull('phone')
            ->firstOrFail();

        // ================= DASHBOARD USER =================
        if ($module === 'dashboard') {

            // TOTAL BARANG (jumlah item milik user)
            $totalItems = Order::where('user_id', $user->id)
                ->sum('quantity');

            // BARANG MASUK (hari ini)
            $incomingToday = Order::where('user_id', $user->id)
                ->whereDate('created_at', today())
                ->whereIn('status', ['stored', 'active'])
                ->sum('quantity');

            // BARANG KELUAR (hari ini)
            $outgoingToday = Order::where('user_id', $user->id)
                ->whereDate('updated_at', today())
                ->where('status', 'outgoing')
                ->sum('quantity');

            // MENUNGGU VALIDASI
            $waitingValidation = Order::where('user_id', $user->id)
                ->whereIn('status', ['checking', 'pending'])
                ->count();

            // RENEW DIAJUKAN
            $renewRequests = Order::where('user_id', $user->id)
                ->where('status', 'renew')
                ->count();

            // STATUS ORDER
            $activeCount  = Order::where('user_id', $user->id)
                ->where('status', 'stored')
                ->count();

            $dueCount = Order::where('user_id', $user->id)
                ->where('status', 'due')
                ->count();

            $expiredCount = Order::where('user_id', $user->id)
                ->where('status', 'expired')
                ->count();

            $totalOrders = max(
                $activeCount + $dueCount + $expiredCount,
                1
            );

            return view('user.userpanel', [
                'module'             => 'dashboard',

                // statistik utama
                'totalItems'         => $totalItems,
                'incomingToday'      => $incomingToday,
                'outgoingToday'      => $outgoingToday,

                // request
                'waitingValidation'  => $waitingValidation,
                'renewRequests'      => $renewRequests,

                // status
                'activeCount'        => $activeCount,
                'dueCount'           => $dueCount,
                'expiredCount'       => $expiredCount,
                'totalOrders'        => $totalOrders,

                'notifications'      => Notification::where('user_id', $user->id)
                    ->latest()
                    ->limit(20)
                    ->get(),

                'admin' => $admin,
            ]);
        }

        // ================= MODULE LAIN =================
        if (in_array($module, [
            'make_order',
            'orders_monitoring',
            'orders_history',
            'active_orders',
            'goods_in',
            'goods_out'
        ])) {
            $orders = Order::where('user_id', $user->id)
                ->when($module === 'make_order', fn($q) =>
                    $q->whereIn('status', ['checking', 'pending', 'approved', 'rejected'])
                )
                ->when($module === 'orders_history', fn($q) =>
                    $q->whereIn('status', ['canceled', 'completed'])
                )
                ->when($module === 'active_orders', fn($q) =>
                    $q->where('status', 'active')
                )
                ->when($module === 'goods_in', fn($q) =>
                    $q->where('status', 'upcoming')
                )
                ->when($module === 'goods_out', fn($q) =>
                    $q->where('status', 'outgoing')
                )
                ->when($module === 'orders_monitoring', fn($q) =>
                    $q->whereNotIn('status', [
                        'checking','pending','approved','rejected',
                        'upcoming','outgoing','canceled','completed','renewed'
                    ])
                )
                ->latest()
                ->get();
        }

        return view('user.userpanel', [
            'module'        => $module,
            'orders'        => $orders,
            'notifications' => Notification::where('user_id', $user->id)
                ->latest()
                ->limit(20)
                ->get(),
            'admin' => $admin,
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
            'status'             => 'checking',
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

Route::delete('/admin/orders/{order}', function (Order $order) {

    // Pastikan hanya admin
    abort_if(Auth::user()->role !== 'admin', 403);

    // Hapus bukti bayar jika ada
    if ($order->bukti_bayar && Storage::disk('public')->exists($order->bukti_bayar)) {
        Storage::disk('public')->delete($order->bukti_bayar);
    }

    $orderCode = $order->order_code;
    $adminName = Auth::user()->name;
    $userId    = $order->user_id;

    // Hapus order
    $order->delete();

    // Notifikasi ke USER pemilik pesanan
    Notification::create([
        'user_id' => $userId,
        'title'   => 'Pesanan Dihapus Admin',
        'message' => 'Pesanan ' . $orderCode . ' telah dihapus oleh admin.',
    ]);

    // (Opsional) Notifikasi ke admin lain
    $admins = User::where('role', 'admin')
        ->where('id', '!=', Auth::id())
        ->get();

    foreach ($admins as $admin) {
        Notification::create([
            'user_id' => $admin->id,
            'title'   => 'Admin Menghapus Pesanan',
            'message' => 'Pesanan ' . $orderCode .
                ' dihapus oleh admin ' . $adminName,
        ]);
    }

    return redirect()
        ->back()
        ->with('account_success', 'Pesanan berhasil dihapus oleh admin');

})->name('admin.orders.destroy');

Route::delete('/user/orders/{order}', function (Order $order) {

    abort_if($order->user_id !== Auth::id(), 403);

    if ($order->bukti_bayar && Storage::disk('public')->exists($order->bukti_bayar)) {
        Storage::disk('public')->delete($order->bukti_bayar);
    }

    $orderCode = $order->order_code;
    $userName  = Auth::user()->name;

    $order->delete();

    Notification::create([
        'user_id' => Auth::id(),
        'title'   => 'Pesanan Dihapus',
        'message' => 'Pesanan ' . $orderCode . ' berhasil dihapus',
    ]);

    // Notifikasi untuk admin
    $admins = User::where('role', 'admin')->get();

    foreach ($admins as $admin) {
        Notification::create([
            'user_id' => $admin->id,
            'title'   => 'Pesanan Dihapus User',
            'message' => 'Pesanan ' . $orderCode .
                ' dihapus oleh user ' . $userName,
        ]);
    }

    return redirect()
        ->back()
        ->with('account_success', 'Pesanan berhasil dihapus');
})->name('user.orders.destroy');

Route::middleware([middleware::class . ':user'])->patch(
    '/user/orders/{order}/cancel',
    function (Order $order) {

        abort_if($order->user_id !== Auth::id(), 403);

        // hanya boleh cancel saat pending
        abort_if($order->status !== 'pending', 403);

        $order->update([
            'status' => 'canceled',
        ]);

        Notification::create([
            'user_id' => Auth::id(),
            'title'   => 'Pesanan Dibatalkan',
            'message' => 'Pesanan ' . $order->order_code . ' berhasil dibatalkan',
        ]);

        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title'   => 'Pesanan Dibatalkan User',
                'message' => 'Pesanan ' . $order->order_code .
                    ' dibatalkan oleh user ' . Auth::user()->name,
            ]);
        }

        return redirect()
            ->route('user', 'make_order')
            ->with('account_success', 'Pesanan berhasil dibatalkan');
    }
)->name('user.orders.cancel');

Route::middleware([middleware::class . ':user'])->group(function () {

    Route::get('/user/orders/{order}/payment', function (Order $order) {

        abort_if($order->user_id !== Auth::id(), 403);

        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->limit(20)
            ->get();

        return view('user.userpanel', [
            'module'        => 'orders_payment',
            'order'         => $order,
            'notifications' => $notifications,
        ]);
    })->name('user.orders.payment');
});

Route::middleware([middleware::class . ':user'])->group(function () {

    Route::post('/user/orders/{order}/payment', function (
        Request $request,
        Order $order
    ) {

        abort_if($order->user_id !== Auth::id(), 403);

        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fileName = 'ord-' . $order->order_code . '.' .
            $request->file('bukti_bayar')->extension();

        $path = $request->file('bukti_bayar')
            ->storeAs('bukti-bayar', $fileName, 'public');

        $order->update([
            'bukti_bayar'  => $path,
            'status_bayar' => 'pending',
            'status'       => 'pending',
        ]);

        Notification::create([
            'user_id' => Auth::id(),
            'title'   => 'Pesanan DIbayarkan',
            'message' => 'Pesanan ' . $order->order_code . ' berhasil dibayarkan',
        ]);

        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title'   => 'Pesanan Dibayar User',
                'message' => 'Pesanan ' . $order->order_code .
                    ' sudah dibayar oleh user ' . Auth::user()->name . ' dan menunggu validasi',
            ]);
        }

        return redirect()
            ->route('user', 'make_order')
            ->with('account_success', 'Bukti pembayaran berhasil dikirim');
    })->name('user.orders.payment.store');
});

Route::middleware([middleware::class . ':admin'])->group(function () {

    Route::get('/admin/orders/{order}/validation', function (Order $order) {

        // 1. Harus ada bukti bayar
        abort_if(!$order->bukti_bayar, 404);

        // 2. Harus status pending
        abort_if($order->status_bayar !== 'pending', 403);

        // 3. Notifikasi admin
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->limit(20)
            ->get();

        return view('admin.adminpanel', [
            'module'        => 'validation_orders',
            'order'         => $order,
            'notifications' => $notifications,
        ]);
    })->name('admin.orders.validation');
});

Route::middleware([middleware::class . ':admin'])->group(function () {

    Route::post('/admin/orders/{order}/validation', function (
        Request $request,
        Order $order
    ) {

        // hanya boleh validasi yang pending
        abort_if($order->status_bayar !== 'pending', 403);

        $request->validate([
            'action' => 'required|in:approve,reject',
        ]);

        if ($request->action === 'approve') {

            // 🔥 HAPUS BUKTI BAYAR SETELAH LUNAS
            if ($order->bukti_bayar && Storage::disk('public')->exists($order->bukti_bayar)) {
                Storage::disk('public')->delete($order->bukti_bayar);
            }

            $order->update([
                'bukti_bayar' => null,
                'status_bayar' => 'lunas',
                'status'      => 'approved',
            ]);

            Notification::create([
                'user_id' => $order->user_id,
                'title'   => 'Pembayaran Dikonfirmasi',
                'message' => 'Pesanan ' . $order->order_code . ' telah divalidasi admin',
            ]);
        } else {

            $order->update([
                'status_bayar' => 'failed',
                'status'       => 'rejected',
            ]);

            Notification::create([
                'user_id' => $order->user_id,
                'title'   => 'Pembayaran Ditolak',
                'message' => 'Pembayaran pesanan ' . $order->order_code .
                    ' ditolak. harap mengunggah bukti bayar yang valid.',
            ]);
        }

        return redirect()
            ->route('admin', 'orders_validation')
            ->with('account_success', 'Validasi pembayaran berhasil diproses');
    })->name('admin.orders.validation.store');
});

Route::middleware([middleware::class . ':user'])->group(function () {

    Route::get('/user/orders/{order}/delivery', function (Order $order) {

        // hanya pemilik order
        abort_if($order->user_id !== Auth::id(), 403);

        // hanya order yang sudah approved
        abort_if($order->status !== 'approved', 403);

        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->limit(20)
            ->get();

        return view('user.userpanel', [
            'module'        => 'orders_delivery_plan',
            'order'         => $order,
            'notifications' => $notifications,
        ]);
    })->name('user.orders.delivery');
});

Route::middleware([middleware::class . ':user'])->group(function () {

    Route::post('/user/orders/{order}/delivery', function (
        Request $request,
        Order $order
    ) {

        abort_if($order->user_id !== Auth::id(), 403);
        abort_if($order->status !== 'approved', 403);

        $request->validate([
            'estimated_delivery' => 'required|date|after_or_equal:today',
        ]);

        $order->update([
            'estimated_delivery' => $request->estimated_delivery,
            'status'             => 'upcoming',
        ]);

        Notification::create([
            'user_id' => Auth::id(),
            'title'   => 'Rencana Pengiriman Dibuat',
            'message' => 'Pesanan ' . $order->order_code .
                ' dijadwalkan dikirim pada ' .
                date('d M Y', strtotime($request->estimated_delivery)),
        ]);

        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title'   => 'pengiriman dijadwalkan',
                'message' => 'Pesanan ' . $order->order_code .
                    ' sudah dijadwalkan pengirimannya oleh user ' . Auth::user()->name .
                    ' dan akan tiba pada ' . date('d M Y', strtotime($request->estimated_delivery)),
            ]);
        }

        return redirect()
            ->route('user', 'make_order')
            ->with('account_success', 'Rencana pengiriman berhasil disimpan');
    })->name('user.orders.delivery.store');
});

Route::middleware([middleware::class . ':user'])->group(function () {

    Route::get('/user/orders/{order}/warehouse', function (Order $order) {

        // hanya pemilik order
        abort_if($order->user_id !== Auth::id(), 403);

        // hanya order yang valid (bebas mau approved / upcoming)
        abort_if(!in_array($order->status, ['approved', 'upcoming']), 403);

        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->limit(20)
            ->get();

        return view('user.userpanel', [
            'module'        => 'orders_warehouse',
            'order'         => $order,
            'notifications' => $notifications,
        ]);
    })->name('user.orders.warehouse');
});

Route::middleware([middleware::class . ':admin'])->group(function () {

    Route::patch('/admin/orders/{order}/arrived', function (Order $order) {

        abort_if($order->status !== 'upcoming', 403);

        $estimated = $order->estimated_delivery
            ? \Carbon\Carbon::parse($order->estimated_delivery)->startOfDay()
            : null;

        abort_if(!$estimated, 403);

        // boleh hari ini ATAU terlambat
        abort_if(now()->startOfDay()->lt($estimated), 403);

        $order->update([
            'status' => 'stored',
        ]);

        Notification::create([
            'user_id' => $order->user_id,
            'title'   => 'Barang Telah Tiba',
            'message' => 'pesanan ' . $order->order_code .
                ' telah tiba di gudang dan telah disimpan dengan aman.',
        ]);

        return back()->with(
            'account_success',
            'Barang berhasil ditandai telah tiba'
        );
    })->name('admin.orders.arrived');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::patch('/users/{user}/activate', function (\App\Models\User $user) {
        $user->update(['status' => 'active']);

        return back()->with('swal', [
            'icon'  => 'success',
            'title' => 'Berhasil',
            'text'  => 'Pengguna berhasil diaktifkan.'
        ]);
    })->name('users.activate');

    Route::patch('/users/{user}/deactivate', function (\App\Models\User $user) {
        $user->update(['status' => 'inactive']);

        return back()->with('swal', [
            'icon'  => 'success',
            'title' => 'Berhasil',
            'text'  => 'Pengguna berhasil dinonaktifkan.'
        ]);
    })->name('users.deactivate');

});

Route::get('/user/orders/{order}/detail', function (Order $order) {

    // Pastikan order milik user login
    abort_if($order->user_id !== Auth::id(), 403);

    // Detail hanya boleh untuk status STORED
    abort_unless($order->status === 'stored', 403);

    $notifications = Notification::where('user_id', Auth::id())
        ->latest()
        ->limit(20)
        ->get();

    return view('user.userpanel', [
        'module'        => 'detail',
        'order'         => $order,
        'notifications' => $notifications,

    ]);

})->name('user.orders.show');

Route::get('/user/orders/{order}/outgoing', function (Order $order) {

    // Pastikan order milik user login
    abort_if($order->user_id !== Auth::id(), 403);

    // Outgoing boleh untuk status tertentu
    abort_unless(in_array($order->status, ['stored', 'due', 'expired']), 403);

    $notifications = Notification::where('user_id', Auth::id())
        ->latest()
        ->limit(20)
        ->get();

    return view('user.userpanel', [
        'module'        => 'outgoing',
        'order'         => $order,
        'notifications' => $notifications,
    ]);

})->name('user.orders.outgoing');

Route::post('/user/orders/{order}/outgoing', function (Request $request, Order $order) {

    $request->validate([
        'estimated_arrival' => 'required|date|after_or_equal:today',
        'destination'       => 'required|string|max:255',
    ]);

    $order->update([
        'estimated_delivery' => $request->estimated_arrival,
        'destination'        => $request->destination,
        'status'             => 'outgoing',
        'status_keluar'      => 'di_gudang',
    ]);

    Notification::create([
        'user_id' => Auth::id(),
        'title'   => 'Rencana Pengiriman Dibuat',
        'message' => 'Pesanan ' . $order->order_code .
            ' dijadwalkan keluar gudang dan diperkirakan tiba pada ' .
            date('d M Y', strtotime($request->estimated_arrival)),
    ]);

    $admins = User::where('role', 'admin')->get();

    foreach ($admins as $admin) {
        Notification::create([
            'user_id' => $admin->id,
            'title'   => 'Pengiriman Dijadwalkan',
            'message' => 'Pesanan ' . $order->order_code .
                ' dijadwalkan pengirimannya oleh ' . Auth::user()->name .
                ' (' . (Auth::user()->company_name ?? '-') . ')' .
                ' dan akan tiba sekitar ' .
                date('d M Y', strtotime($request->estimated_arrival)),
        ]);
    }

    return redirect()
        ->route('user', 'orders_monitoring')
        ->with('account_success', 'Rencana pengiriman keluar berhasil disimpan.');

})->name('user.orders.outgoing.store');

Route::patch('/user/orders/{order}/complete', function (Request $request, Order $order) {

    if ($order->status_keluar !== 'keluar_gudang') {
        abort(403);
    }

    $order->update([
        'status_keluar' => null,
        'status'        => 'completed',
    ]);

    /** 🔔 NOTIFIKASI KE USER */
    Notification::create([
        'user_id' => Auth::id(),
        'title'   => 'Barang Telah Sampai',
        'message' => 'Pesanan ' . $order->order_code .
            ' berhasil dikonfirmasi telah sampai di tujuan.',
    ]);

    $admins = User::where('role', 'admin')->get();

    foreach ($admins as $admin) {
        Notification::create([
            'user_id' => $admin->id,
            'title'   => 'Pengiriman Selesai',
            'message' => 'Pesanan ' . $order->order_code .
                ' telah dikonfirmasi sampai oleh user ' .
                Auth::user()->name . '.',
        ]);
    }

    return back()->with(
        'account_success',
        'Barang berhasil divalidasi sampai.'
    );

})->name('user.orders.complete');


Route::patch('/admin/orders/{order}/outgoing', function (Request $request, Order $order) {

    if ($order->status_keluar !== 'di_gudang') {
        abort(403);
    }

    $order->update([
        'status_keluar' => 'keluar_gudang',
        'status'        => 'outgoing',
    ]);

    Notification::create([
        'user_id' => $order->user_id,
        'title'   => 'Barang Keluar Gudang',
        'message' => 'Pesanan ' . $order->order_code .
            ' telah divalidasi admin dan barang sudah keluar dari gudang.',
    ]);

    return back()->with(
        'account_success',
        'Barang berhasil divalidasi keluar gudang.'
    );

})->name('admin.orders.outgoing');

Route::get('/user/orders/{order}/renew', function (Order $order) {

    // proteksi: hanya order tertentu yang boleh renew (opsional tapi disarankan)
    if (!in_array($order->status, ['expired', 'due'])) {
        abort(403);
    }

    $notifications = Notification::where('user_id', Auth::id())
        ->latest()
        ->limit(20)
        ->get();

    return view('user.userpanel', [
        'module'        => 'renew_order',
        'order'         => $order,
        'notifications' => $notifications,
    ]);

})->name('user.orders.renew');

Route::post('/user/orders/{order}/renew', function (Request $request, Order $order) {

    // Proteksi: hanya order tertentu boleh renew
    if (!in_array($order->status, ['expired', 'due'])) {
        abort(403);
    }

    $request->validate([
        'new_storage_end_date' => 'required|date|after:' . $order->storage_end_date,
        'extend_days'          => 'required|integer|min:1',
        'renew_price'          => 'required|integer|min:1',
        'bukti_bayar'          => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $file = $request->file('bukti_bayar');
    $fileName = 'renew_' . $order->order_code . '_' . time() . '.' . $file->getClientOriginalExtension();

    // simpan ke public/bukti-bayar
    $path = $request->file('bukti_bayar')
            ->storeAs('bukti-bayar', $fileName, 'public');

    $order->update([
        'status'             => 'renewed',
        'renew_end_date'     => $request->new_storage_end_date,
        'renew_extend_days'  => $request->extend_days,
        'renew_price'        => $request->renew_price,
        'bukti_bayar'        => $fileName,
        'status_bayar'       => 'pending',
    ]);

    Notification::create([
        'user_id' => Auth::id(),
        'title'   => 'Perpanjangan Diajukan',
        'message' => 'Perpanjangan pesanan ' . $order->order_code .
            ' berhasil diajukan dan menunggu verifikasi admin.',
    ]);

    $admins = \App\Models\User::where('role', 'admin')->get();

    foreach ($admins as $admin) {
        Notification::create([
            'user_id' => $admin->id,
            'title'   => 'Pengajuan Perpanjangan',
            'message' => 'Pesanan ' . $order->order_code .
                ' mengajukan perpanjangan oleh ' . Auth::user()->name .
                ' (' . (Auth::user()->company_name ?? '-') . ').',
        ]);
    }

    return redirect()
        ->route('user', 'orders_monitoring')
        ->with('account_success', 'Perpanjangan pesanan berhasil diajukan.');

})->name('user.orders.renew.store');

Route::get('/admin/orders/{order}/renew/validation', function (Order $order) {

    // proteksi: hanya order renew
    if ($order->status !== 'renewed') {
        abort(403);
    }

    $notifications = Notification::where('user_id', Auth::id())
        ->latest()
        ->limit(20)
        ->get();

    return view('admin.adminpanel', [
        'module'        => 'validation_renew',
        'order'         => $order,
        'notifications' => $notifications,
    ]);

})->name('admin.orders.renew.validation');

Route::post('/admin/orders/{order}/renew/validation', function (Request $request, Order $order) {

    // Proteksi: hanya order renew
    if ($order->status !== 'renewed') {
        abort(403);
    }

    $action = $request->input('action');

    if ($order->bukti_bayar && Storage::disk('public')->exists('bukti-bayar/' . $order->bukti_bayar)) {
        Storage::disk('public')->delete('bukti-bayar/' . $order->bukti_bayar);
    }

    if ($action === 'approve') {

        $order->update([
            // gabungkan data renew
            'storage_end_date'   => $order->renew_end_date,
            'storage_duration'  => $order->storage_duration + $order->renew_extend_days,
            'price'              => $order->price + $order->renew_price,

            // reset renew
            'renew_end_date'     => null,
            'renew_extend_days'  => null,
            'renew_price'        => null,
            'bukti_bayar'        => null,

            // status
            'status'             => 'stored',
            'status_bayar'       => 'lunas',
        ]);

        /* 🔔 NOTIFIKASI KE USER */
        Notification::create([
            'user_id' => $order->user_id,
            'title'   => 'Perpanjangan Disetujui',
            'message' => 'Perpanjangan pesanan ' . $order->order_code .
                ' telah disetujui. Masa penyimpanan diperpanjang hingga ' .
                Carbon::parse($order->storage_end_date)
                    ->locale('id')
                    ->isoFormat('D MMMM YYYY') . '.',
        ]);

        return redirect()
            ->route('admin', 'renew_request')
            ->with('account_success', 'Perpanjangan pesanan berhasil disetujui.');
    }

    if ($action === 'reject') {

        // hitung sisa hari dari storage lama
        $endDate = Carbon::parse($order->storage_end_date)->startOfDay();
        $diffDays = now()->startOfDay()->diffInDays($endDate, false);

        $status = match (true) {
            $diffDays < 0      => 'expired',
            $diffDays <= 7     => 'due',
            default            => 'stored',
        };

        $order->update([
            // reset renew
            'renew_end_date'     => null,
            'renew_extend_days'  => null,
            'renew_price'        => null,
            'bukti_bayar'        => null,

            // status kembali
            'status'             => $status,
            'status_bayar'       => 'gagal',
        ]);

        /* 🔔 NOTIFIKASI KE USER */
        Notification::create([
            'user_id' => $order->user_id,
            'title'   => 'Perpanjangan Ditolak',
            'message' => 'Pengajuan perpanjangan pesanan ' . $order->order_code .
                ' ditolak oleh admin. Status pesanan dikembalikan menjadi ' .
                strtoupper($status) . '.',
        ]);

        return redirect()
            ->route('admin', 'renew_request')
            ->with('account_success', 'Perpanjangan pesanan ditolak.');
    }

    abort(400);

})->name('admin.orders.renew.validation.store');
