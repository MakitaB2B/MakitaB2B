<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin\Transaction;

class DailyPromoFollowUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:promo-follow-up';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promo Follow Up Mail';

    /**
     * Execute the console command.
     */

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
      // Send the email

      $start_date = now()->subDays(15)->toDateString();
      $end_date = now()->toDateString();

      Transaction::whereBetween('order_date', [$start_date, $end_date])->get();
      // Mail::to('recipient@example.com')->send(new PromoTransactionFollowUpMail());
        
      $this->info('Follow Up Mail Sent Successfully!');
    }
}
