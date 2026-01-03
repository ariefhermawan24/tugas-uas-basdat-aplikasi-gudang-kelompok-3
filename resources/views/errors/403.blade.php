@extends('layouts.error')

@section('title', '403 Forbidden')

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #020617, #0f172a);
        font-family: system-ui, sans-serif;
    }

    .error-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }

    .error-card {
        background: rgba(2, 6, 23, 0.95);
        border-radius: 20px;
        padding: 42px 34px;
        width: 100%;
        max-width: 420px;
        text-align: center;
        box-shadow: 0 30px 80px rgba(0,0,0,.55);
        border: 1px solid rgba(255,255,255,.06);
    }

    .error-code {
        font-size: clamp(72px, 12vw, 96px);
        font-weight: 800;
        color: #38bdf8;
        margin-bottom: 12px;
    }

    .error-message {
        font-size: 14px;
        color: #94a3b8;
        margin-bottom: 28px;
        line-height: 1.6;
    }

    .actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: .25s;
    }

    .btn-primary {
        background: #38bdf8;
        color: #020617;
    }

    .btn-secondary {
        border: 1px solid rgba(255,255,255,.15);
        color: #e5e7eb;
    }

    .btn-primary:hover {
        background: #0ea5e9;
    }

    .btn-secondary:hover {
        background: rgba(255,255,255,.06);
    }
</style>
@endpush

@section('content')
<div class="error-wrapper">
    <div class="error-card">
        <div class="error-code">403</div>

        <div class="error-message">
            {{ __($exception->getMessage() ?: 'Anda tidak memiliki akses ke halaman ini') }}
        </div>

        <div class="actions">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
        </div>
    </div>
</div>
@endsection
