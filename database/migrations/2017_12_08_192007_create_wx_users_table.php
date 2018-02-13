<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWxUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wx_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_id')->comment('公司id');
            $table->string('name')->comment('姓名');
            $table->string('phone')->comment('手机号');
            $table->string('sex')->comment('性别');
            $table->string('grade')->comment('等级');
            $table->string('exception')->comment('是否白名单');
            $table->string('autoex')->comment('是否自动升级');
            $table->string('integral')->comment('积分');
            $table->string('email')->comment('邮箱');
            $table->string('company')->comment('公司');
            $table->string('area')->comment('区域');
            $table->string('department')->comment('部门');
            $table->string('duty')->comment('职务');
            $table->string('ide')->comment('证件类型');
            $table->string('idenum')->comment('身份证号码');
            $table->string('openid')->comment('openid');
            $table->string('nickname')->comment('微信昵称');
            $table->string('headimgurl')->comment('头像路径');
            $table->string('groupid')->comment('分组');
            $table->string('unionid')->comment('unionid');
            $table->string('status')->comment('状态');
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
        Schema::dropIfExists('wx_users');
    }
}
