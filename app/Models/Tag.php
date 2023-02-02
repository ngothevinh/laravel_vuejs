<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name'];

    protected $appends = ['text'];
    public function  getTextAttribute(){
        return $this->name;
    }
    public function posts(){
        return $this->belongsToMany(Post::class,'post_tags','tags_id','post_id');
    }
}
