<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDocument extends Model
{
    //
      protected $fillable = [ 'user_id','type_document', 'file_path'];

     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
