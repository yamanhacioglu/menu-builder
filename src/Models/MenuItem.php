<?php

namespace YamanHacioglu\MenuBuilder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    protected $table ='menu_items';
    protected $fillable = ['title', 'slug', 'order', 'parent_id'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'parent_id');
    }

    public function children() : HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order', 'asc');
    }

    public function childrens() : HasMany
    {
        return $this->children()->with('childrens');
    }

    public function settings() : HasMany
    {
        return $this->hasMany(MenuConfig::class, 'menu_id');
    }
}
