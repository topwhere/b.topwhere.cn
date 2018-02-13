<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->char('type',20)->comment('类型');
            $table->char('name',50)->unique();
            $table->string('email',100)->nullable();
            $table->string('password');
            $table->string('nickname')->nullable()->comment('姓名');
            $table->integer('status')->default(0)->comment('状态');
            $table->integer('wxuser_id')->nullable()->comment('wechat_id');
//            $table->string('position')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
