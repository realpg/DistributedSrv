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

class VoteOrder extends Model
{
    use SoftDeletes;    //使用软删除
    protected $table = 'vote_order_info';
    public $timestamps = true;
    protected $dates = ['deleted_at'];  //软删除
}


