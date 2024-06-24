<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    public const PENDING = 'pending';
    public const SHIPPING = 'shipping';
    public const SUCCESS = 'success';
    public const CANCEL = 'cancel';
    public const REFUND = 'refund';


    protected $table = 'order';

    public function orderItems(){
        return $this->hasMany(OrderItem::class, 'order_id')->withTrashed();
    }

    public function orderPaymentMethods(){
        return $this->hasMany(OrderPayment::class, 'order_id')->withTrashed();
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
