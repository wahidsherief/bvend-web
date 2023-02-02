<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

// use Salman\Mqtt\MqttClass\Mqtt;

class PublishToMachine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish:machine';

    /**
     * The console command description.
     *
     * @var string
     */

    // BVEND Software is PUBLISHER and Vending Machine is SUBSCRIBER
    protected $description = 'Bvend software will publish or provide order information which is checked by vending machine periodically';

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
        \Log::info('new order');
    }
}
