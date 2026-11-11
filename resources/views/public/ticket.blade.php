@extends('layouts.app')

@section('title', 'Ticket de Pedido #' . $order->id . ' — En tu hogar')

@section('content')
<div class="topbar">
  <span>🧾</span> Comprobante Oficial de Compra · <strong>En tu hogar</strong>
</div>

<main class="container" style="padding: 40px 22px 80px; max-width: 720px;">
  
  <div style="background: #fff; border: 1px solid var(--border); border-radius: 20px; padding: 36px 32px; box-shadow: var(--shadow-md);" id="ticketPrintArea">
    
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px dashed #c6e4e7; padding-bottom: 20px; margin-bottom: 24px;">
      <div>
        <a class="logo" href="{{ route('home') }}" style="margin-bottom: 4px;">
          <span class="logo-a">en tu</span><span class="logo-b">hogar</span>
          <small>por Coca-Cola</small>
        </a>
        <div style="font-size: 12px; color: var(--muted); margin-top: 4px;">Agua purificada y mineral a domicilio</div>
      </div>
      <div style="text-align: right;">
        <div style="font-size: 11px; text-transform: uppercase; color: var(--muted); letter-spacing: 1px; font-weight: 700;">Ticket de compra</div>
        <div style="font-size: 22px; font-weight: 700; color: var(--blue);">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
      </div>
    </div>

    <div style="background: #eafff2; border: 1px solid #b7f0c8; color: #156d35; padding: 14px 18px; border-radius: 12px; font-size: 14px; font-weight: 600; margin-bottom: 24px; text-align: center;">
      🎉 ¡Tu pedido ha sido registrado con éxito! Nuestro repartidor está en camino.
    </div>

    <!-- Metadatos del pedido -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px; font-size: 13px;">
      <div>
        <span style="color: var(--muted); display: block; margin-bottom: 4px;">Datos del cliente:</span>
        <strong style="color: var(--text);">{{ $order->cliente_nombre }}</strong>
        <div style="color: var(--muted);">{{ $order->cliente_correo }}</div>
        <div style="color: var(--muted);">Tel: {{ $order->cliente_telefono }}</div>
      </div>
      <div>
        <span style="color: var(--muted); display: block; margin-bottom: 4px;">Dirección de entrega:</span>
        <strong style="color: var(--text);">{{ $order->direccion_entrega }}</strong>
        <div style="color: var(--muted); margin-top: 4px;">Fecha: {{ $order->created_at->format('d/m/Y H:i') }}</div>
      </div>
    </div>

    <!-- Detalles del pedido -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 24px; font-size: 13px;">
      <thead>
        <tr style="border-bottom: 1.5px solid var(--border); color: var(--blue-dark); text-align: left;">
          <th style="padding: 10px 0;">Producto</th>
          <th style="padding: 10px 0; text-align: center;">Cant.</th>
          <th style="padding: 10px 0; text-align: right;">Precio</th>
          <th style="padding: 10px 0; text-align: right;">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->details as $d)
          <tr style="border-bottom: 1px solid #eef5f7;">
            <td style="padding: 12px 0;"><strong>{{ $d->nombre_producto }}</strong></td>
            <td style="padding: 12px 0; text-align: center;">{{ $d->cantidad }}</td>
            <td style="padding: 12px 0; text-align: right;">${{ number_format($d->precio, 2) }}</td>
            <td style="padding: 12px 0; text-align: right; font-weight: 600; color: var(--text);">${{ number_format($d->subtotal, 2) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <!-- Totales -->
    <div style="border-top: 2px dashed #c6e4e7; padding-top: 16px; margin-bottom: 28px;">
      <div style="display: flex; justify-content: space-between; font-size: 13px; color: var(--muted); margin-bottom: 6px;">
        <span>Envío a domicilio</span>
        <span style="color: #236b5b; font-weight: 600;">Gratis</span>
      </div>
      <div style="display: flex; justify-content: space-between; font-size: 20px; font-weight: 700; color: #173e4b; margin-top: 10px;">
        <span>Total Pagado:</span>
        <span style="color: var(--blue);">${{ number_format($order->total, 2) }} MXN</span>
      </div>
    </div>

    <!-- Botones de acción -->
    <div style="display: flex; gap: 14px; justify-content: center;" class="no-print">
      <button onclick="window.print()" class="btn-primary" style="padding: 10px 22px;">
        🖨️ Imprimir Comprobante
      </button>
      <a href="{{ route('home') }}" class="btn-ghost" style="padding: 10px 22px;">
        ← Seguir Comprando
      </a>
    </div>

  </div>
</main>
@endsection

@push('styles')
<style>
@media print {
  .topbar, .header, .footer, .no-print { display: none !important; }
  body { background: #fff !important; }
  main { padding: 0 !important; }
  #ticketPrintArea { box-shadow: none !important; border: none !important; }
}
</style>
@endpush

