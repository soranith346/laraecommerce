<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = ['user_id', 'receiver_address', 'receiver_phone', 'total_amount', 'status'];

    // ទំនាក់ទំនង: Order មួយ មាន Item ច្រើន
    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    
    public function user(){
        return $this->belongsTo(User::class);
    }
}