<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
       public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->date('due_date')->after('invoice_date')->nullable();
            $table->foreignId('customer_id')->constrained()->after('user_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('due_date');
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
        });
    }
}
