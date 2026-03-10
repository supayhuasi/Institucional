<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    @php
        $authLogoPath = \App\Models\SiteSetting::getValue('logo_path');
        $authSiteName = \App\Models\SiteSetting::getValue('site_name') ?? 'Sitio institucional';
    @endphp
    <style>
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; font-family: Arial, sans-serif; background: radial-gradient(circle at top, #E2E8F0 0%, #F3F4F6 48%, #F8FAFC 100%); }
        .card { width: min(420px, 92%); background: #fff; border: 1px solid #E5E7EB; border-radius: 12px; padding: 22px; box-shadow: 0 14px 28px rgba(15, 23, 42, 0.12); }
        .brand { text-align: center; margin-bottom: 12px; }
        .brand img { max-height: 64px; width: auto; max-width: 100%; display: inline-block; object-fit: contain; }
        .brand strong { font-size: 18px; color: #111827; }
        h1 { margin: 0 0 14px; text-align: center; color: #0F172A; }
        label { display: block; margin-top: 10px; margin-bottom: 5px; font-weight: 600; font-size: 14px; }
        input { width: 100%; border: 1px solid #D1D5DB; border-radius: 8px; padding: 10px; box-sizing: border-box; }
        button { width: 100%; margin-top: 14px; padding: 10px; border: 0; border-radius: 999px; background: #111827; color: #fff; cursor: pointer; font-weight: 700; transition: transform .2s ease, opacity .2s ease; }
        button:hover { transform: translateY(-1px); opacity: .95; }
        .msg { margin-top: 10px; padding: 10px; border-radius: 8px; font-size: 14px; }
        .ok { background: #DCFCE7; border: 1px solid #86EFAC; color: #166534; }
        .err { background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; }
        .back { margin-top: 12px; display: block; text-align: center; color: #374151; text-decoration: none; font-weight: 600; }
        @media (max-width: 640px) {
            body { display: block; padding: 14px 0; }
            .card { width: min(420px, 96%); padding: 16px; margin: 0 auto; }
            h1 { font-size: 24px; text-align: center; }
            button { padding: 11px; }
        }
    </style>
</head>
<body>
<div class="card">
    <div class="brand">
        @if(!empty($authLogoPath))
            <img src="{{ asset('storage/' . $authLogoPath) }}" alt="Logo">
        @else
            <strong>{{ $authSiteName }}</strong>
        @endif
    </div>
    <h1>Recuperar contraseña</h1>

    @if(session('status'))
        <div class="msg ok">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="msg err">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <label for="email">Email</label>
        <input id="email" name="email" type="email" required value="{{ old('email') }}">
        <button type="submit">Enviar link de recuperación</button>
    </form>

    <a class="back" href="{{ route('login') }}">Volver al login</a>
</div>
</body>
</html>
