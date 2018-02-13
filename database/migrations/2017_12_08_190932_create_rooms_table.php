<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id')->comment('酒店id');
            $table->string('name')->comment('房型名称');
            $table->double('price',10,2)->comment('门市价格');
            $table->double('memberprice',10,2)->comment('会员价');
            $table->integer('period')->comment('预订周期');
            $table->string('area')->comment('面积');
            $table->string('bedwidth')->comment('床宽');
            $table->string('window')->comment('窗户');
            $table->string('breakfast')->comment('早餐');
            $table->string('bedstyle')->comment('床型');
            $table->string('floors')->comment('楼层');
            $table->integer('num')->comment('入住人数');
            $table->string('Internet')->comment('上网方式');
            $table->string('nonsmok')->comment('无烟房');
            $table->string('remark')->comment('备注');
            $table->string('img')->comment('图片');
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
        Schema::dropIfExists('rooms');
    }
}
