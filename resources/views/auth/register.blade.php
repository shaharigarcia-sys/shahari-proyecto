@extends('layouts.app')

@section('title', 'Crear cuenta — En tu hogar')

@section('content')
<div class="topbar">
  <span>🫧</span> Registro de clientes · <strong>En tu hogar</strong>
</div>

<main style="min-height: calc(100vh - 120px); display: flex; align-items: center; justify-content: center; padding: 40px 20px;">
  <div style="width: 100%; max-width: 680px; background: #fff; border: 1px solid var(--border); border-radius: 20px; padding: 36px 32px; box-shadow: var(--shadow-md);">
    
    <div style="text-align: center; margin-bottom: 24px;">
      <a class="logo" href="{{ route('home') }}" style="justify-content: center; margin-bottom: 12px;">
        <span class="logo-a">en tu</span><span class="logo-b">hogar</span>
        <small>por Coca-Cola</small>
      </a>
      <h1 style="font-size: 24px; color: var(--text); margin-bottom: 6px;">Crear cuenta de cliente</h1>
      <p style="font-size: 13px; color: var(--muted);">Regístrate para solicitar agua purificada directo a tu domicilio</p>
    </div>

    @if($errors->any())
      <div style="background: #fff1f1; border: 1px solid #ffd0d0; color: #9e1c1c; padding: 12px 14px; border-radius: 10px; font-size: 13px; margin-bottom: 20px;">
        <ul style="margin: 0; padding-left: 18px;">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST" style="display: grid; gap: 16px;">
      @csrf

      <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px;">
        <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
          Nombre completo *
          <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ej. Juan Pérez"
                 style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
        </label>

        <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
          Edad *
          <input type="number" name="edad" min="1" max="120" value="{{ old('edad') }}" required placeholder="Ej. 28"
                 style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
        </label>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
          Correo electrónico *
          <input type="email" name="email" value="{{ old('email') }}" required placeholder="ejemplo@correo.com"
                 style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
        </label>

        <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
          Teléfono móvil (10 dígitos) *
          <input type="tel" name="telefono" maxlength="10" value="{{ old('telefono') }}" required placeholder="5512345678"
                 style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
        </label>
      </div>

      <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
        Dirección de entrega completa *
        <textarea name="direccion" rows="2" required placeholder="Calle, número ext/int, colonia, municipio y código postal..."
                  style="border: 1.5px solid var(--border); border-radius: 10px; padding: 10px 14px; font-size: 14px; outline: none; font-family: inherit;">{{ old('direccion') }}</textarea>
      </label>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
          Contraseña *
          <input type="password" name="password" minlength="6" required placeholder="Mínimo 6 caracteres"
                 style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
        </label>

        <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
          Confirmar contraseña *
          <input type="password" name="password_confirmation" minlength="6" required placeholder="Repite tu contraseña"
                 style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
        </label>
      </div>

      <button type="submit" class="btn-primary" style="width: 100%; height: 46px; font-size: 15px; margin-top: 10px;">
        Registrarme y comenzar a comprar
      </button>
    </form>

    <div style="margin-top: 20px; text-align: center; font-size: 13px; color: var(--muted);">
      ¿Ya tienes una cuenta? <a href="{{ route('login') }}" style="color: var(--blue); font-weight: 600;">Inicia sesión aquí</a>
    </div>

  </div>
</main>
@endsection

