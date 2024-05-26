<?php

use Illuminate\Database\Seeder;
use YamanHacioglu\MenuBuilder\Models\MenuSetting;

class MenuConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = new MenuSetting();
        $settings->menu_id = null;
        $settings->depth = 5;
        $settings->apply_child_as_parent = 0;
        $settings->levels = [
            'root' => [
                'style' => 'vertical', // horizontal | vertical
            ],
            'child' => [
                'show' => 'onClick', // onclick | onHover
                'position' => 'right',
                'level_1' => [
                    'show' => 'onClick',
                    'position' => 'bottom',
                ],
                'level_2' => [
                    'show' => 'onHover',
                    'position' => 'right',
                ],
            ],
        ];
        $settings->save();
    }
}
