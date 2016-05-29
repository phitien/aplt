<?php

namespace App\Shared\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Kernel as BaseKernel;

class Kernel extends BaseKernel {
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [ ];
	// Commands\Inspire::class,
	
	/**
	 * Define the application's command schedule.
	 *
	 * @param \Illuminate\Console\Scheduling\Schedule $schedule        	
	 * @return void
	 */
	protected function schedule(Schedule $schedule) {
		// $schedule->command('inspire')
		// ->hourly();
	}
}
