<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultSettings = [
            'site_name' => 'Mi Sitio Institucional',
            'hero_title' => 'Bienvenidos a nuestra institución',
            'hero_subtitle' => 'Contenido 100% administrable desde el panel',
            'company_name' => 'Mi Empresa S.A.',
            'company_tax_id' => '',
            'company_address' => '',
            'company_city' => '',
            'company_state' => '',
            'company_country' => '',
            'company_postal_code' => '',
            'company_schedule' => '',
            'contact_email' => 'info@institucional.local',
            'contact_phone' => '+54 11 0000 0000',
            'primary_color' => '#1D4ED8',
            'secondary_color' => '#0F172A',
            'background_color' => '#F8FAFC',
            'theme_preset' => 'modern',
            'background_image_path' => '',
            'footer_title' => 'Mi Sitio Institucional',
            'footer_text' => 'Soluciones institucionales adaptadas a tu organización.',
            'whatsapp_enabled' => '1',
            'whatsapp_phone' => '',
            'whatsapp_message' => 'Hola, quiero más información.',
            'whatsapp_button_text' => 'WhatsApp',
            'social_facebook' => '',
            'social_instagram' => '',
            'social_linkedin' => '',
            'social_youtube' => '',
            'social_x' => '',
            'mail_enabled' => '0',
            'mail_mailer' => 'smtp',
            'mail_host' => '',
            'mail_port' => '587',
            'mail_username' => '',
            'mail_encryption' => 'tls',
            'mail_from_address' => 'no-reply@institucional.local',
            'mail_from_name' => 'Sitio Institucional',
            'ga_enabled' => '0',
            'ga_measurement_id' => '',
        ];

        foreach ($defaultSettings as $key => $value) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        if (!MenuItem::query()->exists()) {
            $defaults = [
                ['label' => 'Inicio', 'url' => '/', 'sort_order' => 1, 'is_active' => true],
                ['label' => 'Nosotros', 'url' => '#nosotros', 'sort_order' => 2, 'is_active' => true],
                ['label' => 'Servicios', 'url' => '#servicios', 'sort_order' => 3, 'is_active' => true],
                ['label' => 'Empresa', 'url' => '#empresa', 'sort_order' => 4, 'is_active' => true],
                ['label' => 'Contacto', 'url' => '#contacto', 'sort_order' => 5, 'is_active' => true],
            ];

            foreach ($defaults as $item) {
                MenuItem::query()->create($item);
            }
        }
    }
}
