<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;

class CreateFarmFieldsForUser implements ShouldQueue
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
        $numberOfFarmFieldsPerUser = 18;
        $numberOfIdleFarmFields = 4;
        $farmFields = array_fill(
            0,
            $numberOfFarmFieldsPerUser,
            [
                'status' => 'BARREN'
            ]
        );
        
        for($i = 0; $i < $numberOfIdleFarmFields; $i++) {
            $farmFields[$i]['status'] = 'IDLE';
        }

        $this->user->farmFields()->createMany($farmFields);

        // Use Events and Listeners to publish messages to Redis
        // Redis::connection('default')->publish('test', json_encode($this->user));
    }
}
