<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\SiteSetting;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        return Redirect::route('admin.settings.page');
    }

    public function showSettingsPage()
    {
        return $this->renderAdminPage('settings');
    }

    public function showCompanyPage()
    {
        return $this->renderAdminPage('company');
    }

    public function showMenuPage()
    {
        return $this->renderAdminPage('menu');
    }

    public function showSlidersPage()
    {
        return $this->renderAdminPage('sliders');
    }

    public function showPasswordPage()
    {
        return $this->renderAdminPage('password');
    }

    private function renderAdminPage(string $currentSection)
    {
        $settings = SiteSetting::query()->pluck('value', 'key');
        $menuItems = MenuItem::query()->orderBy('sort_order')->get();
        $sliders = Slider::query()->orderBy('sort_order')->get();

        return view('admin.dashboard', compact('settings', 'menuItems', 'sliders', 'currentSection'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:120'],
            'hero_title' => ['required', 'string', 'max:180'],
            'hero_subtitle' => ['nullable', 'string', 'max:500'],
            'contact_email' => ['nullable', 'email', 'max:120'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'primary_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'secondary_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'background_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_preset' => ['required', 'in:modern,classic'],
            'background_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'footer_title' => ['nullable', 'string', 'max:160'],
            'footer_text' => ['nullable', 'string', 'max:500'],
            'whatsapp_enabled' => ['nullable', 'boolean'],
            'whatsapp_phone' => ['nullable', 'string', 'max:30'],
            'whatsapp_message' => ['nullable', 'string', 'max:250'],
            'whatsapp_button_text' => ['nullable', 'string', 'max:40'],
            'social_facebook' => ['nullable', 'url', 'max:255'],
            'social_instagram' => ['nullable', 'url', 'max:255'],
            'social_linkedin' => ['nullable', 'url', 'max:255'],
            'social_youtube' => ['nullable', 'url', 'max:255'],
            'social_x' => ['nullable', 'url', 'max:255'],
            'mail_enabled' => ['nullable', 'boolean'],
            'mail_mailer' => ['nullable', 'in:smtp,log'],
            'mail_host' => ['nullable', 'string', 'max:180'],
            'mail_port' => ['nullable', 'integer', 'min:1', 'max:65535'],
            'mail_username' => ['nullable', 'string', 'max:180'],
            'mail_password' => ['nullable', 'string', 'max:255'],
            'mail_encryption' => ['nullable', 'in:tls,ssl'],
            'mail_from_address' => ['nullable', 'email', 'max:180'],
            'mail_from_name' => ['nullable', 'string', 'max:120'],
            'ga_enabled' => ['nullable', 'boolean'],
            'ga_measurement_id' => ['nullable', 'regex:/^G-[A-Z0-9]+$/'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'footer_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ]);

        foreach ([
            'site_name',
            'hero_title',
            'hero_subtitle',
            'contact_email',
            'contact_phone',
            'primary_color',
            'secondary_color',
            'background_color',
            'theme_preset',
            'footer_title',
            'footer_text',
            'whatsapp_phone',
            'whatsapp_message',
            'whatsapp_button_text',
            'social_facebook',
            'social_instagram',
            'social_linkedin',
            'social_youtube',
            'social_x',
            'mail_mailer',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_encryption',
            'mail_from_address',
            'mail_from_name',
            'ga_measurement_id',
        ] as $key) {
            SiteSetting::setValue($key, $validated[$key] ?? null);
        }

        SiteSetting::setValue('mail_enabled', $request->boolean('mail_enabled') ? '1' : '0');
        SiteSetting::setValue('ga_enabled', $request->boolean('ga_enabled') ? '1' : '0');
        SiteSetting::setValue('whatsapp_enabled', $request->boolean('whatsapp_enabled') ? '1' : '0');

        if (!empty($validated['mail_password'])) {
            SiteSetting::setValue('mail_password', $validated['mail_password']);
        }

        if ($request->hasFile('logo')) {
            $previousLogoPath = SiteSetting::getValue('logo_path');
            if ($previousLogoPath) {
                Storage::disk('public')->delete($previousLogoPath);
            }

            $logoPath = $request->file('logo')->store('branding', 'public');
            SiteSetting::setValue('logo_path', $logoPath);
        }

        if ($request->hasFile('footer_logo')) {
            $previousFooterLogoPath = SiteSetting::getValue('footer_logo_path');
            if ($previousFooterLogoPath) {
                Storage::disk('public')->delete($previousFooterLogoPath);
            }

            $footerLogoPath = $request->file('footer_logo')->store('branding', 'public');
            SiteSetting::setValue('footer_logo_path', $footerLogoPath);
        }

        if ($request->hasFile('background_image')) {
            $previousBackgroundImagePath = SiteSetting::getValue('background_image_path');
            if ($previousBackgroundImagePath) {
                Storage::disk('public')->delete($previousBackgroundImagePath);
            }

            $backgroundImagePath = $request->file('background_image')->store('backgrounds', 'public');
            SiteSetting::setValue('background_image_path', $backgroundImagePath);
        }

        return back()->with('status', 'Configuración guardada correctamente.');
    }

    public function updateCompanySettings(Request $request)
    {
        $validated = $request->validate([
            'company_name' => ['nullable', 'string', 'max:160'],
            'company_tax_id' => ['nullable', 'string', 'max:60'],
            'company_address' => ['nullable', 'string', 'max:180'],
            'company_city' => ['nullable', 'string', 'max:80'],
            'company_state' => ['nullable', 'string', 'max:80'],
            'company_country' => ['nullable', 'string', 'max:80'],
            'company_postal_code' => ['nullable', 'string', 'max:20'],
            'company_schedule' => ['nullable', 'string', 'max:180'],
        ]);

        foreach ([
            'company_name',
            'company_tax_id',
            'company_address',
            'company_city',
            'company_state',
            'company_country',
            'company_postal_code',
            'company_schedule',
        ] as $key) {
            SiteSetting::setValue($key, $validated[$key] ?? null);
        }

        return back()->with('status', 'Datos de la empresa actualizados.');
    }

    public function updateMenu(Request $request)
    {
        $validated = $request->validate([
            'items' => ['required', 'array'],
            'items.*.label' => ['nullable', 'string', 'max:80'],
            'items.*.url' => ['nullable', 'string', 'max:200'],
            'items.*.sort_order' => ['nullable', 'integer', 'min:0'],
            'items.*.is_active' => ['nullable', 'boolean'],
        ]);

        $items = collect($validated['items'])
            ->filter(fn ($item) => !empty($item['label']) && !empty($item['url']))
            ->values();

        if ($items->isEmpty()) {
            return back()->withErrors(['items' => 'Debes cargar al menos un ítem de menú válido.']);
        }

        MenuItem::query()->delete();

        foreach ($items as $index => $item) {
            MenuItem::query()->create([
                'label' => $item['label'],
                'url' => $item['url'],
                'sort_order' => $item['sort_order'] ?? $index,
                'is_active' => (bool) ($item['is_active'] ?? false),
            ]);
        }

        return back()->with('status', 'Menú actualizado.');
    }

    public function resetMenuDefaults()
    {
        MenuItem::query()->delete();

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

        return back()->with('status', 'Menú básico por defecto cargado.');
    }

    public function storeSlider(Request $request)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:120'],
            'subtitle' => ['nullable', 'string', 'max:300'],
            'button_text' => ['nullable', 'string', 'max:40'],
            'button_link' => ['nullable', 'string', 'max:200'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $imagePath = $request->file('image')->store('sliders', 'public');

        Slider::query()->create([
            'title' => $validated['title'] ?? null,
            'subtitle' => $validated['subtitle'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'button_link' => $validated['button_link'] ?? null,
            'sort_order' => $validated['sort_order'],
            'is_active' => (bool) ($validated['is_active'] ?? false),
            'image_path' => $imagePath,
        ]);

        return back()->with('status', 'Slider agregado.');
    }

    public function updateSliders(Request $request)
    {
        $validated = $request->validate([
            'sliders' => ['required', 'array'],
            'sliders.*.sort_order' => ['required', 'integer', 'min:0'],
            'sliders.*.is_active' => ['nullable', 'boolean'],
        ]);

        foreach ($validated['sliders'] as $sliderId => $sliderData) {
            $slider = Slider::query()->find($sliderId);
            if (!$slider) {
                continue;
            }

            $slider->update([
                'sort_order' => $sliderData['sort_order'],
                'is_active' => (bool) ($sliderData['is_active'] ?? false),
            ]);
        }

        return back()->with('status', 'Sliders actualizados.');
    }

    public function destroySlider(Slider $slider)
    {
        Storage::disk('public')->delete($slider->image_path);
        $slider->delete();

        return back()->with('status', 'Slider eliminado.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return back()->with('status', 'Contraseña actualizada con éxito.');
    }
}
