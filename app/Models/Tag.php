<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//TODO: tagはポリモーフィックリレーションにしたがよいかも。。。
class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];


    /**
     * Get the events associated with the tag.
     */
    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}
