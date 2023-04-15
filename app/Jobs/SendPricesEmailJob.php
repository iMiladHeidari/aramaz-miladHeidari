<?php

namespace App\Jobs;

use App\Mail\PricesListEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPricesEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $prices_data;
    protected $current_date;

    /**
     * Create a new job instance.
     */
    public function __construct($user, $prices_data)
    {
        $this->user = $user;
        $this->prices_data = $prices_data;
        $this->current_date = now()->diffForHumans();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)
            ->send(new PricesListEmail($this->prices_data, $this->user->name, $this->current_date));
    }
}
