<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Warehouse;

class CreateFirstWarehouseAndItsSlotsForUser implements ShouldQueue
{
    use Queueable;

    public User $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user->withoutRelations();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Create first warehouse of the user
        $firstWarehouse = $this->user->warehouses()->create([
            'number' => 1
        ]);

        // Create warehouse slots and associate with the first warehouse of the user
        $slots = array_fill(
            0,
            $firstWarehouse->number_of_slots,
            []
        );
        $firstWarehouse->slots()->createMany($slots);
    }
}
