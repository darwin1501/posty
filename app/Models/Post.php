<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Like;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'body'
        // 'user_id'
    ];
    //this method access the likes table 
    //the variable $user can be used to access the fields of
    //users table e.g : $user->id 
    public function likeBy(User $user){
        //the contains was a laravel collection method
        //return true or false if doesn't have user id
        //the $this->likes will look up to likes tables
        return $this->likes->contains('user_id', $user->id);
    }
    //this function was used to check if user owned the post, so the
    //user will be able to delete users owned post.
    //$this->user->id was the users id when currently login
    //$this->user_id was the post user_id field 

    // public function ownedBy(User $user){
    //     //this will return true or false
    //     return $user->id === $this->user_id;
    // }
    // database relationship on user
    //post belongs to user
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //post has many likes
    public function likes(){
        return $this->hasMany(Like::class);
    }
}
