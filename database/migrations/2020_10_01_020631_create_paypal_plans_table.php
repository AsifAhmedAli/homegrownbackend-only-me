<?php
  
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreatePaypalPlansTable extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('paypal_plans', function (Blueprint $table) {
        $table->id();
        $table->string('plan_id');
        $table->string('name');
        $table->enum('type', ['FIXED', 'INFINITE'])->default('INFINITE');
        $table->enum('state', ['CREATED', 'ACTIVE', 'INACTIVE'])->default('ACTIVE');
        $table->string('merchant_id')->nullable();
        $table->enum('frequency', ['DAY', 'WEEK', 'MONTH', 'YEAR'])->nullable();
        $table->integer('frequency_interval');
        $table->integer('total_cycles')->default(0);
        $table->double('amount', 10, 2)->default(0);
        $table->string('payment_definition_name');
        $table->string('currency')->default('USD');
        $table->text('description');
        $table->longText('web_description')->nullable();
        $table->string('trial_duration')->nullable();
        $table->string('trial_duration_unit')->nullable();
        $table->string('trial_period')->nullable();
        $table->timestamp('created_date')->nullable();
          $table->timestamp('updated_date')->nullable();
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
        Schema::dropIfExists('paypal_plans');
    }
}
