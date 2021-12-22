<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Hello extends Model implements Sortable
{
    use HasFactory, SortableTrait, SoftDeletes;

    /**
     * @var string[] When creating the record from create method of eloquent model
     */
    protected $fillable = ['name', 'user_id'];

    protected $sortable = ['order'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
