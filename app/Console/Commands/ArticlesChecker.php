<?php

namespace App\Console\Commands;

use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ArticlesChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command check if the articles has ended';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $articles = Article::where('end_time', '<', Carbon::now())->where('status', 'live')->get();

        foreach ($articles as $article) {
            $article->status = 'done';
            $article->update();

            $seller = $article->user;
            $buyer = $article->highestBidObject()->user;

            Mail::send('emails.auction-done.seller',
                ['article' => $article, 'bid' => $article->highestBidObject()], function ($message) use ($seller) {
                $message->to($seller->email)->subject('Auction is finished!');
            });

            Mail::send('emails.auction-done.buyer',
                ['article' => $article, 'bid' => $article->highestBidObject()], function ($message) use ($buyer) {
                $message->to($buyer->email)->subject('Auction is finished!');
            });
        }

        return Command::SUCCESS;
    }
}
