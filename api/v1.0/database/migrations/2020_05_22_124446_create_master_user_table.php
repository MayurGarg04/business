<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_user', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone');
            $table->rememberToken();
            $table->string('isd_code',5);
            //$table->string('msisdn',20);
            $table->date('dob');
            $table->string('city',50);
            $table->string('amount',20);
            $table->string('update_by',15)->default('admin')->comment = 'system who update the row'; 
            $table->string('status')->default(0)->comment = '0 for not confirmed donor,1 for confirmed donor'; 
            $table->string('isdelete')->default(0)->comment = '0 for not deleted, 1 for deleted';
            $table->string('app_id',10)->default(0);
            $table->string('register_ip',20);
            $table->string('update_ip',25)->default('localhost')->comment = 'ip from where the update has been done'; 
            $table->timestamp('created_on')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_user');
    }
}
