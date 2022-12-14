<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCustomersBackup extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_customers_backup')->create('customers', function (Blueprint $table) {

            $DB_store = DB::connection('mysql_stores')->getDatabaseName();
            $DB_store_backup = DB::connection('mysql_stores_backup')->getDatabaseName();

            $table->bigInteger('id')->unsigned()->primary();
            $table->unsignedBigInteger('store_id');
            $table->string("first_name",50);
            $table->string("last_name",50);
            $table->string("email",50)->nullable();
            $table->string("phone",20)->nullable();
            $table->string("country",100)->nullable();
            $table->string("orders_count");
            $table->string("total_spent");
            $table->dateTime('created_at');
            $table->dateTime('updated_at');

            $table->foreign('store_id')
                ->references('id')
                ->on(new Expression($DB_store . '.stores'))
                ->onDelete('cascade');

            $table->foreign('store_id','customers_store_backup')
                ->references('id')
                ->on(new Expression($DB_store_backup . '.stores'))
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::connection('mysql_customers_backup')->hasTable('customers')){
            Schema::connection('mysql_customers_backup')->table('customers', function (Blueprint $table) {
                $table->dropForeign('customers_store_backup');
                $table->dropForeign(['store_id']);
                $table->dropColumn('store_id');
            });
            Schema::connection('mysql_customers_backup')->dropIfExists('customers');
        }

    }
}
