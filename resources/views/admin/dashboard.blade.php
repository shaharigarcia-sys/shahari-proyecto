@extends('layouts.admin')

@section('title', 'Dashboard — Panel de Administración')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
  <div>
    <h1 style="font-size: 26px; color: #173e4b; margin-bottom: 4px;">Panel de Control</h1>
    <p style="font-size: 13px; color: var(--muted);">Bienvenido a la administración de En tu hogar</p>
  </div>
  <div style="display:flex; gap: 10px;">
    <a href="{{ route('admin.settings.edit') }}" class="btn-ghost btn-sm">Editar Portada</a>
    <a href="{{ route('admin.products.create') }}" class="btn-primary btn-sm">+ Nuevo Producto</a>
  </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 18px; margin-bottom: 28px;">
  <div class="admin-card" style="margin-bottom: 0;">
    <div style="font-size: 12px; color: var(--muted); font-weight: 600; text-transform: uppercase;">Total Productos</div>
    <div style="font-size: 32px; font-weight: 700; color: var(--blue); margin-top: 6px;">{{ $stats['total_products'] }}</div>
    <div style="font-size: 11px; color: #236b5b; margin-top: 4px;">{{ $stats['active_products'] }} disponibles en catálogo</div>
  </div>

  <div class="admin-card" style="margin-bottom: 0;">
    <div style="font-size: 12px; color: var(--muted); font-weight: 600; text-transform: uppercase;">Retornables</div>
    <div style="font-size: 32px; font-weight: 700; color: #104b61; margin-top: 6px;">{{ $stats['retornables'] }}</div>
    <div style="font-size: 11px; color: var(--muted); margin-top: 4px;">Con modalidad ecológica</div>
  </div>

  <div class="admin-card" style="margin-bottom: 0;">
    <div style="font-size: 12px; color: var(--muted); font-weight: 600; text-transform: uppercase;">Hero Configurado</div>
    <div style="font-size: 18px; font-weight: 700; color: var(--text); margin-top: 8px; line-height: 1.2;">
      {{ Str::limit(strip_tags($settings['hero_title'] ?? 'El agua que necesitas'), 25) }}
    </div>
    <div style="font-size: 11px; color: var(--blue); margin-top: 6px;"><a href="{{ route('admin.settings.edit') }}">Modificar textos →</a></div>
  </div>
</div>

<div class="admin-card">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
    <h2 style="font-size: 18px; color: #173e4b;">Últimos Productos Registrados</h2>
    <a href="{{ route('admin.products.index') }}" style="font-size: 13px; color: var(--blue); font-weight: 600;">Ver todos ({{ $stats['total_products'] }}) →</a>
  </div>

  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th>Imagen</th>
          <th>Nombre</th>
          <th>Marca</th>
          <th>Precio</th>
          <th>Presentación</th>
          <th>Retornable</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        @foreach($latestProducts as $p)
          <tr>
            <td>
              <img src="{{ $p->imagen_url }}" alt="" width="40" height="40" style="object-fit: contain; background: var(--light); border-radius: 8px; padding: 4px;">
            </td>
            <td><strong>{{ $p->nombre }}</strong></td>
            <td>{{ $p->marca }}</td>
            <td style="font-weight: 700; color: var(--blue);">${{ number_format($p->precio, 2) }}</td>
            <td>{{ $p->presentacion }}</td>
            <td>
              @if($p->retornable)
                <span class="badge-success">Sí</span>
              @else
                <span class="badge-secondary">No</span>
              @endif
            </td>
            <td>
              <a href="{{ route('admin.products.edit', $p) }}" class="btn-ghost btn-sm" style="padding: 4px 10px; font-size: 12px;">Editar</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

