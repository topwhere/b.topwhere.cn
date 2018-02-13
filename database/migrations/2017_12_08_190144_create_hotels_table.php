<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('img')->comment('图片');
            $table->string('name')->comment('酒店名');
            $table->string('status')->comment('营业状态');
            $table->string('tel')->comment('电话');
            $table->double('price',10,2)->comment('价格');
            $table->string('service')->comment('设施服务');
            $table->string('star')->comment('星级');
            $table->string('pay')->comment('支付方式');
            $table->string('city')->comment('所属城市');
            $table->string('business')->comment('商圈');
            $table->string('subway')->comment('地铁');
            $table->string('address')->comment('地址');
            $table->string('lon')->comment('经度');
            $table->string('lat')->comment('纬度');
            $table->string('profile')->comment('简介');
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
        Schema::dropIfExists('hotels');
    }
}
