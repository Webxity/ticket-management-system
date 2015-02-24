<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TicketsModel extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tickets', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
                                            $table->string('title');
                                            $table->longText('description');
                                            $table->string('project');
                                            $table->enum('priority' ,  array('None','Normal', 'Low' ,'High' , 'Urgent'));
                                            $table->string('url');
											$table->string('developer');
											$table->integer('owner_id');
											$table->date('due_date');
                                            $table->enum('status', array('open', 'close', 'pending'));
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
		Schema::table('tickets', function(Blueprint $table)
		{
			//
			Schema::drop('tickets');
		});
	}

}
