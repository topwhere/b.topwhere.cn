<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
            $table->string('value')->comment('面值');
            $table->string('reggive')->comment('注册赠送');
            $table->string('limit')->comment('使用限制');
            $table->string('start')->comment('有效期开始');
            $table->string('end')->comment('有效期结束');
            $table->string('describe')->comment('描述');
            $table->string('status')->comment('是否启用')->default(0);
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
        Schema::dropIfExists('coupons');
    }
}
