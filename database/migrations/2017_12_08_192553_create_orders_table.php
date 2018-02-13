<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid')->comment('openid');
            $table->string('hotel_id')->comment('酒店id');
            $table->string('order_id')->comment('订单号');
            $table->string('hotelname')->comment('酒店名称');
            $table->string('room')->comment('房型');
            $table->string('breakfast')->comment('有无早餐');
            $table->string('totime')->comment('到店时间');
            $table->string('endtime')->comment('离店时间');
            $table->string('name')->comment('预订人');
            $table->string('phone')->comment('手机');
            $table->string('price')->comment('单价');
            $table->string('total')->comment('总价');
            $table->string('ordertime')->comment('订单时间');
            $table->string('remark')->comment('备注');
            $table->string('status')->comment('订单状态');
            $table->string('invoice')->comment('是否需要开票')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
