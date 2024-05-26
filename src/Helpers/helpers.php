<?php

if(!function_exists('menu_asset')) {
    function menu_asset($path, $secure = null): string
    {
        return route('menu_asset').'?path='.urlencode($path);
    }
}

if(!function_exists('menu_prefix')) {
    function menu_prefix(): mixed
    {
        return (config('menu_prefix')) ? config('menu_prefix') : '/admin';
    }
}

if(!function_exists('menu_base_url'))
{
    function menu_base_url(): mixed
    {
        return config('menu.base_url') ?? 'http://localhost';
    }
}

if(!function_exists('menu_settings'))
{
    function menu_settings($menu_id): array
    {
        return \YamanHacioglu\MenuBuilder\MenuBuilder::getSettings($menu_id);
    }
}

if(!function_exists('menu_url'))
{
    function menu_url($menu): \Illuminate\Foundation\Application|string|\Illuminate\Contracts\Routing\UrlGenerator|\Illuminate\Contracts\Foundation\Application
    {
        $url = $menu->url ?? '#';
        if($menu->route) {
            $route = $menu->route;
            $params = json_decode($menu->params, true);
            if(is_array($params) && count($params) > 0 ) {
                $url = route($menu->route, $params);
            } else {
                $url = route($menu->route);
            }
        }
        return url($url);
    }
}

if(!function_exists('menu'))
{
    function menu($name): void
    {
        echo \YamanHacioglu\MenuBuilder\MenuBuilder::generateMenu($name);
    }
}

if(!function_exists('menu_array_key_exists'))
{
    function menu_array_key_exists($key, $array): bool
    {
        foreach($array as $index => $value)
        {
            if($key === $index)
            {
                return true;
            } elseif(is_array($value) && menu_array_key_exists($key, $value)) {
                return true;
            }
        }
        return false;
    }
}

if(!function_exists('menu_depth'))
{
    function menu_depth($settings)
    {
        return $settings['depth'];
    }
}

if(!function_exists('menu_label_style'))
{
    function menu_label_style($levels, $level)
    {
        if(menu_array_key_exists($level, $levels)) {
            if (menu_array_key_exists('style', $levels['child'][$level])) {
                return $levels['child'][$level]['style'];
            } else {
                return $levels['child']['style'];
            }
        } elseif(menu_array_key_exists('style', $levels['child']))
        {
            return $levels['child']['style'];
        }
        return '';
    }
}

if(!function_exists('menu_label_show'))
{
    function menu_label_show($levels, $level)
    {
         if(menu_array_key_exists($level, $levels)) {
             if(menu_array_key_exists('show', $levels['child'][$level]))
             {
                 return $levels['child'][$level]['show'];
             } else {
                 return $levels['child']['show'];
             }
         } elseif(menu_array_key_exists('show', $levels['child'])) {
             return $levels['child']['show'];
         }
         return '';
    }
}

if(!function_exists('menu_label_position'))
{
    function menu_label_position($levels, $level)
    {
        if(menu_array_key_exists($level, $levels))
        {
            if(menu_array_key_exists('position', $levels['child'][$level]))
            {
                return $levels['child'][$level]['position'];
            } else {
                return $levels['child']['position'];
            }
        }elseif(menu_array_key_exists('position', $levels['child']))
        {
            return $levels['child']['position'];
        }
        return '';
    }
}

