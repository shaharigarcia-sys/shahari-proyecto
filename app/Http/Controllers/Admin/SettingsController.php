<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit()
    {
        $settings = SiteSetting::allKeyed();
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $allowedKeys = [
            'hero_tag',
            'hero_title',
            'hero_subtitle',
            'hero_btn_text',
            'hero_btn_link',
            'topbar_text',
            'topbar_highlight',
            'info_title',
            'info_card1_title',
            'info_card1_desc',
            'info_card2_title',
            'info_card2_desc',
            'info_card3_title',
            'info_card3_desc',
            'contact_title',
            'contact_desc',
            'contact_phone',
        ];

        $validated = $request->validate([
            'hero_tag' => 'nullable|string|max:120',
            'hero_title' => 'required|string|max:500',
            'hero_subtitle' => 'nullable|string|max:1000',
            'hero_btn_text' => 'nullable|string|max:60',
            'hero_btn_link' => 'nullable|string|max:200',
            'topbar_text' => 'nullable|string|max:255',
            'topbar_highlight' => 'nullable|string|max:255',
            'info_title' => 'nullable|string|max:255',
            'info_card1_title' => 'nullable|string|max:120',
            'info_card1_desc' => 'nullable|string|max:500',
            'info_card2_title' => 'nullable|string|max:120',
            'info_card2_desc' => 'nullable|string|max:500',
            'info_card3_title' => 'nullable|string|max:120',
            'info_card3_desc' => 'nullable|string|max:500',
            'contact_title' => 'nullable|string|max:255',
            'contact_desc' => 'nullable|string|max:500',
            'contact_phone' => 'nullable|string|max:40',
        ]);

        foreach ($allowedKeys as $key) {
            if ($request->has($key)) {
                SiteSetting::set($key, $request->input($key));
            }
        }

        return redirect()->route('admin.settings.edit')->with('success', 'Contenido del sitio actualizado correctamente.');
    }

    public function restore()
    {
        $defaults = [
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

        foreach ($defaults as $key => $value) {
            SiteSetting::set($key, $value);
        }

        return redirect()->route('admin.settings.edit')->with('success', 'Contenido original restaurado con éxito.');
    }
}
