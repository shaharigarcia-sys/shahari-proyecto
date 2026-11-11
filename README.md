# Shahari

Aplicación web de tienda de agua purificada a domicilio. Permite consultar un catálogo de productos, buscar y filtrar artículos, registrar clientes, procesar pedidos y administrar productos y contenido del sitio.

**Sitio publicado:** [En tu hogar – Agua purificada a domicilio](https://shahari.drlizcano.com/)

## Tecnologías verificadas

- PHP 8.3 o superior y Laravel 13.
- Blade, Eloquent y rutas/controladores de Laravel.
- MySQL en la configuración local actual; el código también contempla SQLite y MariaDB.
- HTML, CSS y JavaScript.
- Vite 8 y Tailwind CSS 4 para los recursos del frontend.
- Composer y npm para dependencias.

## Requisitos

- PHP 8.3 o superior con las extensiones requeridas por Laravel y `pdo_mysql` (o `pdo_sqlite` si se usa SQLite).
- Composer.
- Node.js y npm.
- MySQL o MariaDB disponible localmente.

## Instalación y ejecución en Windows

Desde PowerShell, en la raíz del proyecto:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
```

Edita `.env` y define `ADMIN_INITIAL_PASSWORD` con una contraseña privada y exclusiva. Ajusta también las variables `DB_*` a tu servidor MySQL local y crea la base configurada. Por ejemplo, con MySQL instalado:

```powershell
mysql -u root -p -e "CREATE DATABASE shahari CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

Prepara las tablas y datos iniciales:

```powershell
php artisan migrate --seed
```

Las pruebas definidas por el proyecto usan SQLite en memoria; para ejecutarlas se requiere habilitar `pdo_sqlite` además de la extensión de base de datos de la aplicación.

Instala y compila los recursos del frontend:

```powershell
npm.cmd install --ignore-scripts
npm.cmd run build
```

Inicia el servidor local:

```powershell
php artisan serve --host=127.0.0.1 --port=8000
```

Abre <http://127.0.0.1:8000>. Para desarrollo del frontend, usa `npm.cmd run dev` en otra terminal. En PowerShell, `npm.cmd` evita el bloqueo de `npm.ps1` cuando la política de ejecución lo impide.

Para ejecutar las pruebas:

```powershell
php artisan test
```

## Funcionalidades

- Catálogo público con búsqueda, filtros por marca y productos retornables, y ordenamiento por precio o nombre.
- Registro e inicio de sesión de clientes.
- Carrito, captura de datos de entrega, registro del pedido y consulta del ticket.
- Panel administrativo protegido con gestión de productos y edición de contenido del sitio.

## Estructura principal

| Carpeta | Contenido |
|---|---|
| `app/` | Controladores, modelos y middleware. |
| `bootstrap/` | Inicialización de Laravel. |
| `config/` | Configuración de aplicación, servicios y bases de datos. |
| `database/` | Migraciones, seeders y base SQLite local (no se publica). |
| `docs/` | Índice documental, diagramas disponibles y entrega de hosting. |
| `public/` | Punto de entrada y recursos públicos estáticos. |
| `resources/` | Vistas Blade, CSS y JavaScript fuente. |
| `routes/` | Rutas web y de consola. |
| `storage/` | Archivos temporales, sesiones, logs y datos generados localmente. |
| `tests/` | Pruebas automatizadas. |

## Documentación

Consulta el [índice de documentación y diagramas](docs/README.md) y la [entrega de Hosting](docs/entregas/hosting.md).
