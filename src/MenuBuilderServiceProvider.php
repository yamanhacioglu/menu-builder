<?php

namespace YamanHacioglu\MenuBuilder;

use CodexShaper\Menu\Commands\InstallMenuBuilder;
use CodexShaper\Menu\MenuBuilder;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class MenuBuilderServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'menu');
    }

    public function register(): void
    {
        $this->app->singleton('menu', function () {
            return new MenuBuilder();
        });
        $this->mergeConfigFrom(
            __DIR__.'/../config/menu.php',
            'config'
        );
        $this->loadHelpers();
        $this->registerBladeDirectives();
        $this->registerPublish();
        $this->registerCommands();
    }

    protected function registerBladeDirectives(): void
    {
        $this->app->afterResolving('blade.compiler', function (BladeCompiler $blade) {
            $blade->directive('menu', function ($name) {
                return "<?php menu($name) ?>";
            });
        });
    }

    protected function loadHelpers()
    {
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }

    protected function registerPublish()
    {
        $publishable = [
            'menu.config' => [
                __DIR__.'/../config/menu.php' => config_path('menu.php'),
            ],
            'menu.seeds' => [
                __DIR__.'/../database/seeds/' => database_path('seeds'),
            ],
            'menu.views' => [
                __DIR__.'/../resources/views' => resource_path('views/vendor/menus/views'),
            ],
            'menu.resources' => [
                __DIR__.'/../resources' => resource_path('views/vendor/menus'),
            ],
        ];

        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }

    private function registerCommands(): void
    {
        $this->commands(InstallMenuBuilder::class);
    }
}
