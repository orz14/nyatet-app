@extends('mail.layout.index')
@section('content')
    <h1 style="color: #f9fafb; font-size: 18px; font-weight: bold; margin-bottom: 0.5rem">Halo!
    </h1>
    <span style="color: #f9fafb">Anda menerima email ini karena kami menerima permintaan
        pengaturan ulang kata sandi untuk akun Anda.</span>
    <br />
    <div style="margin-top: 1.5rem; text-align: center">
        <a href="{{ $reset_url }}"
            style="padding: 7px 14px; font-size: 14px; background-color: #4f46e5; color: #fff; border: none; border-radius: 5px; cursor: pointer; text-decoration: none"
            target="_blank">Reset Password</a>
    </div>
    <br />
    <span style="color: #f9fafb">Tautan pengaturan ulang kata sandi ini akan kedaluwarsa dalam
        60 menit.</span>
    <br />
    <span style="color: #f9fafb">Jika Anda tidak meminta pengaturan ulang kata sandi, tidak
        diperlukan tindakan lebih lanjut.</span>
    <br /><br />
    <span style="color: #f9fafb">Salam,</span>
    <br />
    <span style="color: #f9fafb">{{ config('app.name') }}</span>
    <div style="width: 100%; height: 1px; background-color: #111827; margin: 1rem 0"></div>
    <span style="color: #f9fafb; font-size: 14px">
        Jika Anda mengalami masalah saat mengklik tombol "Reset Password", salin dan tempel URL
        di bawah ini ke browser web Anda: <a href="{{ $reset_url }}" target="_blank"
            style="color: #818cf8">{{ $reset_url }}</a>
    </span>
@endsection
