<?php

namespace App\Commands;

use App\Models\Product;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Facades\Log;
class CreateCartCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'createCart {--bill-currency=} {*}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Pricing of products with offers';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        dd($this->option('bill-currency'));
//        dd($this->arguments());
        $product=new Product([
            'name'=>'T-shirt',
            'price'=>'20'
        ]);
        print_r($product->name);

    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
