<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin institucional</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: radial-gradient(circle at top, #E2E8F0 0%, #F3F4F6 42%, #F8FAFC 100%);
            color: #111827;
            line-height: 1.45;
        }
        .container { width: min(1260px, 96%); margin: 18px auto; }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 14px;
            background: linear-gradient(135deg, #111827, #1F2937);
            color: #fff;
            border-radius: 12px;
            border: 1px solid #1F2937;
            padding: 12px 14px;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.18);
        }
        h1, h2, h3 { margin: 0; }
        h1 { font-size: clamp(22px, 2.6vw, 30px); }
        .layout { display: grid; grid-template-columns: 280px 1fr; gap: 14px; align-items: start; }
        .sidebar, .panel {
            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.08);
        }
        .sidebar { position: sticky; top: 12px; overflow: hidden; }
        .side-title { padding: 14px; background: #111827; color: #fff; font-weight: 700; }
        .side-nav { padding: 10px; display: grid; gap: 8px; }
        .side-link {
            display: block;
            text-decoration: none;
            color: #111827;
            background: #F9FAFB;
            border: 1px solid #E5E7EB;
            border-radius: 10px;
            padding: 10px 12px;
            font-weight: 700;
        }
        .side-link.is-active { background: #111827; color: #fff; border-color: #111827; }
        .panel-head { padding: 14px; border-bottom: 1px solid #E5E7EB; background: #F9FAFB; font-weight: 700; }
        .panel-body { padding: 16px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; }
        label { display: block; font-size: 13px; margin-bottom: 4px; font-weight: 700; }
        input, textarea, select { width: 100%; padding: 8px; border: 1px solid #D1D5DB; border-radius: 8px; box-sizing: border-box; }
        .btn {
            border: 0;
            background: #111827;
            color: white;
            padding: 9px 14px;
            border-radius: 999px;
            cursor: pointer;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform .2s ease, opacity .2s ease;
        }
        .btn-secondary { background: #4B5563; }
        .btn-danger { background: #B91C1C; }
        .btn:hover { transform: translateY(-1px); opacity: .94; }
        .btn-row { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .status { background: #DCFCE7; border: 1px solid #86EFAC; padding: 10px; border-radius: 8px; margin-bottom: 10px; }
        .errors { background: #FEE2E2; border: 1px solid #FCA5A5; padding: 10px; border-radius: 8px; margin-bottom: 10px; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border-bottom: 1px solid #E5E7EB; padding: 8px; text-align: left; white-space: nowrap; }
        img.preview { max-height: 60px; border-radius: 6px; }
        hr { margin: 18px 0; border: 0; border-top: 1px solid #E5E7EB; }

        @media (max-width: 980px) {
            .layout { grid-template-columns: 1fr; }
            .sidebar { position: static; }
        }
        @media (max-width: 680px) {
            .container { width: min(1260px, 98%); margin: 12px auto; }
            .panel-body { padding: 12px; }
            .panel-head, .side-title { padding: 12px; }
            .btn-row form, .btn-row a, .btn-row button { width: 100%; }
            .btn-row button { width: 100%; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Panel admin del sitio institucional</h1>
        <div class="btn-row">
            <a class="btn btn-secondary" href="{{ route('home') }}" target="_blank" rel="noopener noreferrer">Ver sitio</a>
            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                @csrf
                <button class="btn btn-secondary" type="submit">Cerrar sesión</button>
            </form>
        </div>
    </div>

    @if(session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="layout">
        <aside class="sidebar">
            <div class="side-title">Menú admin</div>
            <nav class="side-nav">
                <a class="side-link @if($currentSection === 'settings') is-active @endif" href="{{ route('admin.settings.page') }}">Configuración general</a>
                <a class="side-link @if($currentSection === 'company') is-active @endif" href="{{ route('admin.company.page') }}">Datos de la empresa</a>
                <a class="side-link @if($currentSection === 'menu') is-active @endif" href="{{ route('admin.menu.page') }}">Menú del sitio</a>
                <a class="side-link @if($currentSection === 'sliders') is-active @endif" href="{{ route('admin.sliders.page') }}">Sliders</a>
                <a class="side-link @if($currentSection === 'password') is-active @endif" href="{{ route('admin.password.page') }}">Cambiar contraseña</a>
            </nav>
        </aside>

        <main class="panel">
            @if($currentSection === 'settings')
                <div class="panel-head">Configuración general</div>
                <div class="panel-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid">
                            <div>
                                <label>Nombre del sitio</label>
                                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}" required>
                            </div>
                            <div>
                                <label>Email de contacto</label>
                                <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}">
                            </div>
                            <div>
                                <label>Teléfono</label>
                                <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}">
                            </div>
                            <div>
                                <label>Color primario</label>
                                <input type="text" name="primary_color" value="{{ $settings['primary_color'] ?? '#1D4ED8' }}" required>
                            </div>
                            <div>
                                <label>Color secundario</label>
                                <input type="text" name="secondary_color" value="{{ $settings['secondary_color'] ?? '#0F172A' }}" required>
                            </div>
                            <div>
                                <label>Color de fondo</label>
                                <input type="text" name="background_color" value="{{ $settings['background_color'] ?? '#F8FAFC' }}" required>
                            </div>
                            <div>
                                <label>Preset visual del sitio</label>
                                <select name="theme_preset" required>
                                    <option value="modern" @selected(($settings['theme_preset'] ?? 'modern') === 'modern')>Moderno</option>
                                    <option value="classic" @selected(($settings['theme_preset'] ?? 'modern') === 'classic')>Clásico</option>
                                </select>
                            </div>
                        </div>

                        <div style="margin-top: 10px;">
                            <label>Título principal</label>
                            <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? '' }}" required>
                        </div>

                        <div style="margin-top: 10px;">
                            <label>Subtítulo principal</label>
                            <textarea name="hero_subtitle" rows="3">{{ $settings['hero_subtitle'] ?? '' }}</textarea>
                        </div>

                        <div style="margin-top: 10px;">
                            <label>Logo principal</label>
                            <input type="file" name="logo" accept="image/*">
                            @if(!empty($settings['logo_path']))
                                <div style="margin-top: 8px;"><img class="preview" src="{{ asset('storage/' . $settings['logo_path']) }}" alt="Logo"></div>
                            @endif
                        </div>

                        <div style="margin-top: 10px;">
                            <label>Imagen de fondo del sitio</label>
                            <input type="file" name="background_image" accept="image/*">
                            @if(!empty($settings['background_image_path']))
                                <div style="margin-top: 8px;"><img class="preview" src="{{ asset('storage/' . $settings['background_image_path']) }}" alt="Fondo"></div>
                            @endif
                        </div>

                        <div style="margin-top: 10px;">
                            <label>Logo footer</label>
                            <input type="file" name="footer_logo" accept="image/*">
                            @if(!empty($settings['footer_logo_path']))
                                <div style="margin-top: 8px;"><img class="preview" src="{{ asset('storage/' . $settings['footer_logo_path']) }}" alt="Logo footer"></div>
                            @endif
                        </div>

                        <div style="margin-top: 10px;">
                            <label>Título footer</label>
                            <input type="text" name="footer_title" value="{{ $settings['footer_title'] ?? '' }}">
                        </div>

                        <div style="margin-top: 10px;">
                            <label>Texto footer</label>
                            <textarea name="footer_text" rows="3">{{ $settings['footer_text'] ?? '' }}</textarea>
                        </div>

                        <hr>
                        <h3 style="margin: 0 0 10px;">Módulo WhatsApp</h3>
                        <div class="grid">
                            <div>
                                <label>Habilitar WhatsApp</label>
                                <input type="hidden" name="whatsapp_enabled" value="0">
                                <input type="checkbox" name="whatsapp_enabled" value="1" @checked(($settings['whatsapp_enabled'] ?? '0') === '1')>
                            </div>
                            <div>
                                <label>Número WhatsApp (con código país)</label>
                                <input type="text" name="whatsapp_phone" value="{{ $settings['whatsapp_phone'] ?? '' }}" placeholder="5491122334455">
                            </div>
                            <div>
                                <label>Mensaje por defecto</label>
                                <input type="text" name="whatsapp_message" value="{{ $settings['whatsapp_message'] ?? 'Hola, quiero más información.' }}">
                            </div>
                            <div>
                                <label>Texto del botón</label>
                                <input type="text" name="whatsapp_button_text" value="{{ $settings['whatsapp_button_text'] ?? 'WhatsApp' }}">
                            </div>
                        </div>

                        <hr>
                        <h3 style="margin: 0 0 10px;">Redes sociales</h3>
                        <div class="grid">
                            <div>
                                <label>Facebook</label>
                                <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}" placeholder="https://facebook.com/tu-pagina">
                            </div>
                            <div>
                                <label>Instagram</label>
                                <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}" placeholder="https://instagram.com/tu-cuenta">
                            </div>
                            <div>
                                <label>LinkedIn</label>
                                <input type="url" name="social_linkedin" value="{{ $settings['social_linkedin'] ?? '' }}" placeholder="https://linkedin.com/company/tu-empresa">
                            </div>
                            <div>
                                <label>YouTube</label>
                                <input type="url" name="social_youtube" value="{{ $settings['social_youtube'] ?? '' }}" placeholder="https://youtube.com/@tu-canal">
                            </div>
                            <div>
                                <label>X / Twitter</label>
                                <input type="url" name="social_x" value="{{ $settings['social_x'] ?? '' }}" placeholder="https://x.com/tu-cuenta">
                            </div>
                        </div>

                        <hr>
                        <h3 style="margin: 0 0 10px;">Módulo de mail (SMTP)</h3>
                        <div class="grid">
                            <div>
                                <label>Habilitar mail personalizado</label>
                                <input type="hidden" name="mail_enabled" value="0">
                                <input type="checkbox" name="mail_enabled" value="1" @checked(($settings['mail_enabled'] ?? '0') === '1')>
                            </div>
                            <div>
                                <label>Mailer</label>
                                <input type="text" name="mail_mailer" value="{{ $settings['mail_mailer'] ?? 'smtp' }}" placeholder="smtp o log">
                            </div>
                            <div>
                                <label>Host SMTP</label>
                                <input type="text" name="mail_host" value="{{ $settings['mail_host'] ?? '' }}" placeholder="smtp.gmail.com">
                            </div>
                            <div>
                                <label>Puerto</label>
                                <input type="number" name="mail_port" value="{{ $settings['mail_port'] ?? '587' }}">
                            </div>
                            <div>
                                <label>Usuario</label>
                                <input type="text" name="mail_username" value="{{ $settings['mail_username'] ?? '' }}">
                            </div>
                            <div>
                                <label>Contraseña SMTP</label>
                                <input type="password" name="mail_password" value="" placeholder="Dejar vacío para conservar la actual">
                            </div>
                            <div>
                                <label>Encriptación</label>
                                <input type="text" name="mail_encryption" value="{{ $settings['mail_encryption'] ?? 'tls' }}" placeholder="tls o ssl">
                            </div>
                            <div>
                                <label>From address</label>
                                <input type="email" name="mail_from_address" value="{{ $settings['mail_from_address'] ?? '' }}">
                            </div>
                            <div>
                                <label>From name</label>
                                <input type="text" name="mail_from_name" value="{{ $settings['mail_from_name'] ?? '' }}">
                            </div>
                        </div>

                        <hr>
                        <h3 style="margin: 0 0 10px;">Módulo Google Analytics</h3>
                        <div class="grid">
                            <div>
                                <label>Habilitar Google Analytics</label>
                                <input type="hidden" name="ga_enabled" value="0">
                                <input type="checkbox" name="ga_enabled" value="1" @checked(($settings['ga_enabled'] ?? '0') === '1')>
                            </div>
                            <div>
                                <label>Measurement ID (GA4)</label>
                                <input type="text" name="ga_measurement_id" value="{{ $settings['ga_measurement_id'] ?? '' }}" placeholder="G-XXXXXXXXXX">
                            </div>
                        </div>

                        <div style="margin-top: 14px;">
                            <button class="btn" type="submit">Guardar configuración</button>
                        </div>
                    </form>
                </div>
            @elseif($currentSection === 'company')
                <div class="panel-head">Datos de la empresa</div>
                <div class="panel-body">
                    <form action="{{ route('admin.company.update') }}" method="POST">
                        @csrf
                        <div class="grid">
                            <div>
                                <label>Razón social / Empresa</label>
                                <input type="text" name="company_name" value="{{ $settings['company_name'] ?? '' }}">
                            </div>
                            <div>
                                <label>CUIT / RUT / NIF</label>
                                <input type="text" name="company_tax_id" value="{{ $settings['company_tax_id'] ?? '' }}">
                            </div>
                            <div>
                                <label>Dirección</label>
                                <input type="text" name="company_address" value="{{ $settings['company_address'] ?? '' }}">
                            </div>
                            <div>
                                <label>Ciudad</label>
                                <input type="text" name="company_city" value="{{ $settings['company_city'] ?? '' }}">
                            </div>
                            <div>
                                <label>Provincia/Estado</label>
                                <input type="text" name="company_state" value="{{ $settings['company_state'] ?? '' }}">
                            </div>
                            <div>
                                <label>País</label>
                                <input type="text" name="company_country" value="{{ $settings['company_country'] ?? '' }}">
                            </div>
                            <div>
                                <label>Código postal</label>
                                <input type="text" name="company_postal_code" value="{{ $settings['company_postal_code'] ?? '' }}">
                            </div>
                            <div>
                                <label>Horario de atención</label>
                                <input type="text" name="company_schedule" value="{{ $settings['company_schedule'] ?? '' }}" placeholder="Lunes a Viernes de 9:00 a 18:00">
                            </div>
                        </div>
                        <div style="margin-top: 14px;">
                            <button class="btn" type="submit">Guardar datos de la empresa</button>
                        </div>
                    </form>
                </div>
            @elseif($currentSection === 'menu')
                <div class="panel-head">Menú del sitio</div>
                <div class="panel-body">
                    <form action="{{ route('admin.menu.default') }}" method="POST" style="margin-bottom: 12px;">
                        @csrf
                        <button class="btn btn-secondary" type="submit">Cargar menú básico por defecto</button>
                    </form>

                    @php
                        $rows = $menuItems->count() > 0 ? $menuItems->values()->all() : [];
                        while (count($rows) < 5) {
                            $rows[] = (object) ['label' => '', 'url' => '', 'sort_order' => count($rows) + 1, 'is_active' => true];
                        }
                    @endphp

                    <form action="{{ route('admin.menu.update') }}" method="POST">
                        @csrf
                        <div class="table-wrap">
                            <table>
                                <thead>
                                <tr>
                                    <th>Etiqueta</th>
                                    <th>URL</th>
                                    <th>Orden</th>
                                    <th>Activo</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rows as $index => $item)
                                    <tr>
                                        <td><input type="text" name="items[{{ $index }}][label]" value="{{ $item->label }}"></td>
                                        <td><input type="text" name="items[{{ $index }}][url]" value="{{ $item->url }}"></td>
                                        <td><input type="number" name="items[{{ $index }}][sort_order]" value="{{ $item->sort_order }}"></td>
                                        <td>
                                            <input type="hidden" name="items[{{ $index }}][is_active]" value="0">
                                            <input type="checkbox" name="items[{{ $index }}][is_active]" value="1" @checked($item->is_active)>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div style="margin-top: 14px;">
                            <button class="btn" type="submit">Guardar menú</button>
                        </div>
                    </form>
                </div>
            @elseif($currentSection === 'sliders')
                <div class="panel-head">Sliders</div>
                <div class="panel-body">
                    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid">
                            <div>
                                <label>Título</label>
                                <input type="text" name="title">
                            </div>
                            <div>
                                <label>Subtítulo</label>
                                <input type="text" name="subtitle">
                            </div>
                            <div>
                                <label>Texto botón</label>
                                <input type="text" name="button_text">
                            </div>
                            <div>
                                <label>Link botón</label>
                                <input type="text" name="button_link">
                            </div>
                            <div>
                                <label>Orden</label>
                                <input type="number" name="sort_order" value="1" required>
                            </div>
                            <div>
                                <label>Imagen slider</label>
                                <input type="file" name="image" accept="image/*" required>
                            </div>
                            <div>
                                <label>Activo</label>
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" checked>
                            </div>
                        </div>
                        <div style="margin-top: 14px;">
                            <button class="btn" type="submit">Agregar slider</button>
                        </div>
                    </form>

                    @if($sliders->isNotEmpty())
                        <hr>

                        <form action="{{ route('admin.sliders.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="table-wrap">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Título</th>
                                        <th>Orden</th>
                                        <th>Activo</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sliders as $slider)
                                        <tr>
                                            <td><img class="preview" src="{{ asset('storage/' . $slider->image_path) }}" alt="Slider"></td>
                                            <td>{{ $slider->title }}</td>
                                            <td><input type="number" name="sliders[{{ $slider->id }}][sort_order]" value="{{ $slider->sort_order }}"></td>
                                            <td>
                                                <input type="hidden" name="sliders[{{ $slider->id }}][is_active]" value="0">
                                                <input type="checkbox" name="sliders[{{ $slider->id }}][is_active]" value="1" @checked($slider->is_active)>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div style="margin-top: 14px;">
                                <button class="btn" type="submit">Guardar cambios en sliders</button>
                            </div>
                        </form>

                        <div style="margin-top: 10px;" class="btn-row">
                            @foreach($sliders as $slider)
                                <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" style="display:inline-block; margin-right:8px; margin-bottom:8px;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Eliminar #{{ $slider->id }}</button>
                                </form>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div class="panel-head">Cambiar contraseña</div>
                <div class="panel-body">
                    <form action="{{ route('admin.password.update') }}" method="POST">
                        @csrf
                        <div class="grid">
                            <div>
                                <label>Contraseña actual</label>
                                <input type="password" name="current_password" required>
                            </div>
                            <div>
                                <label>Nueva contraseña</label>
                                <input type="password" name="new_password" required>
                            </div>
                            <div>
                                <label>Confirmar nueva contraseña</label>
                                <input type="password" name="new_password_confirmation" required>
                            </div>
                        </div>
                        <div style="margin-top: 14px;">
                            <button class="btn" type="submit">Actualizar contraseña</button>
                        </div>
                    </form>
                </div>
            @endif
        </main>
    </div>
</div>
</body>
</html>
