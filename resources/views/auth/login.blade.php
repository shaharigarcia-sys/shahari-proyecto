@extends('layouts.app')

@section('title', 'Iniciar sesión — En tu hogar')

@section('content')
<div class="topbar">
  <span>🫧</span> Acceso a la plataforma · <strong>En tu hogar</strong>
</div>

<main style="min-height: calc(100vh - 120px); display: flex; align-items: center; justify-content: center; padding: 40px 20px;">
  <div style="width: 100%; max-width: 440px; background: #fff; border: 1px solid var(--border); border-radius: 20px; padding: 40px 32px; box-shadow: var(--shadow-md);">
    
    <div style="text-align: center; margin-bottom: 24px;">
      <a class="logo" href="{{ route('home') }}" style="justify-content: center; margin-bottom: 12px;">
        <span class="logo-a">en tu</span><span class="logo-b">hogar</span>
        <small>por Coca-Cola</small>
      </a>
      <h1 style="font-size: 24px; color: var(--text); margin-bottom: 6px;">Iniciar sesión</h1>
      <p style="font-size: 13px; color: var(--muted);">Ingresa a tu cuenta para continuar</p>
    </div>

    @if(session('error'))
      <div style="background: #fff1f1; border: 1px solid #ffd0d0; color: #9e1c1c; padding: 12px 14px; border-radius: 10px; font-size: 13px; margin-bottom: 20px;">
        {{ session('error') }}
      </div>
    @endif

    @if($errors->any())
      <div style="background: #fff1f1; border: 1px solid #ffd0d0; color: #9e1c1c; padding: 12px 14px; border-radius: 10px; font-size: 13px; margin-bottom: 20px;">
        @foreach($errors->all() as $err)
          <div>{{ $err }}</div>
        @endforeach
      </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST" style="display: grid; gap: 18px;">
      @csrf

      <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
        Correo electrónico
        <input type="email" name="email" value="{{ old('email', 'admin@tienda.com') }}" required autofocus
               style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
      </label>

      <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
        Contraseña
        <input type="password" name="password" required value="Admin123!"
               style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
      </label>

      <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--muted); cursor: pointer;">
        <input type="checkbox" name="remember" value="1" checked style="accent-color: var(--blue);">
        Recordar mi sesión
      </label>

      <button type="submit" class="btn-primary" style="width: 100%; height: 46px; font-size: 15px; margin-top: 6px;">
        Ingresar al sistema
      </button>
    </form>

    <div style="margin-top: 24px; padding-top: 18px; border-top: 1px solid var(--border); text-align: center; font-size: 12px; color: var(--muted); line-height: 1.6;">
      <strong>Credenciales del Administrador escolar:</strong><br>
      Correo: <code>admin@tienda.com</code><br>
      Contraseña: <code>Admin123!</code>
    </div>

    <div style="margin-top: 18px; text-align: center; font-size: 13px; color: var(--muted);">
      ¿No tienes cuenta? <a href="{{ route('register') }}" style="color: var(--blue); font-weight: 600;">Regístrate como cliente</a>
    </div>

    <div style="margin-top: 14px; text-align: center;">
      <a href="{{ route('home') }}" style="font-size: 13px; color: var(--blue); font-weight: 600; text-decoration: none;">
        ← Regresar al catálogo
      </a>
    </div>

  </div>
</main>
@endsection

