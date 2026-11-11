@extends('layouts.admin')

@section('title', $modo . ' Producto — Panel de Administración')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
  <div>
    <h1 style="font-size: 26px; color: #173e4b; margin-bottom: 4px;">{{ $modo }} Producto</h1>
    <p style="font-size: 13px; color: var(--muted);">Completa la información del producto para el catálogo de agua.</p>
  </div>
  <a href="{{ route('admin.products.index') }}" class="btn-ghost btn-sm">
    ← Volver al listado
  </a>
</div>

@if($errors->any())
  <div style="background: #fff1f1; border: 1px solid #ffd0d0; color: #9e1c1c; padding: 14px 18px; border-radius: 12px; font-size: 13px; margin-bottom: 24px;">
    <strong>Corrige los siguientes errores:</strong>
    <ul style="margin-top: 6px; padding-left: 18px;">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="admin-card">
  <form action="{{ $action }}" method="POST" enctype="multipart/form-data" style="display: grid; gap: 20px;">
    @csrf
    @if($method === 'PUT')
      @method('PUT')
    @endif

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 18px;">
      <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
        Nombre del producto <span style="color:#e53e3e;">*</span>
        <input type="text" name="nombre" value="{{ old('nombre', $product->nombre) }}" required
               placeholder="Ej: Garrafón Retornable Ciel Agua Purificada 20 L"
               style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
      </label>

      <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
        Marca <span style="color:#e53e3e;">*</span>
        <input type="text" name="marca" value="{{ old('marca', $product->marca) }}" required
               placeholder="Ej: Ciel, Cristal, Topo Chico"
               style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
      </label>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px;">
      <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
        Categoría <span style="color:#e53e3e;">*</span>
        <input type="text" name="categoria" value="{{ old('categoria', $product->categoria ?? 'Agua') }}" required
               style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
      </label>

      <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
        Presentación <span style="color:#e53e3e;">*</span>
        <input type="text" name="presentacion" value="{{ old('presentacion', $product->presentacion ?? '1 Botella') }}" required
               placeholder="Ej: 1 Pieza, 1 Botella, 4 Bidones"
               style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
      </label>

      <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
        Unidad / Texto de precio
        <input type="text" name="unidad" value="{{ old('unidad', $product->unidad ?? 'Desde') }}"
               placeholder="Ej: Desde, Paquete, Caja"
               style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
      </label>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px;">
      <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
        Precio ($ MXN) <span style="color:#e53e3e;">*</span>
        <input type="number" step="0.01" min="0.01" name="precio" value="{{ old('precio', $product->precio) }}" required
               placeholder="0.00"
               style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 15px; font-weight: 600; outline: none;">
      </label>

      <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
        Etiqueta destacada (Opcional)
        <input type="text" name="etiqueta" value="{{ old('etiqueta', $product->etiqueta) }}"
               placeholder="Ej: Topo Chico, Exclusivo"
               style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
      </label>
    </div>

    <!-- Imagen -->
    <div style="background: var(--light); border: 1px solid var(--border); border-radius: 12px; padding: 20px;">
      <label style="display: flex; flex-direction: column; gap: 8px; font-size: 13px; font-weight: 600; color: #214b58;">
        Subir nueva imagen (JPG, PNG, WEBP o SVG, máx 3MB)
        <input type="file" name="imagen_file" accept="image/*"
               style="font-size: 13px;">
      </label>
      @if($product->imagen)
        <div style="display: flex; align-items: center; gap: 12px; margin-top: 14px;">
          <img src="{{ $product->imagen_url }}" alt="" width="56" height="56"
               style="object-fit: contain; background: #fff; border-radius: 8px; padding: 6px; border: 1px solid var(--border);">
          <span style="font-size: 12px; color: var(--muted);">Imagen actual: <code>{{ $product->imagen }}</code></span>
        </div>
      @endif
    </div>

    <!-- Opciones booleanas -->
    <div style="display: flex; gap: 30px; padding: 6px 0;">
      <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; color: #214b58; cursor: pointer;">
        <input type="checkbox" name="retornable" value="1" {{ old('retornable', $product->retornable) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--blue);">
        Es producto retornable (Solo líquido)
      </label>

      <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; color: #214b58; cursor: pointer;">
        <input type="checkbox" name="activo" value="1" {{ old('activo', $product->activo ?? true) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--blue);">
        Producto activo / visible en el catálogo
      </label>
    </div>

    <div style="display: flex; gap: 14px; margin-top: 10px;">
      <button type="submit" class="btn-primary" style="height: 46px; padding: 0 28px; font-size: 15px;">
        {{ $modo === 'Editar' ? 'Actualizar Producto' : 'Guardar Producto' }}
      </button>
      <a href="{{ route('admin.products.index') }}" class="btn-ghost" style="display: inline-flex; align-items: center;">
        Cancelar
      </a>
    </div>

  </form>
</div>
@endsection

