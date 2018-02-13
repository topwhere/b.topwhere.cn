<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid')->comment('openid');
            $table->string('type')->comment('发票类型');
            $table->string('name')->comment('公司名称');
            $table->string('num')->comment('信用代码');
            $table->string('address')->comment('注册地址');
            $table->string('tel')->comment('联系电话');
            $table->string('bank')->comment('开户行');
            $table->string('banknum')->comment('开户行账号');
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
        Schema::dropIfExists('invoices');
    }
}
