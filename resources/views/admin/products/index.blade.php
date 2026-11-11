@extends('layouts.admin')

@section('title', 'Catálogo de Productos — Panel de Administración')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
  <div>
    <h1 style="font-size: 26px; color: #173e4b; margin-bottom: 4px;">Catálogo de Productos</h1>
    <p style="font-size: 13px; color: var(--muted);">Gestiona los productos disponibles para los clientes en la tienda.</p>
  </div>
  <a href="{{ route('admin.products.create') }}" class="btn-primary">
    + Agregar Producto
  </a>
</div>

<div class="admin-card">
  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th>Imagen</th>
          <th>Nombre</th>
          <th>Marca</th>
          <th>Presentación</th>
          <th>Precio</th>
          <th>Retornable</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($products as $p)
          <tr>
            <td>
              <img src="{{ $p->imagen_url }}" alt="" width="48" height="48"
                   style="object-fit: contain; background: var(--light); border-radius: 8px; padding: 4px; border: 1px solid var(--border);">
            </td>
            <td>
              <strong>{{ $p->nombre }}</strong>
              @if($p->etiqueta)
                <span style="display:block; font-size:10px; color:var(--blue); font-weight:700;">Etiqueta: {{ $p->etiqueta }}</span>
              @endif
            </td>
            <td>{{ $p->marca }}</td>
            <td>{{ $p->presentacion }} ({{ $p->unidad }})</td>
            <td style="font-weight: 700; color: var(--blue); font-size: 15px;">
              ${{ number_format($p->precio, 2) }}
            </td>
            <td>
              @if($p->retornable)
                <span class="badge-success">♻️ Retornable</span>
              @else
                <span class="badge-secondary">No</span>
              @endif
            </td>
            <td>
              @if($p->activo)
                <span style="color: #156d35; font-weight:600; font-size:12px;">● Activo</span>
              @else
                <span style="color: #9e1c1c; font-weight:600; font-size:12px;">○ Oculto</span>
              @endif
            </td>
            <td>
              <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.products.edit', $p) }}" class="btn-ghost btn-sm" style="padding: 4px 10px; font-size: 12px;">
                  Editar
                </a>
                <form action="{{ route('admin.products.destroy', $p) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-ghost btn-sm" style="padding: 4px 10px; font-size: 12px; color: #a40000; border-color: #ffd0d0;">
                    Eliminar
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" style="text-align: center; padding: 40px; color: var(--muted);">
              No hay productos registrados actualmente.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top: 20px;">
    {{ $products->links() }}
  </div>
</div>
@endsection

