<?php

/**
 * Created by PhpStorm.
 * User: HappyQi
 * Date: 2017/9/28
 * Time: 10:19
 */

namespace App\Models\Vote;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoteComplain extends Model
{
    use SoftDeletes;    //使用软删除
    protected $table = 'vote_complain_report';
    public $timestamps = true;
    protected $dates = ['deleted_at'];  //软删除
}


