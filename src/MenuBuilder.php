<?php

namespace YamanHacioglu\MenuBuilder;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use YamanHacioglu\MenuBuilder\Models\Menu;
use YamanHacioglu\MenuBuilder\Models\MenuConfig;
use YamanHacioglu\MenuBuilder\Models\MenuItem;

class MenuBuilder
{
    public function routes()
    {
        require __DIR__.'/../routes/menu-builder.php';
    }

    public function getSettings($menu_id): array
    {
        $settings = MenuConfig::query()->where('menu_id', '=', $menu_id)->first();
        $defaultSettings = MenuConfig::query()->whereNull('menu_id')->first();

        $depth = (! empty($settings) && $settings->depth)
            ? $settings->depth
            : ((! empty($defaultSettings) && $defaultSettings->depth)
                ? $defaultSettings->depth : config('menu-builder.depth'));

        $apply_child_as_parent = (! empty($settings) && $settings->apply_child_as_parent)
            ? $settings->apply_child_as_parent
            : ((! empty($defaultSettings) && $defaultSettings->apply_child_as_parent)
                ? $defaultSettings->apply_child_as_parent : config('menu-builder.apply_child_as_parent'));

        $levels = (! empty($settings) && $settings->levels)
            ? $settings->levels
            : ((! empty($defaultSettings) && $defaultSettings->levels)
                ? $defaultSettings->levels : config('menu-builder.levels'));

        return [
            'depth' => $depth,
            'apply_child_as_parent' => $apply_child_as_parent,
            'levels' => $levels,
        ];
    }

    public function generateMenu($name): void
    {
        if (is_numeric($name)) {
            $menuHtml = $this->getMenu($name);
        } elseif (is_string($name)) {
            if ($menu = Menu::query()->where('slug', '=', Str::slug($name))->first()) {
                $menuHtml = $this->getMenu($menu->id);
            }
        }
    }

    protected function getMenu($menu_id): string
    {
        $menuItems = MenuItem::query()->with('children')
            ->where('menu_id', '=', $menu_id)
            ->whereNull('parent_id')
            ->orderBy('order', 'asc')
            ->get();

        $settings = self::getSettings($menu_id);

        return view('menu-builder::menus.generate-menu', compact('menuItems', 'settings'))->render();
    }

    public function assets($path)
    {
        $file = base_path(trim(config('menu-builder.resources_path'), '/').'/'.urldecode($path));
        if (File::exists($file)) {
            switch ($extension = pathinfo($file, PATHINFO_EXTENSION)) {
                case 'js':
                    $mimeType = 'text/javascript';
                    break;
                case 'css':
                    $mimeType = 'text/css';
                    break;
                default:
                    $mimeType = File::mimeType($file);
                    break;
            }

            $response = Response::make(File::get($file), 200);
            $response->header('Content-Type', $mimeType);
            $response->setSharedMaxAge(31536000);
            $response->setMaxAge(31536000);
            $response->setExpires(new \DateTime('+1 year'));

            return $response;

        }

        return response('', 404);

    }
}
