<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Task extends Model
{
    protected $fillable = ['name', 'project_id', 'priority'];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(fn (Model $model) => $model->uuid = Str::uuid());
    }
}
