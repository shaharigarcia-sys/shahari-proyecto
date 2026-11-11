@extends('layouts.admin')

@section('title', 'CMS de Portada (Hero y Secciones) — Panel de Administración')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px;">
  <div>
    <h1 style="font-size: 26px; color: #173e4b; margin-bottom: 4px;">CMS de Portada</h1>
    <p style="font-size: 13px; color: var(--muted);">Modifica los textos, llamadas a la acción y secciones sin tocar código.</p>
  </div>
  <form action="{{ route('admin.settings.restore') }}" method="POST" onsubmit="return confirm('¿Restaurar los textos originales del sitio?');">
    @csrf
    <button type="submit" class="btn-ghost btn-sm" style="color: #9e1c1c; border-color: #ffd0d0;">
      ↺ Restaurar textos originales
    </button>
  </form>
</div>

@if($errors->any())
  <div style="background: #fff1f1; border: 1px solid #ffd0d0; color: #9e1c1c; padding: 14px 18px; border-radius: 12px; font-size: 13px; margin-bottom: 24px;">
    <strong>Por favor corrige los siguientes errores:</strong>
    <ul style="margin-top: 6px; padding-left: 18px;">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST">
  @csrf
  @method('PUT')

  <!-- 1. Sección Hero -->
  <div class="admin-card">
    <h2 style="font-size: 18px; color: var(--blue-dark); margin-bottom: 6px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">
      1. Sección Hero Principal (Portada)
    </h2>
    <p style="font-size: 12px; color: var(--muted); margin-bottom: 20px;">
      Es la primera sección visible para los visitantes. Puedes usar <code>&lt;em&gt;palabra&lt;/em&gt;</code> en el título para darle el color azul destacado.
    </p>

    <div style="display: grid; gap: 16px;">
      <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
        Etiqueta superior (Tag pill)
        <input type="text" name="hero_tag" value="{{ old('hero_tag', $settings['hero_tag'] ?? '') }}"
               placeholder="Ej: 🫧 Agua pura garantizada"
               style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
      </label>

      <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
        Título principal del Hero (H1) <span style="color: #e53e3e;">*</span>
        <textarea name="hero_title" rows="3" required
                  placeholder="El agua que necesitas, en tu hogar"
                  style="border: 1.5px solid var(--border); border-radius: 10px; padding: 12px 14px; font-size: 15px; outline: none; font-family: inherit;">{{ old('hero_title', $settings['hero_title'] ?? '') }}</textarea>
        <small style="font-weight: 400; color: var(--muted); font-size: 11px;">
          Consejo: usa saltos de línea para que se ajuste estéticamente. Soporta etiquetas simples como &lt;em&gt;
        </small>
      </label>

      <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
        Descripción o subtítulo
        <textarea name="hero_subtitle" rows="3"
                  style="border: 1.5px solid var(--border); border-radius: 10px; padding: 12px 14px; font-size: 14px; outline: none; font-family: inherit;">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea>
      </label>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
          Texto del Botón Principal
          <input type="text" name="hero_btn_text" value="{{ old('hero_btn_text', $settings['hero_btn_text'] ?? '') }}"
                 style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
        </label>

        <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
          Enlace del Botón Principal
          <input type="text" name="hero_btn_link" value="{{ old('hero_btn_link', $settings['hero_btn_link'] ?? '#catalogo') }}"
                 style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
        </label>
      </div>
    </div>
  </div>

  <!-- 2. Barra Superior (Topbar) -->
  <div class="admin-card">
    <h2 style="font-size: 18px; color: var(--blue-dark); margin-bottom: 6px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">
      2. Mensajes de Barra Superior (Topbar)
    </h2>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
      <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
        Texto de entrega
        <input type="text" name="topbar_text" value="{{ old('topbar_text', $settings['topbar_text'] ?? '') }}"
               style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
      </label>

      <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
        Mensaje destacado (Negrita)
        <input type="text" name="topbar_highlight" value="{{ old('topbar_highlight', $settings['topbar_highlight'] ?? '') }}"
               style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
      </label>
    </div>
  </div>

  <!-- 3. Sección Informativa -->
  <div class="admin-card">
    <h2 style="font-size: 18px; color: var(--blue-dark); margin-bottom: 6px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">
      3. Tarjetas Informativas (¿Por qué elegirnos?)
    </h2>

    <div style="display: grid; gap: 16px; margin-bottom: 16px;">
      <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
        Título de la sección
        <input type="text" name="info_title" value="{{ old('info_title', $settings['info_title'] ?? '') }}"
               style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
      </label>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 18px;">
      <div style="background: var(--light); border: 1px solid var(--border); border-radius: 12px; padding: 16px;">
        <h4 style="font-size: 13px; color: var(--blue-dark); margin-bottom: 10px;">Tarjeta 1 (Retornables)</h4>
        <input type="text" name="info_card1_title" value="{{ old('info_card1_title', $settings['info_card1_title'] ?? '') }}"
               style="width: 100%; height: 38px; border: 1.5px solid var(--border); border-radius: 8px; padding: 0 10px; font-size: 13px; margin-bottom: 8px;">
        <textarea name="info_card1_desc" rows="3"
                  style="width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 8px 10px; font-size: 12px; font-family: inherit;">{{ old('info_card1_desc', $settings['info_card1_desc'] ?? '') }}</textarea>
      </div>

      <div style="background: var(--light); border: 1px solid var(--border); border-radius: 12px; padding: 16px;">
        <h4 style="font-size: 13px; color: var(--blue-dark); margin-bottom: 10px;">Tarjeta 2 (Entrega)</h4>
        <input type="text" name="info_card2_title" value="{{ old('info_card2_title', $settings['info_card2_title'] ?? '') }}"
               style="width: 100%; height: 38px; border: 1.5px solid var(--border); border-radius: 8px; padding: 0 10px; font-size: 13px; margin-bottom: 8px;">
        <textarea name="info_card2_desc" rows="3"
                  style="width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 8px 10px; font-size: 12px; font-family: inherit;">{{ old('info_card2_desc', $settings['info_card2_desc'] ?? '') }}</textarea>
      </div>

      <div style="background: var(--light); border: 1px solid var(--border); border-radius: 12px; padding: 16px;">
        <h4 style="font-size: 13px; color: var(--blue-dark); margin-bottom: 10px;">Tarjeta 3 (Pureza)</h4>
        <input type="text" name="info_card3_title" value="{{ old('info_card3_title', $settings['info_card3_title'] ?? '') }}"
               style="width: 100%; height: 38px; border: 1.5px solid var(--border); border-radius: 8px; padding: 0 10px; font-size: 13px; margin-bottom: 8px;">
        <textarea name="info_card3_desc" rows="3"
                  style="width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 8px 10px; font-size: 12px; font-family: inherit;">{{ old('info_card3_desc', $settings['info_card3_desc'] ?? '') }}</textarea>
      </div>
    </div>
  </div>

  <!-- 4. Contacto y Atención -->
  <div class="admin-card">
    <h2 style="font-size: 18px; color: var(--blue-dark); margin-bottom: 6px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">
      4. Sección de Contacto
    </h2>

    <div style="display: grid; gap: 16px;">
      <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
        Título de llamada
        <input type="text" name="contact_title" value="{{ old('contact_title', $settings['contact_title'] ?? '') }}"
               style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
      </label>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
          Horarios y descripción
          <textarea name="contact_desc" rows="2"
                    style="border: 1.5px solid var(--border); border-radius: 10px; padding: 10px 14px; font-size: 13px; outline: none; font-family: inherit;">{{ old('contact_desc', $settings['contact_desc'] ?? '') }}</textarea>
        </label>

        <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
          Teléfono de atención
          <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}"
                 style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
        </label>
      </div>
    </div>
  </div>

  <div style="display: flex; gap: 14px; margin-top: 10px;">
    <button type="submit" class="btn-primary" style="height: 48px; padding: 0 28px; font-size: 16px;">
      💾 Guardar todos los cambios
    </button>
    <a href="{{ route('home') }}" target="_blank" class="btn-ghost" style="display: inline-flex; align-items: center; gap: 6px;">
      Ver resultado en la web ↗
    </a>
  </div>
</form>
@endsection

