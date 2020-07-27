<?php

namespace App\Console\Commands;

use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ReviewStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:reviewStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Group by reviews between yesterday to today at midnight';

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
    * Undocumented function
    * 昨日レビューされたものを取得。
    */
    public function handle(Review $review)
    {
        $review->whereBetween('created_at', [Carbon::yesterday(), Carbon::today()])
        ->get();
    }
}
