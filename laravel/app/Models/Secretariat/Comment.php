<?php

namespace App\Models\Secretariat;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;

    protected $dates = [
        'date_created'
    ];

    protected $guarded = [
        'id',
    ];

    public function resident()
    {
        return $this->belongsTo('App\Models\Residency\Resident', 'resident_id');
    }


















    public static function updateData($id,$data){
        DB::table('comments')->where('id', $id)->update($data);
    }

    public static function getuserData($id=null){
        $value=DB::table('users')->orderBy('id', 'asc')->get(); 
        return $value;
    }
}
