@extends('layouts.app')

@section('title', 'Finalizar Pedido — En tu hogar')

@section('content')
<div class="topbar">
  <span>🚚</span> Finalizar Pedido · <strong>En tu hogar</strong>
</div>

<main class="container" style="padding: 40px 22px 80px; max-width: 960px;">
  <div style="margin-bottom: 28px;">
    <a href="{{ route('home') }}" style="color: var(--blue); font-size: 13px; font-weight: 600; text-decoration: none;">← Volver al catálogo</a>
    <h1 style="font-size: 28px; color: #173e4b; margin-top: 8px;">Confirmar y Finalizar Pedido</h1>
  </div>

  @if(session('error'))
    <div style="background: #fff1f1; border: 1px solid #ffd0d0; color: #9e1c1c; padding: 14px; border-radius: 10px; margin-bottom: 20px;">
      {{ session('error') }}
    </div>
  @endif

  <div style="display: grid; grid-template-columns: 1fr 340px; gap: 32px;">
    
    <!-- Formulario de entrega -->
    <div style="background: #fff; border: 1px solid var(--border); border-radius: 18px; padding: 28px; box-shadow: var(--shadow-sm);">
      <h2 style="font-size: 18px; color: var(--blue-dark); margin-bottom: 18px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">
        1. Datos de Entrega
      </h2>

      <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm" style="display: grid; gap: 16px;">
        @csrf
        <input type="hidden" name="cart_items" id="cartItemsInput">

        <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
          Nombre completo de quien recibe *
          <input type="text" name="cliente_nombre" required value="{{ old('cliente_nombre', $user->name ?? '') }}"
                 style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
        </label>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
          <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
            Correo electrónico *
            <input type="email" name="cliente_correo" required value="{{ old('cliente_correo', $user->email ?? '') }}"
                   style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
          </label>

          <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
            Teléfono de contacto *
            <input type="tel" name="cliente_telefono" required value="{{ old('cliente_telefono', $user->telefono ?? '') }}"
                   style="height: 42px; border: 1.5px solid var(--border); border-radius: 10px; padding: 0 14px; font-size: 14px; outline: none;">
          </label>
        </div>

        <label style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 600; color: #214b58;">
          Dirección exacta de entrega en tu hogar *
          <textarea name="direccion_entrega" rows="3" required
                    placeholder="Calle, número exterior e interior, colonia y referencias..."
                    style="border: 1.5px solid var(--border); border-radius: 10px; padding: 10px 14px; font-size: 14px; outline: none; font-family: inherit;">{{ old('direccion_entrega', $user->direccion ?? '') }}</textarea>
        </label>

        <div style="background: var(--light); border: 1px solid var(--border); border-radius: 10px; padding: 14px; font-size: 13px; color: var(--muted); margin-top: 6px;">
          💳 <strong>Método de pago:</strong> Pago en efectivo o terminal contra entrega en tu domicilio al momento de recibir tus garrafones o botellas.
        </div>

        <button type="submit" class="btn-primary" style="height: 48px; font-size: 16px; margin-top: 10px;">
          ✓ Confirmar y Realizar Pedido
        </button>
      </form>
    </div>

    <!-- Resumen del carrito -->
    <div>
      <div style="background: #fff; border: 1px solid var(--border); border-radius: 18px; padding: 24px; box-shadow: var(--shadow-sm); position: sticky; top: 100px;">
        <h3 style="font-size: 16px; color: #173e4b; margin-bottom: 14px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">
          Resumen de compra
        </h3>

        <div id="checkoutItemsList" style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 18px; max-height: 260px; overflow-y: auto;">
          <!-- Llenado con JS -->
        </div>

        <div style="display: flex; justify-content: space-between; font-size: 13px; color: var(--muted); margin-bottom: 8px;">
          <span>Envío</span> <strong style="color: #236b5b;">Gratis 🎉</strong>
        </div>

        <div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: 700; color: var(--text); padding-top: 12px; border-top: 1px solid var(--border);">
          <span>Total a pagar</span>
          <span style="color: var(--blue);" id="checkoutTotalAmount">$0.00</span>
        </div>
      </div>
    </div>

  </div>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const cart = JSON.parse(localStorage.getItem('eth_cart') || '[]');

  if (cart.length === 0) {
    alert('Tu carrito está vacío');
    window.location.href = "{{ route('home') }}";
    return;
  }

  document.getElementById('cartItemsInput').value = JSON.stringify(cart);

  const listEl = document.getElementById('checkoutItemsList');
  let total = 0;

  listEl.innerHTML = cart.map(item => {
    const sub = item.precio * item.cantidad;
    total += sub;
    return `
      <div style="display: flex; justify-content: space-between; align-items: center; font-size: 13px;">
        <div>
          <div style="font-weight: 600; color: var(--text);">${item.nombre}</div>
          <div style="color: var(--muted); font-size: 11px;">Cant: ${item.cantidad} x $${Number(item.precio).toFixed(2)}</div>
        </div>
        <div style="font-weight: 700; color: var(--blue);">$${sub.toFixed(2)}</div>
      </div>
    `;
  }).join('');

  document.getElementById('checkoutTotalAmount').textContent = `$${total.toFixed(2)}`;

  document.getElementById('checkoutForm').addEventListener('submit', () => {
    localStorage.removeItem('eth_cart');
  });
});
</script>
@endpush

