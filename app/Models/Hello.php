<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Hello extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    /**
     * @var string[] When creating the record from create method of eloquent model
     */
    protected $fillable = ['name'];

    protected $sortable = ['order'];
}
