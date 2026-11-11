<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;
use App\Models\SiteSetting;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Usuario Administrador
        $adminEmail = 'admin@tienda.com';
        $adminPassword = config('app.admin_initial_password');
        $admin = User::query()->where('email', $adminEmail)->first();

        if ($admin === null && ! filled($adminPassword)) {
            throw new \RuntimeException(
                'Define ADMIN_INITIAL_PASSWORD antes de crear el usuario administrador.'
            );
        }

        $adminAttributes = [
            'name' => 'Administrador',
            'rol' => 'admin',
            'edad' => 30,
            'direccion' => 'Oficina Principal, Tienda de Agua',
            'telefono' => '8007044400',
        ];

        if (filled($adminPassword)) {
            $adminAttributes['password'] = Hash::make($adminPassword);
        }

        User::updateOrCreate(['email' => $adminEmail], $adminAttributes);

        // 2. Contenido del CMS (SiteSettings)
        $settings = [
            'hero_tag' => '🫧 Agua pura garantizada',
            'hero_title' => "El agua que\nnecesitas,\n<em>en tu hogar</em>",
            'hero_subtitle' => "Garrafones, bidones y botellas de las mejores marcas.\nPedido rápido, entrega el mismo día a tu domicilio.",
            'hero_btn_text' => 'Ver productos',
            'hero_btn_link' => '#catalogo',
            'topbar_text' => 'Envíos a domicilio · Entrega el mismo día',
            'topbar_highlight' => 'Envío gratis en tu primer pedido',
            'info_title' => '¿Por qué elegir <em>En tu hogar</em>?',
            'info_card1_title' => 'Retornables',
            'info_card1_desc' => 'Paga solo por el agua. Devuelve el garrafón vacío en tu próximo pedido y ahorra en cada compra.',
            'info_card2_title' => 'Entrega rápida',
            'info_card2_desc' => 'Pedidos antes de las 2 pm se entregan el mismo día. Lunes a sábado en horario extendido.',
            'info_card3_title' => 'Agua certificada',
            'info_card3_desc' => 'Todos nuestros productos cuentan con certificación sanitaria y cadena de pureza garantizada.',
            'contact_title' => '¿Tienes dudas sobre tu pedido?',
            'contact_desc' => 'Nuestro equipo está disponible de lunes a viernes de 9:00 a 20:00 h y sábados de 10:00 a 18:00 h.',
            'contact_phone' => '800-704-4400',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // 3. Catálogo de Productos
        $products = [
            [
                'nombre' => 'Garrafón Retornable Cristal Agua Purificada 20 L',
                'marca' => 'Cristal',
                'categoria' => 'Agua',
                'presentacion' => '1 Pieza',
                'unidad' => 'Desde',
                'precio' => 49.00,
                'imagen' => 'agua1.svg',
                'etiqueta' => null,
                'retornable' => true,
                'activo' => true,
            ],
            [
                'nombre' => 'Garrafón Retornable Ciel Agua Purificada 20 L',
                'marca' => 'Ciel',
                'categoria' => 'Agua',
                'presentacion' => '1 Pieza',
                'unidad' => 'Desde',
                'precio' => 53.00,
                'imagen' => 'agua2.svg',
                'etiqueta' => null,
                'retornable' => true,
                'activo' => true,
            ],
            [
                'nombre' => 'Agua Purificada Ciel Bidón de 5 L',
                'marca' => 'Ciel',
                'categoria' => 'Agua',
                'presentacion' => '4 Bidones',
                'unidad' => 'Desde',
                'precio' => 156.00,
                'imagen' => 'agua3.svg',
                'etiqueta' => null,
                'retornable' => false,
                'activo' => true,
            ],
            [
                'nombre' => 'Agua Mineral Topo Chico 600 ml',
                'marca' => 'Topo Chico',
                'categoria' => 'Agua',
                'presentacion' => '1 Botella',
                'unidad' => 'Desde',
                'precio' => 21.00,
                'imagen' => 'agua4.svg',
                'etiqueta' => 'Topo Chico',
                'retornable' => false,
                'activo' => true,
            ],
            [
                'nombre' => 'Agua Natural Purificada Ciel 1 L',
                'marca' => 'Ciel',
                'categoria' => 'Agua',
                'presentacion' => '1 Botella',
                'unidad' => 'Desde',
                'precio' => 14.00,
                'imagen' => 'agua5.svg',
                'etiqueta' => null,
                'retornable' => false,
                'activo' => true,
            ],
            [
                'nombre' => 'Agua Purificada Ciel 600 ml',
                'marca' => 'Ciel',
                'categoria' => 'Agua',
                'presentacion' => '1 Botella',
                'unidad' => 'Desde',
                'precio' => 12.00,
                'imagen' => 'agua6.svg',
                'etiqueta' => null,
                'retornable' => false,
                'activo' => true,
            ],
            [
                'nombre' => 'Agua Mineral Topo Chico 1.5 L',
                'marca' => 'Topo Chico',
                'categoria' => 'Agua',
                'presentacion' => '1 Botella',
                'unidad' => 'Desde',
                'precio' => 29.00,
                'imagen' => 'agua7.svg',
                'etiqueta' => 'Topo Chico',
                'retornable' => false,
                'activo' => true,
            ],
            [
                'nombre' => 'Agua Mineralizada Ciel 2 L',
                'marca' => 'Ciel',
                'categoria' => 'Agua',
                'presentacion' => '1 Botella',
                'unidad' => 'Desde',
                'precio' => 28.50,
                'imagen' => 'agua8.svg',
                'etiqueta' => null,
                'retornable' => false,
                'activo' => true,
            ],
            [
                'nombre' => 'Agua Mineral Topo Chico 192 ml',
                'marca' => 'Topo Chico',
                'categoria' => 'Agua',
                'presentacion' => '1 Botella',
                'unidad' => 'Desde',
                'precio' => 16.25,
                'imagen' => 'agua9.svg',
                'etiqueta' => null,
                'retornable' => false,
                'activo' => true,
            ],
            [
                'nombre' => 'Agua Purificada Ciel 1.5 L',
                'marca' => 'Ciel',
                'categoria' => 'Agua',
                'presentacion' => '1 Botella',
                'unidad' => 'Desde',
                'precio' => 17.00,
                'imagen' => 'agua10.svg',
                'etiqueta' => null,
                'retornable' => false,
                'activo' => true,
            ],
            [
                'nombre' => 'Agua Purificada Ciel Bidón de 10 L',
                'marca' => 'Ciel',
                'categoria' => 'Agua',
                'presentacion' => '1 Bidón',
                'unidad' => 'Desde',
                'precio' => 48.00,
                'imagen' => 'agua11.svg',
                'etiqueta' => null,
                'retornable' => true,
                'activo' => true,
            ],
            [
                'nombre' => 'Agua Mineralizada Ciel 355 ml Retornable',
                'marca' => 'Ciel',
                'categoria' => 'Agua',
                'presentacion' => '1 Botella',
                'unidad' => 'Desde',
                'precio' => 12.00,
                'imagen' => 'agua12.svg',
                'etiqueta' => null,
                'retornable' => true,
                'activo' => true,
            ],
        ];

        foreach ($products as $item) {
            Product::updateOrCreate(['nombre' => $item['nombre']], $item);
        }
    }
}
