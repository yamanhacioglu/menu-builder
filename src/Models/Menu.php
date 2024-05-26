<?php

namespace YamanHacioglu\MenuBuilder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $table = 'menus';

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'menu_id');
    }
}
