<?php

namespace YamanHacioglu\MenuBuilder\Models;
use Illuminate\Database\Eloquent\Model;

class MenuConfig extends Model
{
    protected $table = 'menu_configs';
    protected $fillable = ['depth', 'levels'];

    protected function casts(): array
    {
        return [
            'levels' => 'array'
        ];
    }
}
