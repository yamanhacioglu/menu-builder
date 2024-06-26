<?php

namespace YamanHacioglu\MenuBuilder\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use YamanHacioglu\MenuBuilder\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();

        return view('menu::menus.index', compact('menus'));
    }

    /**
     * Return all menu list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMenus()
    {
        if ($menus = Menu::query()->orderBy('order', 'asc')->get()) {
            return response()->json([
                'success' => true,
                'menus' => $menus,
            ]);
        }
    }

    /**
     * Return single menu.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMenu(Request $request)
    {
        if ($request->id) {
            $menu = Menu::query()->find($request->id);

            return response()->json([
                'success' => true,
                'menu' => $menu,
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function getMenuHtml(Request $request)
    {
        if ($request->ajax()) {
            $html = \MenuBuilder::generateMenu($request->id);

            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        }
    }

    /**
     * Create new menu.
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            if (($errors = $this->validation($request->all())) !== true) {
                return $errors;
            }

            $order = Menu::query()->max('order');
            $menu = new Menu();
            $menu->name = $request->name;
            $menu->slug = Str::slug($request->name);
            $menu->url = $request->url;
            $menu->order = $order + 1;
            $menu->custom_class = $request->custom_class;

            if ($menu->save()) {
                $menus = Menu::all();

                return response()->json([
                    'success' => true,
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'errors' => ['There is no ajax call'],
        ]);
    }

    /**
     * Sort menu list.
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sort(Request $request)
    {
        if (isset($request->menus)) {
            $menus = $request->menus;
            $order = 1;

            foreach ($menus as $item) {
                $menu = Menu::find($item['id']);
                $menu->order = $order;

                if ($menu->update()) {
                    $order++;
                }
            }

            return response()->json([
                'success' => true,
            ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Update the specified menu.
     *
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|true
     */
    public function update(Request $request)
    {
        if (($errors = $this->validation((object) $request->all())) !== true) {
            return $errors;
        }

        if ($request->id && $menu = Menu::query()->find($request->id)) {
            $menu->name = $request->name;
            $menu->slug = Str::slug($request->name);
            $menu->url = $request->url;
            $menu->custom_class = $request->custom_class;

            if ($menu->update()) {
                return response()->json([
                    'success' => true,
                    'menu' => $menu,
                    'request' => $request->all(),
                ]);
            }
        }

        return response()->json(['success' => false]);
    }

    /**
     * Delete the specified menu.
     *
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->id) {
            $menu = Menu::query()->find($request->id);
            $menu->items()->delete();

            if ($menu->delete()) {
                return response()->json([
                    'success' => true,
                ]);
            }
        }

        return response()->json(['success' => true]);
    }

    /**
     * Validation.
     *
     * @param  object  $data
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|true
     */
    public function validation($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        return true;
    }

    /**
     * Load menu builder assests.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function assets(Request $request)
    {
        return \MenuBuilder::assets($request->path);
    }
}
