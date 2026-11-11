@extends('layouts.app')

@section('title', 'En tu hogar – Agua purificada a domicilio')

@section('content')
  <!-- ========== TOPBAR ========== -->
  <div class="topbar" role="note">
    <span aria-hidden="true">🚚</span>
    {{ $settings['topbar_text'] ?? 'Envíos a domicilio · Entrega el mismo día' }}
    <strong>{{ $settings['topbar_highlight'] ?? 'Envío gratis en tu primer pedido' }}</strong>
  </div>

  <!-- ========== HEADER ========== -->
  <header class="header">
    <div class="header-inner">
      <a class="logo" href="{{ route('home') }}" aria-label="En tu hogar – Inicio">
        <span class="logo-a"> entu</span><span class="logo-b">hogar</span>
        <small>por agua</small>
      </a>

      <button class="menu-toggle" id="menuToggle"
              aria-label="Abrir menú de navegación"
              aria-expanded="false"
              aria-controls="mainNav">
        <span></span><span></span><span></span>
      </button>

      <nav class="nav" id="mainNav" aria-label="Navegación principal">
        <a href="#catalogo" class="nav-link nav-active">Productos</a>
        <a href="#info"     class="nav-link">Retornables</a>
        <a href="#ayuda" class="nav-link">Ayuda</a>
      </nav>

      <div class="header-actions">
        @auth
          @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="btn-ghost btn-sm" style="background:var(--aqua); color:var(--blue-dark); font-weight:700;">⚙ Panel Admin</a>
          @else
            <span class="user-greeting">Hola, {{ auth()->user()->name }}</span>
          @endif
          <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn-ghost btn-sm" style="border:none; padding:4px 8px; font-size:12px; cursor:pointer;">Salir</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="btn-ghost btn-sm" id="loginBtn">Iniciar sesión</a>
        @endauth

        <button class="cart-toggle" id="cartBtn" aria-label="Abrir carrito de compras">
          <span aria-hidden="true">🛒</span>
          <span class="cart-badge" id="cartCount" aria-live="polite" aria-atomic="true">0</span>
        </button>
      </div>
    </div>
  </header>

  <!-- ========== HERO ========== -->
  <section class="hero" aria-label="Bienvenida">
    <div class="hero-inner">
      <div class="hero-text reveal">
        <span class="hero-tag">{{ $settings['hero_tag'] ?? '🫧 Agua pura garantizada' }}</span>
        <h1>{!! nl2br($settings['hero_title'] ?? "El agua que\nnecesitas,\n<em>en tu hogar</em>") !!}</h1>
        <p class="hero-sub">{!! nl2br(e($settings['hero_subtitle'] ?? "Garrafones, bidones y botellas de las mejores marcas.\nPedido rápido, entrega el mismo día a tu domicilio.")) !!}</p>
        
        <div class="hero-ctas">
          <a href="{{ $settings['hero_btn_link'] ?? '#catalogo' }}" class="btn-primary">{{ $settings['hero_btn_text'] ?? 'Ver productos' }}</a>
          <a href="#info" class="btn-ghost">Cómo funcionan los retornables</a>
        </div>
        <ul class="hero-trust" aria-label="Beneficios">
          <li>✓ Envío gratis en tu primer pedido</li>
          <li>✓ Agua certificada</li>
          <li>✓ Pago seguro</li>
        </ul>
      </div>

      <div class="hero-visual" aria-hidden="true">
        <div class="hero-blob"></div>
        <img src="{{ asset('assets/images/agua1.svg') }}"  alt="" class="hv-main"  loading="eager">
        <img src="{{ asset('assets/images/agua3.svg') }}"  alt="" class="hv-left"  loading="eager">
        <img src="{{ asset('assets/images/agua7.svg') }}"  alt="" class="hv-right" loading="eager">
      </div>
    </div>
  </section>

  <!-- ========== BRAND BAR ========== -->
  <section class="brands-bar" id="marcas" aria-label="Marcas disponibles">
    <div class="container">
      <span class="brands-label">Marcas disponibles</span>
      <div class="brands-list" role="list">
        @foreach($marcasDisponibles as $m)
          <span class="brand-chip" role="listitem">
            {{ $m }}
          </span>
        @endforeach
      </div>
    </div>
  </section>

  <!-- ========== CATALOG ========== -->
  <main id="catalogo" class="container catalog-section" tabindex="-1">
    <div class="page-title-row">
      <div>
        <nav class="breadcrumbs" aria-label="Ruta de navegación">
          <a href="{{ route('home') }}">⌂ Inicio</a>
          <span aria-hidden="true">/</span>
          <strong aria-current="page">Agua</strong>
        </nav>
        <h2 class="section-title">Productos de Agua</h2>
        <p class="results-count" id="resultsCount">
          Mostrando <strong>{{ $products->count() }}</strong> productos
        </p>
      </div>

      <div class="sort-form">
        <form id="sortForm" action="{{ route('home') }}#catalogo" method="GET">
          @if(request('buscar')) <input type="hidden" name="buscar" value="{{ request('buscar') }}"> @endif
          @if(request('retornables')) <input type="hidden" name="retornables" value="1"> @endif
          @foreach((array)request('marcas', []) as $m)
            <input type="hidden" name="marcas[]" value="{{ $m }}">
          @endforeach
          <label for="sortSelect" class="sr-only">Ordenar productos</label>
          <select id="sortSelect" name="orden" onchange="document.getElementById('sortForm').submit()">
            <option value="recomendados" {{ request('orden') == 'recomendados' ? 'selected' : '' }}>Recomendados</option>
            <option value="precio_asc" {{ request('orden') == 'precio_asc' ? 'selected' : '' }}>Precio: menor a mayor</option>
            <option value="precio_desc" {{ request('orden') == 'precio_desc' ? 'selected' : '' }}>Precio: mayor a menor</option>
            <option value="nombre" {{ request('orden') == 'nombre' ? 'selected' : '' }}>Nombre A–Z</option>
          </select>
        </form>
      </div>
    </div>

    <div class="catalog">
      <!-- Sidebar -->
      <aside class="sidebar" aria-label="Filtros de búsqueda">
        <p class="filter-title">Filtrar por</p>
        <a href="{{ route('home') }}#catalogo" class="clear-btn" style="text-decoration:none; display:inline-block; text-align:center;">↻ Limpiar todo</a>

        <form action="{{ route('home') }}#catalogo" method="GET" id="filterForm">
          @if(request('orden')) <input type="hidden" name="orden" value="{{ request('orden') }}"> @endif

          <div class="filter-box">
            <p class="filter-heading">Buscar</p>
            <div class="search-box" role="search">
              <label for="searchInput" class="sr-only">Buscar por nombre o marca</label>
              <input type="search" id="searchInput" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre o marca…" autocomplete="off">
              <button type="submit" aria-label="Buscar">⌕</button>
            </div>
          </div>

          <div class="filter-box">
            <p class="filter-heading">Marca</p>
            <div role="group" aria-label="Filtrar por marca">
              @php $marcasSeleccionadas = (array) request('marcas', []); @endphp
              @foreach($marcasDisponibles as $marca)
                <label class="check-row">
                  <input type="checkbox" name="marcas[]" value="{{ $marca }}" 
                         {{ in_array($marca, $marcasSeleccionadas) ? 'checked' : '' }}
                         onchange="document.getElementById('filterForm').submit()">
                  <span>{{ $marca }}</span>
                </label>
              @endforeach
            </div>
          </div>

          <div class="filter-box">
            <p class="filter-heading">Tipo</p>
            <label class="check-row">
              <input type="checkbox" name="retornables" value="1" 
                     {{ request('retornables') ? 'checked' : '' }}
                     onchange="document.getElementById('filterForm').submit()">
              <span>Solo retornables</span>
            </label>
          </div>
        </form>
      </aside>

      <!-- Results -->
      <section class="results" aria-label="Listado de productos">
        @if($products->isEmpty())
          <div class="empty-state">
            <img src="{{ asset('assets/images/producto-default.svg') }}" alt="" width="90">
            <h3>Sin resultados</h3>
            <p>No encontramos productos con ese criterio de búsqueda.</p>
            <a href="{{ route('home') }}#catalogo" class="btn-primary" style="text-decoration:none;">Ver todos los productos</a>
          </div>
        @else
          <div class="product-grid" id="productGrid">
            @foreach($products as $p)
              <article class="product-card" data-id="{{ $p->id }}">
                <div class="product-image-wrap">
                  @if($p->etiqueta)
                    <span class="product-badge">{{ $p->etiqueta }}</span>
                  @endif
                  <img src="{{ $p->imagen_url }}" alt="{{ $p->nombre }}" loading="lazy" width="160" height="170">
                </div>
                <div class="product-body">
                  @if($p->retornable)
                    <span class="liquid-badge">♻️ Solo líquido</span>
                  @endif
                  <h3>{{ $p->nombre }}</h3>
                  <div class="product-footer">
                    <div class="price-wrap">
                      <span class="price-unit">{{ $p->presentacion }} · {{ $p->unidad }}</span>
                      <span class="price-amount">${{ number_format($p->precio, 2) }}</span>
                    </div>
                    <button class="add-btn" 
                            data-id="{{ $p->id }}"
                            data-nombre="{{ $p->nombre }}"
                            data-precio="{{ $p->precio }}"
                            data-presentacion="{{ $p->presentacion }}"
                            data-imagen="{{ $p->imagen_url }}"
                            aria-label="Agregar {{ $p->nombre }} al carrito">
                      + Agregar
                    </button>
                  </div>
                </div>
              </article>
            @endforeach
          </div>
        @endif
      </section>
    </div>
  </main>

  <!-- Retornables: orientación general, sin prometer costos o aceptación de envases. -->
  <section class="info-section returns-section" id="info" aria-labelledby="returns-title">
    <div class="container">
      <h2 class="section-heading" id="returns-title">Retornables: conoce cómo funciona el intercambio</h2>
      <p class="section-intro">Un envase retornable está diseñado para utilizarse nuevamente. Antes de elegir tu agua, revisa la presentación y si el producto está identificado como retornable.</p>
      <div class="info-grid">
        <article class="info-card">
          <span class="info-icon" aria-hidden="true">1</span>
          <h3>Encuentra tu presentación</h3>
          <p>Activa el filtro “Solo retornables” en el catálogo. Compara el nombre, la presentación y el precio del producto que necesitas.</p>
        </article>
        <article class="info-card">
          <span class="info-icon" aria-hidden="true">2</span>
          <h3>Revisa tu envase</h3>
          <p>Si ya tienes un envase, identifica su marca y capacidad y revisa su estado. Confirma con la tienda si es compatible y puede recibirse a cambio.</p>
        </article>
        <article class="info-card">
          <span class="info-icon" aria-hidden="true">3</span>
          <h3>Confirma qué incluye</h3>
          <p>La etiqueta “Solo líquido” indica que el precio corresponde al agua. Si no tienes envase, confirma su disponibilidad y costo antes de completar el pedido.</p>
        </article>
      </div>
      <div class="returns-note"><strong>Antes de comprar:</strong> revisa las condiciones de intercambio. La aceptación del envase y cualquier costo adicional deben confirmarse con la tienda.</div>
      <div class="section-actions">
        <a href="{{ route('home', ['retornables' => 1]) }}#catalogo" class="btn-primary">Ver productos retornables</a>
        <a href="#ayuda" class="btn-ghost">Consultar preguntas frecuentes</a>
      </div>
    </div>
  </section>

  <!-- Ayuda sin datos de contacto ficticios. details permite consultar con teclado y sin JavaScript. -->
  <section class="help-section" id="ayuda" aria-labelledby="help-title">
    <div class="container help-inner">
      <h2 id="help-title">¿En qué podemos ayudarte?</h2>
      <p class="section-intro">Resuelve tus dudas sobre el catálogo, los envases y el carrito.</p>
      <div class="faq-list">
        <details class="faq-item">
          <summary>¿Cómo encuentro un producto?</summary>
          <p>Escribe su nombre o marca en el buscador del catálogo. También puedes filtrar por marca y ordenar los resultados por precio o nombre.</p>
        </details>
        <details class="faq-item">
          <summary>¿Qué significa “Solo líquido”?</summary>
          <p>Significa que la oferta corresponde al contenido de agua. No des por incluido un envase nuevo: revisa las condiciones del retornable antes de comprar.</p>
        </details>
        <details class="faq-item">
          <summary>¿Qué hago si no tengo un envase retornable?</summary>
          <p>Confirma con la tienda si puedes adquirir uno y cuál es su costo. También puedes desactivar el filtro “Solo retornables” y revisar otras presentaciones del catálogo.</p>
        </details>
        <details class="faq-item">
          <summary>¿Cómo cambio la cantidad o quito un producto?</summary>
          <p>Abre el carrito con el icono de la parte superior. Usa + o − para cambiar la cantidad; cuando llegue a cero, el producto se retirará del carrito.</p>
        </details>
        <details class="faq-item">
          <summary>¿Agregar un producto confirma mi pedido?</summary>
          <p>No. Agregarlo solo lo incorpora a tu carrito. Revisa los productos y cantidades y pulsa “Continuar pedido” para pasar al siguiente paso.</p>
        </details>
      </div>
      <div class="section-actions"><a href="#catalogo" class="btn-primary">Volver al catálogo</a></div>
    </div>
  </section>

  <!-- ========== FOOTER ========== -->
  <footer class="footer" role="contentinfo">
    <div class="footer-grid">
      <div class="footer-col">
        <h3>Soporte</h3>
        <a href="#">Ciudades con servicio</a>
        <a href="#ayuda">Preguntas frecuentes</a>
        <a href="#">Políticas de envío</a>
        <a href="#">Devoluciones</a>
      </div>

      <div class="footer-col">
        <h3>Ayuda con tu compra</h3>
        <a href="#ayuda">Dudas sobre el catálogo y el carrito</a>
        <a href="#info">Cómo funcionan los retornables</a>
        <a href="#catalogo">Consultar productos</a>
      </div>

      <div class="footer-col footer-brand-col">
        <div class="footer-logo" aria-label="En tu hogar">
          <span>en tu</span><b>hogar</b> <small>por Coca-Cola</small>
        </div>
        <nav class="socials" aria-label="Redes sociales">
          <a href="#" class="social-icon" aria-label="Facebook">f</a>
          <a href="#" class="social-icon" aria-label="X / Twitter">𝕏</a>
          <a href="#" class="social-icon" aria-label="Instagram">◎</a>
          <a href="#" class="social-icon" aria-label="YouTube">▶</a>
        </nav>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© 2026 En tu hogar. Todos los derechos reservados.</span>
      <nav aria-label="Links legales">
        <a href="#">Términos y condiciones</a>
        <a href="#">Aviso de Privacidad</a>
        <a href="#">Configuración de Cookies</a>
      </nav>
    </div>
  </footer>

  <!-- ========== CART SIDEBAR ========== -->
  <div class="overlay" id="overlay" aria-hidden="true"></div>

  <aside class="cart-sidebar" id="cartSidebar" aria-label="Carrito de compras" aria-hidden="true">
    <div class="cart-sidebar-head">
      <h2>Tu carrito</h2>
      <button class="close-btn" id="closeCart" aria-label="Cerrar carrito">✕</button>
    </div>

    <div class="cart-empty-msg" id="cartEmpty">
      <span aria-hidden="true" class="cart-empty-icon">🛒</span>
      <p>Tu carrito está vacío</p>
      <button class="btn-primary" id="keepShoppingBtn">Ver productos</button>
    </div>

    <div class="cart-items" id="cartItems" aria-live="polite"></div>

    <div class="cart-footer" id="cartFooter" hidden>
      <div class="cart-summary-row">
        <span>Envío</span><strong>Gratis 🎉</strong>
      </div>
      <div class="cart-summary-row cart-total">
        <span>Total</span><strong id="cartTotal">$0.00</strong>
      </div>
      <button class="btn-primary cart-cta" id="checkoutBtn">Continuar pedido</button>
      <p class="cart-note">* Conectado con la tienda en línea En tu hogar.</p>
    </div>
  </aside>

  <!-- ========== TOAST ========== -->
  <div class="toast" id="toast" role="status" aria-live="polite" aria-atomic="true"></div>
@endsection

@push('scripts')
<script>
'use strict';

let cart = JSON.parse(localStorage.getItem('eth_cart') || '[]');

function saveCart() { localStorage.setItem('eth_cart', JSON.stringify(cart)); }
function cartTotal() { return cart.reduce((sum, i) => sum + (i.precio * i.cantidad), 0); }
function cartCount() { return cart.reduce((sum, i) => sum + i.cantidad, 0); }

function updateCartUI() {
  const badge = document.getElementById('cartCount');
  const count = cartCount();
  badge.textContent = count;
  badge.style.display = count > 0 ? '' : 'none';
  renderCartItems();
}

function showToast(msg, duration = 2800) {
  const toast = document.getElementById('toast');
  toast.textContent = msg;
  toast.classList.add('show');
  clearTimeout(toast._timeout);
  toast._timeout = setTimeout(() => toast.classList.remove('show'), duration);
}

function addToCart(itemData) {
  const existing = cart.find(i => i.id == itemData.id);
  if (existing) {
    existing.cantidad += 1;
  } else {
    cart.push({ ...itemData, cantidad: 1 });
  }
  saveCart();
  updateCartUI();
  showToast(`🛒 "${itemData.nombre.split(' ').slice(0, 4).join(' ')}…" agregado`);
}

function renderCartItems() {
  const itemsEl  = document.getElementById('cartItems');
  const emptyEl  = document.getElementById('cartEmpty');
  const footerEl = document.getElementById('cartFooter');
  const totalEl  = document.getElementById('cartTotal');

  if (cart.length === 0) {
    itemsEl.innerHTML = '';
    itemsEl.hidden = true;
    emptyEl.hidden = false;
    footerEl.hidden = true;
    return;
  }

  itemsEl.hidden = false;
  emptyEl.hidden = true;
  footerEl.hidden = false;

  itemsEl.innerHTML = cart.map(item => {
    const totalItem = (item.precio * item.cantidad).toLocaleString('es-MX', { style: 'currency', currency: 'MXN' });
    return `
      <div class="cart-item" data-id="${item.id}">
        <img src="${item.imagen}" alt="${item.nombre}">
        <div class="cart-item-info">
          <h4>${item.nombre}</h4>
          <p>${item.presentacion}</p>
          <span class="cart-item-price">${totalItem}</span>
        </div>
        <div class="cart-qty-controls">
          <button class="qty-btn" onclick="changeCartQty(${item.id}, 1)">+</button>
          <span class="qty-count">${item.cantidad}</span>
          <button class="qty-btn" onclick="changeCartQty(${item.id}, -1)">−</button>
        </div>
      </div>
    `;
  }).join('');

  totalEl.textContent = cartTotal().toLocaleString('es-MX', { style: 'currency', currency: 'MXN' });
}

window.changeCartQty = function(id, delta) {
  const item = cart.find(i => i.id == id);
  if (!item) return;
  item.cantidad += delta;
  if (item.cantidad <= 0) {
    cart = cart.filter(i => i.id != id);
  }
  saveCart();
  updateCartUI();
};

function openCart() {
  document.getElementById('cartSidebar').classList.add('open');
  document.getElementById('overlay').classList.add('visible');
  document.body.style.overflow = 'hidden';
}

function closeCart() {
  document.getElementById('cartSidebar').classList.remove('open');
  document.getElementById('overlay').classList.remove('visible');
  document.body.style.overflow = '';
}

document.addEventListener('DOMContentLoaded', () => {
  updateCartUI();

  document.getElementById('cartBtn').addEventListener('click', openCart);
  document.getElementById('closeCart').addEventListener('click', closeCart);
  document.getElementById('overlay').addEventListener('click', closeCart);
  document.getElementById('keepShoppingBtn')?.addEventListener('click', closeCart);

  // Delegación agregar al carrito
  document.addEventListener('click', e => {
    const btn = e.target.closest('.add-btn');
    if (btn) {
      addToCart({
        id: btn.dataset.id,
        nombre: btn.dataset.nombre,
        precio: parseFloat(btn.dataset.precio),
        presentacion: btn.dataset.presentacion,
        imagen: btn.dataset.imagen,
      });
    }
  });

  // Mobile menu
  const menuToggle = document.getElementById('menuToggle');
  const mainNav = document.getElementById('mainNav');
  if (menuToggle && mainNav) {
    menuToggle.addEventListener('click', () => {
      const open = mainNav.classList.toggle('open');
      menuToggle.classList.toggle('open', open);
    });
  }

  // Checkout button hacia pasarela / confirmación
  document.getElementById('checkoutBtn')?.addEventListener('click', () => {
    if (cart.length === 0) {
      showToast('Tu carrito está vacío');
      return;
    }
    window.location.href = "{{ route('checkout.form') }}";
  });
});
</script>
@endpush

