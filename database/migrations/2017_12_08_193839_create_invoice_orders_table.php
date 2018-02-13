<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid')->comment('openid');
            $table->string('name')->comment('姓名');
            $table->string('tel')->comment('手机');
            $table->string('hotel')->comment('消费酒店');
            $table->string('type')->comment('发票类型');
            $table->string('company')->comment('企业名称');
            $table->string('num')->comment('信用代码');
            $table->string('address')->comment('注册地址');
            $table->string('bank')->comment('开户行');
            $table->string('banknum')->comment('开户行账户');
            $table->string('total')->comment('总价');
            $table->integer('status')->comment('状态')->default(0);
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
        Schema::dropIfExists('invoice_orders');
    }
}
