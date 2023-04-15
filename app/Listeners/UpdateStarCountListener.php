<?php

namespace App\Listeners;

use App\Models\TableB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateStarCountListener
{

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $table_a_id = $event->table_a_id;
        $star_count = $event->star_count;

        // Update the star count in Table B
        $tableB = TableB::where('table_a_id', $table_a_id)->first();
        if ($tableB) {
            $tableB->star_count += $star_count;
            $tableB->save();
        } else {
            TableB::create([
                'table_a_id' => $table_a_id,
                'star_count' => $star_count
            ]);
        }
    }
}
