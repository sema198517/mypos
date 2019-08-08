<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected $fillable = [
        'name','last_name', 'phone', 'address', 'email', 'password', 'image'
    ];
    protected $appends = ['image_path'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getImagepathAttribute()
    {

        return asset('uploads/userRegister_image/' . $this->image);

    }//End of get Image path

}
