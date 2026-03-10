<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['site_name'] ?? 'Sitio institucional' }}</title>
    @if(($settings['ga_enabled'] ?? '0') === '1' && !empty($settings['ga_measurement_id']))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings['ga_measurement_id'] }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $settings['ga_measurement_id'] }}');
        </script>
    @endif
    <style>
        :root {
            --primary: {{ $settings['primary_color'] ?? '#1D4ED8' }};
            --secondary: {{ $settings['secondary_color'] ?? '#0F172A' }};
            --background: {{ $settings['background_color'] ?? '#F8FAFC' }};
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--background);
            color: #111827;
            line-height: 1.5;
        }
        .container {
            width: min(1260px, 94%);
            margin: 0 auto;
        }
        header {
            background: linear-gradient(135deg, var(--secondary), #111827);
            color: white;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.26);
            position: sticky;
            top: 0;
            z-index: 40;
            transition: box-shadow .25s ease, background .25s ease;
        }
        header.is-scrolled {
            background: linear-gradient(135deg, #0b1220, #0f172a);
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.35);
        }
        .topbar {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 12px 0;
            gap: 16px;
            text-align: center;
        }
        .logo img {
            max-height: 54px;
            width: auto;
            display: block;
            margin: 0 auto;
        }
        .menu-toggle {
            display: none;
            border: 1px solid rgba(255,255,255,0.3);
            background: transparent;
            color: #fff;
            border-radius: 8px;
            padding: 8px 12px;
            font-weight: 700;
            cursor: pointer;
        }
        nav ul {
            list-style: none;
            display: flex;
            gap: 10px;
            margin: 0;
            padding: 0;
            flex-wrap: wrap;
            justify-content: center;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            padding: 8px 12px;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,0.2);
            transition: background .2s ease, transform .2s ease;
        }
        header.is-scrolled nav a {
            border-color: rgba(255,255,255,0.35);
            background: rgba(255,255,255,0.06);
            transform: translateY(-1px);
        }
        nav a:hover {
            background: rgba(255,255,255,0.14);
            transform: translateY(-1px);
        }
        .hero {
            padding: 84px 0 52px;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 55%, transparent 100%);
        }
        .hero-shell {
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid #E5E7EB;
            border-radius: 18px;
            padding: 26px;
            box-shadow: 0 18px 34px rgba(15, 23, 42, 0.08);
        }
        .hero-kicker {
            display: inline-block;
            font-size: 12px;
            letter-spacing: .08em;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--primary);
            background: rgba(29, 78, 216, 0.12);
            border: 1px solid rgba(29, 78, 216, 0.28);
            padding: 5px 10px;
            border-radius: 999px;
            margin-bottom: 12px;
        }
        h1 {
            margin: 0 0 12px;
            color: var(--secondary);
            font-size: clamp(28px, 4vw, 44px);
        }
        .hero p {
            margin: 0;
            max-width: 700px;
            color: #334155;
            font-size: 18px;
        }
        .hero-quick {
            margin-top: 16px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .hero-quick span {
            border: 1px solid #E2E8F0;
            background: #fff;
            border-radius: 999px;
            padding: 7px 11px;
            font-size: 13px;
            color: #334155;
        }
        .slider-wrap {
            position: relative;
            margin-top: 28px;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #E5E7EB;
            box-shadow: 0 14px 28px rgba(15,23,42,.09);
            background: #fff;
        }
        .slider-track {
            display: flex;
            transition: transform .6s cubic-bezier(.22,.61,.36,1);
            will-change: transform;
        }
        .slide {
            min-width: 100%;
            background: white;
            display: grid;
            grid-template-columns: 1.1fr .9fr;
        }
        .slide img {
            width: 100%;
            height: 100%;
            min-height: 280px;
            object-fit: cover;
            display: block;
            transform: scale(1.04);
            opacity: .82;
            transition: transform .75s cubic-bezier(.22,.61,.36,1), opacity .55s ease;
        }
        .slide-content {
            padding: 22px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            opacity: .72;
            transform: translateY(10px);
            transition: opacity .45s ease, transform .55s cubic-bezier(.22,.61,.36,1);
        }
        .slide.is-active img { transform: scale(1); opacity: 1; }
        .slide.is-active .slide-content { opacity: 1; transform: translateY(0); }
        .slide h3 {
            margin: 0 0 8px;
            color: var(--secondary);
            font-size: clamp(20px, 2.8vw, 30px);
        }
        .slide p { margin: 0; color: #334155; }
        .btn {
            display: inline-block;
            margin-top: 10px;
            background: var(--primary);
            color: white;
            text-decoration: none;
            padding: 9px 15px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 700;
        }
        .slider-control {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
            width: 38px;
            height: 38px;
            border-radius: 999px;
            background: rgba(17, 24, 39, 0.62);
            color: #fff;
            font-size: 22px;
            line-height: 1;
            cursor: pointer;
            z-index: 4;
        }
        .slider-control.prev { left: 10px; }
        .slider-control.next { right: 10px; }
        .slider-dots {
            position: absolute;
            left: 50%;
            bottom: 12px;
            transform: translateX(-50%);
            display: flex;
            gap: 7px;
            z-index: 4;
        }
        .slider-dot {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            border: 0;
            padding: 0;
            background: rgba(255,255,255,.6);
            cursor: pointer;
        }
        .slider-dot.is-active { background: #fff; }
        section {
            padding: 28px 0;
        }
        .section-title {
            margin: 0 0 12px;
            color: var(--secondary);
            font-size: clamp(22px, 3vw, 30px);
        }
        .card {
            background: white;
            border-radius: 14px;
            border: 1px solid #E5E7EB;
            padding: 22px;
            box-shadow: 0 12px 24px rgba(15,23,42,.07);
        }
        .card p {
            margin: 0;
            color: #334155;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            margin-top: 8px;
        }
        .info-item {
            border: 1px solid #E5E7EB;
            border-radius: 10px;
            padding: 10px 12px;
            background: #F8FAFC;
        }
        .info-item strong {
            display: block;
            color: #0F172A;
            margin-bottom: 3px;
            font-size: 13px;
        }
        footer {
            padding: 28px 0;
            background: linear-gradient(135deg, var(--secondary), #111827);
            color: white;
            margin-top: 34px;
        }
        .footer-wrap {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }
        .footer-logo img {
            max-height: 48px;
            width: auto;
        }
        .socials {
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .socials a {
            color: #fff;
            text-decoration: none;
            border: 1px solid rgba(255,255,255,.35);
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 13px;
        }
        .whatsapp-float {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 80;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #25D366;
            color: #fff;
            text-decoration: none;
            padding: 12px 16px;
            border-radius: 999px;
            font-weight: 700;
            box-shadow: 0 12px 24px rgba(0,0,0,.22);
        }
        .whatsapp-float svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
            display: block;
        }
        @media (max-width: 860px) {
            .topbar { align-items: flex-start; }
            .menu-toggle { display: inline-block; }
            nav { width: 100%; }
            nav ul {
                display: none;
                width: 100%;
                flex-direction: column;
                margin-top: 10px;
            }
            nav ul.is-open { display: flex; }
            nav a { width: 100%; border-radius: 10px; }
            .logo { width: 100%; text-align: center; }
            .topbar { align-items: center; }
            .menu-toggle { margin: 0 auto; display: block; }
            .hero { padding: 44px 0 20px; }
            .hero-shell { padding: 18px; }
            .hero p { font-size: 16px; }
            .slide {
                grid-template-columns: 1fr;
            }
            .slide img { min-height: 220px; }
            .slide-content { padding: 16px; }
            section { padding: 18px 0; }
            .card { padding: 16px; }
        }
        @media (max-width: 640px) {
            body { font-size: 15px; }
            .whatsapp-float {
                right: 12px;
                bottom: 12px;
                padding: 10px 14px;
            }
        }

        body.theme-classic header {
            background: var(--secondary);
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.22);
        }
        body.theme-classic header.is-scrolled {
            background: var(--secondary);
            box-shadow: 0 6px 14px rgba(15, 23, 42, 0.28);
        }
        body.theme-classic nav a,
        body.theme-classic .btn,
        body.theme-classic .socials a,
        body.theme-classic .whatsapp-float {
            border-radius: 10px;
        }
        body.theme-classic .hero-shell,
        body.theme-classic .slider-wrap,
        body.theme-classic .slide,
        body.theme-classic .card,
        body.theme-classic .info-item {
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(15, 23, 42, 0.06);
        }
        body.theme-classic .hero-kicker {
            border-radius: 8px;
            background: rgba(15, 23, 42, 0.08);
            border-color: rgba(15, 23, 42, 0.18);
            color: var(--secondary);
        }
    </style>
</head>
<body class="theme-{{ $settings['theme_preset'] ?? 'modern' }}">
@php
    $socialLinks = [
        'Facebook' => $settings['social_facebook'] ?? null,
        'Instagram' => $settings['social_instagram'] ?? null,
        'LinkedIn' => $settings['social_linkedin'] ?? null,
        'YouTube' => $settings['social_youtube'] ?? null,
        'X' => $settings['social_x'] ?? null,
    ];

    $whatsappSourcePhone = $settings['whatsapp_phone'] ?? ($settings['contact_phone'] ?? '');
    $whatsappPhone = preg_replace('/\D+/', '', $whatsappSourcePhone);
    $whatsappMessage = $settings['whatsapp_message'] ?? 'Hola, quiero más información.';
    $whatsappText = $settings['whatsapp_button_text'] ?? 'WhatsApp';
    $whatsappUrl = !empty($whatsappPhone)
        ? 'https://wa.me/' . $whatsappPhone . '?text=' . urlencode($whatsappMessage)
        : null;
@endphp
@if(!empty($settings['background_image_path']))
    <style>
        body {
            background-image: linear-gradient(rgba(248,250,252,.92), rgba(248,250,252,.92)), url('{{ asset('storage/' . $settings['background_image_path']) }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        @media (max-width: 860px) {
            body { background-attachment: scroll; }
        }
    </style>
@endif
<header>
    <div class="container topbar">
        <div class="logo">
            @if(!empty($settings['logo_path']))
                <img src="{{ asset('storage/' . $settings['logo_path']) }}" alt="Logo">
            @else
                <strong>{{ $settings['site_name'] ?? 'Sitio institucional' }}</strong>
            @endif
        </div>
        <nav>
            <button type="button" class="menu-toggle" data-menu-toggle>Menú</button>
            <ul>
                @foreach($menuItems as $item)
                    <li><a href="{{ $item->url }}">{{ $item->label }}</a></li>
                @endforeach
            </ul>
        </nav>
    </div>
</header>

<main>
    <section class="hero">
        <div class="container">
            <div class="hero-shell">
                <span class="hero-kicker">Sitio institucional</span>
                <h1>{{ $settings['hero_title'] ?? 'Bienvenidos' }}</h1>
                <p>{{ $settings['hero_subtitle'] ?? '' }}</p>
                <div class="hero-quick">
                    <span>Gestión simple</span>
                    <span>Contenido administrable</span>
                    <span>Diseño responsive</span>
                </div>
            </div>

            @if($sliders->isNotEmpty())
                <div class="slider-wrap" data-slider-wrap>
                    <div class="slider-track" data-slider-track>
                    @foreach($sliders as $slider)
                        <article class="slide" data-slide>
                            <img src="{{ asset('storage/' . $slider->image_path) }}" alt="Slider">
                            <div class="slide-content">
                                @if($slider->title)
                                    <h3>{{ $slider->title }}</h3>
                                @endif
                                @if($slider->subtitle)
                                    <p>{{ $slider->subtitle }}</p>
                                @endif
                                @if($slider->button_text && $slider->button_link)
                                    <a href="{{ $slider->button_link }}" class="btn">{{ $slider->button_text }}</a>
                                @endif
                            </div>
                        </article>
                    @endforeach
                    </div>
                    @if($sliders->count() > 1)
                        <button type="button" class="slider-control prev" data-slider-prev aria-label="Anterior">‹</button>
                        <button type="button" class="slider-control next" data-slider-next aria-label="Siguiente">›</button>
                        <div class="slider-dots" data-slider-dots>
                            @foreach($sliders as $slider)
                                <button type="button" class="slider-dot @if($loop->first) is-active @endif" data-slider-dot="{{ $loop->index }}" aria-label="Ir al slide {{ $loop->iteration }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <section id="nosotros">
        <div class="container card">
            <h2 class="section-title">Nosotros</h2>
            <p>Este bloque es editable desde el panel de administración en una próxima iteración del proyecto.</p>
        </div>
    </section>

    <section id="servicios">
        <div class="container card">
            <h2 class="section-title">Servicios</h2>
            <p>Podés usar esta sección para destacar tus servicios institucionales principales.</p>
        </div>
    </section>

    <section id="empresa">
        <div class="container card">
            <h2 class="section-title">Datos de la empresa</h2>
            <div class="info-grid">
            @if(!empty($settings['company_name']))
                <div class="info-item"><strong>Empresa</strong>{{ $settings['company_name'] }}</div>
            @endif
            @if(!empty($settings['company_tax_id']))
                <div class="info-item"><strong>Identificación fiscal</strong>{{ $settings['company_tax_id'] }}</div>
            @endif
            @if(!empty($settings['company_address']))
                <div class="info-item"><strong>Dirección</strong>{{ $settings['company_address'] }}</div>
            @endif
            @if(!empty($settings['company_city']) || !empty($settings['company_state']) || !empty($settings['company_country']))
                <div class="info-item">
                    <strong>Ubicación</strong>
                    {{ $settings['company_city'] ?? '' }}
                    {{ !empty($settings['company_state']) ? ', ' . $settings['company_state'] : '' }}
                    {{ !empty($settings['company_country']) ? ', ' . $settings['company_country'] : '' }}
                </div>
            @endif
            @if(!empty($settings['company_postal_code']))
                <div class="info-item"><strong>Código postal</strong>{{ $settings['company_postal_code'] }}</div>
            @endif
            @if(!empty($settings['company_schedule']))
                <div class="info-item"><strong>Horario de atención</strong>{{ $settings['company_schedule'] }}</div>
            @endif
            </div>
            @if(
                empty($settings['company_name']) &&
                empty($settings['company_tax_id']) &&
                empty($settings['company_address']) &&
                empty($settings['company_city']) &&
                empty($settings['company_state']) &&
                empty($settings['company_country']) &&
                empty($settings['company_postal_code']) &&
                empty($settings['company_schedule'])
            )
                <p style="margin-top:10px;">Completá estos datos desde el panel de administración.</p>
            @endif
        </div>
    </section>

    <section id="contacto">
        <div class="container card">
            <h2 class="section-title">Contacto</h2>
            <div class="info-grid">
                <div class="info-item">
                    <strong>Email</strong>
                    {{ $settings['contact_email'] ?? '-' }}
                </div>
                <div class="info-item">
                    <strong>Teléfono</strong>
                    {{ $settings['contact_phone'] ?? '-' }}
                </div>
            </div>
        </div>
    </section>
</main>

<footer>
    <div class="container footer-wrap">
        <div>
            <strong>{{ $settings['footer_title'] ?? ($settings['site_name'] ?? 'Sitio institucional') }}</strong>
            <div style="margin-top:6px; opacity:.9;">
                {{ $settings['footer_text'] ?? '' }}
            </div>
            <div style="margin-top:6px; opacity:.8;">© {{ date('Y') }} {{ $settings['site_name'] ?? 'Sitio institucional' }}</div>
            <div class="socials">
                @foreach($socialLinks as $socialName => $socialUrl)
                    @if(!empty($socialUrl))
                        <a href="{{ $socialUrl }}" target="_blank" rel="noopener noreferrer">{{ $socialName }}</a>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="footer-logo">
            @if(!empty($settings['footer_logo_path']))
                <img src="{{ asset('storage/' . $settings['footer_logo_path']) }}" alt="Logo footer">
            @elseif(!empty($settings['logo_path']))
                <img src="{{ asset('storage/' . $settings['logo_path']) }}" alt="Logo">
            @endif
        </div>
    </div>
</footer>

@if(($settings['whatsapp_enabled'] ?? '1') === '1' && !empty($whatsappUrl))
    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="whatsapp-float">
        <svg viewBox="0 0 32 32" aria-hidden="true" focusable="false">
            <path d="M19.11 17.32c-.29-.14-1.72-.85-1.99-.95-.27-.1-.47-.14-.66.14-.19.29-.76.95-.93 1.14-.17.19-.34.22-.63.07-.29-.14-1.23-.45-2.34-1.45-.86-.77-1.45-1.72-1.61-2.01-.17-.29-.02-.44.12-.58.13-.13.29-.34.43-.51.14-.17.19-.29.29-.48.1-.19.05-.36-.02-.51-.07-.14-.66-1.59-.91-2.17-.24-.58-.48-.5-.66-.5h-.56c-.19 0-.51.07-.78.36-.27.29-1.03 1.01-1.03 2.45s1.05 2.83 1.19 3.03c.14.19 2.06 3.14 4.99 4.4.7.3 1.25.48 1.67.62.7.22 1.34.19 1.84.12.56-.08 1.72-.7 1.96-1.37.24-.67.24-1.24.17-1.36-.07-.12-.27-.19-.56-.33z"></path>
            <path d="M27.46 4.52A15.85 15.85 0 0 0 16.2 0C7.35 0 .15 7.2.15 16.05c0 2.83.74 5.6 2.14 8.04L0 32l8.12-2.13a16.01 16.01 0 0 0 8.06 2.19h.01c8.85 0 16.05-7.2 16.05-16.05 0-4.28-1.66-8.29-4.78-11.49zM16.2 29.2h-.01a13.2 13.2 0 0 1-6.72-1.83l-.48-.29-4.82 1.27 1.29-4.69-.31-.49a13.15 13.15 0 0 1-2.03-7.12C3.12 8.78 8.93 2.97 16.2 2.97c3.52 0 6.83 1.37 9.32 3.86a13.1 13.1 0 0 1 3.89 9.22c0 7.27-5.81 13.15-13.21 13.15z"></path>
        </svg>
        <span>{{ $whatsappText }}</span>
    </a>
@endif
<script>
    (() => {
        const header = document.querySelector('header');
        const toggle = document.querySelector('[data-menu-toggle]');
        const menu = document.querySelector('nav ul');

        if (!toggle || !menu) {
            return;
        }

        toggle.addEventListener('click', () => {
            menu.classList.toggle('is-open');
        });

        menu.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 860) {
                    menu.classList.remove('is-open');
                }
            });
        });

        const syncHeaderScrollState = () => {
            if (!header) {
                return;
            }

            header.classList.toggle('is-scrolled', window.scrollY > 14);
        };

        syncHeaderScrollState();
        window.addEventListener('scroll', syncHeaderScrollState, { passive: true });

        const sliderWrap = document.querySelector('[data-slider-wrap]');
        if (!sliderWrap) {
            return;
        }

        const sliderTrack = sliderWrap.querySelector('[data-slider-track]');
        const slides = Array.from(sliderWrap.querySelectorAll('[data-slide]'));
        const prev = sliderWrap.querySelector('[data-slider-prev]');
        const next = sliderWrap.querySelector('[data-slider-next]');
        const dots = Array.from(sliderWrap.querySelectorAll('[data-slider-dot]'));

        if (!sliderTrack || slides.length <= 1) {
            return;
        }

        let current = 0;
        let timerId = null;
        let touchStartX = 0;
        let touchEndX = 0;

        const paint = () => {
            sliderTrack.style.transform = `translateX(-${current * 100}%)`;
            dots.forEach((dot, index) => {
                dot.classList.toggle('is-active', index === current);
            });
            slides.forEach((slide, index) => {
                slide.classList.toggle('is-active', index === current);
            });
        };

        const goTo = (index) => {
            current = (index + slides.length) % slides.length;
            paint();
        };

        const start = () => {
            if (document.hidden) {
                return;
            }
            timerId = window.setInterval(() => {
                goTo(current + 1);
            }, 4800);
        };

        const restart = () => {
            if (timerId) {
                window.clearInterval(timerId);
            }
            start();
        };

        prev?.addEventListener('click', () => {
            goTo(current - 1);
            restart();
        });

        next?.addEventListener('click', () => {
            goTo(current + 1);
            restart();
        });

        dots.forEach((dot) => {
            dot.addEventListener('click', () => {
                const index = Number(dot.dataset.sliderDot || 0);
                goTo(index);
                restart();
            });
        });

        sliderWrap.addEventListener('mouseenter', () => {
            if (timerId) {
                window.clearInterval(timerId);
            }
        });

        sliderWrap.addEventListener('mouseleave', () => {
            restart();
        });

        sliderWrap.addEventListener('touchstart', (event) => {
            touchStartX = event.changedTouches[0].clientX;
            touchEndX = touchStartX;
            if (timerId) {
                window.clearInterval(timerId);
            }
        }, { passive: true });

        sliderWrap.addEventListener('touchmove', (event) => {
            touchEndX = event.changedTouches[0].clientX;
        }, { passive: true });

        sliderWrap.addEventListener('touchend', () => {
            const distance = touchStartX - touchEndX;
            const minSwipe = 40;

            if (Math.abs(distance) >= minSwipe) {
                if (distance > 0) {
                    goTo(current + 1);
                } else {
                    goTo(current - 1);
                }
            }

            restart();
        });

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                if (timerId) {
                    window.clearInterval(timerId);
                    timerId = null;
                }
                return;
            }

            restart();
        });

        paint();
        start();
    })();
</script>
</body>
</html>
