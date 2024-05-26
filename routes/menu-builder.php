<?php

use YamanHacioglu\MenuBuilder\Models\MenuItem;
use YamanHacioglu\MenuBuilder\Models\Menu;


Route::group([
    'prefix'    => config('menu.prefix'),
    'namespace' => config('menu.controller_namespace'),
], function () {
    Route::get('menus', [MenuController::class, 'index']);
    Route::get('menu/builder/{id}', [MenuItemController::class ,'showMenuItems'])->name('menu.builder');

    /*
     * Helpers Route
     */
    Route::get('assets', [MenuController::class, 'assets'])->name('menu.asset');

    /*
     * Vue Routes
     */
    // Menus
    Route::get('getMenus', [MenuController::class, 'getMenus']);
    Route::get('menu/{id}', [MenuController::class, 'getMenu']);
    Route::get('menu/html/{id}', [MenuController::class, 'getMenuHtml']);
    Route::post('menu', [MenuController::class, 'store']);
    Route::post('menu/sort', [MenuController::class, 'sort']);
    Route::put('menu', [MenuController::class, 'update']);
    Route::delete('menu/{id}', [MenuController::class, 'destroy']);
    // Menu Items
    Route::get('menu/items/{menu_id}', [MenuItemController::class, 'getMenuItems']);
    Route::get('menu/{menu_id}/item/{id}', [MenuItemController::class, 'getMenuItem']);
    Route::post('menu/item/sort', [MenuItemController::class, 'sort']);
    Route::post('menu/item', [MenuItemController::class, 'store']);
    Route::put('menu/item', [MenuItemController::class, 'update']);
    Route::delete('/menu/item/{id}', [MenuItemController::class, 'destroy']);
    // Menu Settings
    Route::post('menu/item/settings', [MenuItemController::class, 'storeSettings']);
    Route::get('menu/item/settings/{menu_id}', [MenuItemController::class, 'getSettings']);
});

$menuItems = MenuItem::all();

foreach ($menuItems as $menuItem) {
    if ($menuItem->url != null) {
        $controller = $menuItem->controller ?? '\YamanHacioglu\MenuBuilder\Http\Controllers\MenuItemController@setRoute';
        $partials = explode('@', $menuItem->controller);

        if (!class_exists($partials[0])) {
            $controller = '\YamanHacioglu\MenuBuilder\Http\Controllers\MenuItemController@setRoute';
        }

        if ($menuItem->route && !$menuItem->middleware) {
            Route::get($menuItem->url, $controller)->name($menuItem->route);
        } elseif ($menuItem->middleware && !$menuItem->route) {
            Route::get($menuItem->url, $controller)->middleware($menuItem->middleware);
        } elseif ($menuItem->route && $menuItem->middleware) {
            Route::get($menuItem->url, $controller)->name($menuItem->route)->middleware(explode(',', $menuItem->middleware));
        } elseif (!$menuItem->route && !$menuItem->middleware) {
            Route::get($menuItem->url, $controller);
        }
    }
}