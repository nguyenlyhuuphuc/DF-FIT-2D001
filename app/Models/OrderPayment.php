<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_payment_method';
    
    public const RESPONSE_CODE_VNPAY = [
        '00' => 'Giao dịch thành công',
        '07' => 'Trừ tiền thành công. Giao dịch bị nghi ngờ (liên quan tới lừa đảo, giao dịch bất thường).',
        '09' => 'Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng chưa đăng ký dịch vụ InternetBanking tại ngân hàng.',
        '10' => 'Giao dịch không thành công do: Khách hàng xác thực thông tin thẻ/tài khoản không đúng quá 3 lần',
        '24' => 'Giao dịch không thành công do: Khách hàng hủy giao dịch'
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id')->withTrashed();
    }
}
