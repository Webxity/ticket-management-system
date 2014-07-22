<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConvoModel extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('conversations', function(Blueprint $table)
		{
			$table->increments('id');
                                                     $table->longText('message');
                                                     $table->string('user_name');
                                                     $table->integer('user_id');
                                                     $table->integer('ticket_id');
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
		//Schema::drop('conversations');
	}

}
