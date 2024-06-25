<?php

namespace CodeRomeos\BagistoShiprocket\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class BagistoShiprocketServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Routes/admin-routes.php');

        $this->loadRoutesFrom(__DIR__ . '/../Routes/shop-routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'bagistoshiprocket');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'bagistoshiprocket');

        Event::listen('bagisto.admin.layout.head', function ($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('bagistoshiprocket::admin.layouts.style');
        });

        Blade::component('bagistoshiprocket::shop.components.pincode-availability', 'bagistoshiprocket::pincode-availability');

        $this->registerBladeDirectives();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/admin-menu.php',
            'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php',
            'acl'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/shiprocket.php',
            'shiprocket'
        );
    }

    protected function registerBladeDirectives()
    {
        Blade::directive('shiprocketPincode', function ($pincode) {
            return "<?php echo 'check'; ?>";
        });
    }
}
