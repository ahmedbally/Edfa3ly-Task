<?php

namespace App\Commands;

use App\Presenters\BillPresenter;
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
     * @throws \Exception
     */
    public function handle()
    {
        try {
            $bill=new BillPresenter($this->option('bill-currency')??'USD',(array)$this->argument(''));
            $bill->parseCart();
            $bill->calculateSubTotal();
            $bill->calculateTaxes();
            $bill->calculateOffer();
            $this->info('Subtotal: ' . $bill->getSubTotal());
            $this->info('Taxes: ' . $bill->getTaxes());
            $discounts = $bill->getDiscounts();
            if (count($discounts)) {
                $this->info('Discounts:');
                foreach ($discounts as $discount)
                    $this->info("\t" . $discount->value . ' off ' . strtolower($discount->product->name) . ': ' . $discount->discount);
            }
            $this->info('Total: ' . $bill->getTotal());
        }
        catch (\RuntimeException $exception){
            $this->error($exception->getMessage());
        }
        return 0;
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
