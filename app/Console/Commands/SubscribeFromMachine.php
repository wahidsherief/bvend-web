<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

// use Salman\Mqtt\MqttClass\Mqtt;

class SubscribeFromMachine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscribe:machine';

    /**
     * The console command description.
     *
     * @var string
     */

    // BVEND Software is SUBSCRIBER and Vending Machine is PUBLISHER
    protected $description = 'Bvend software will read or subscribe machine status information from machine periodically';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info('order is complete');
    }
}
