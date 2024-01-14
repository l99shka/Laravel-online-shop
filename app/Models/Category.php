<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasFactory;
    use NodeTrait;

    protected $fillable = [
        'parent_id',
        'name',
        '_lft',
        '_rgt'
    ];

    public static function getAll(): Collection|array
    {
       return self::all()->toTree();
    }
}
