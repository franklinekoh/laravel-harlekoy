<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use App\Models\UpdatedUser;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Facades\Log;

class StoreUpdatedUsers
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserUpdated $event): void
    {
        DB::beginTransaction();
        try {
            //Stores updated user info to be picked up by a job and posted in batch to 3rd paty endpoint
            $updatedUsers = $event->updatedUsers;
            foreach ($updatedUsers as $updatedUserDto){
                UpdatedUser::updateOrCreate(
                    [UpdatedUser::EMAIL => $updatedUserDto->email],
                    [
                        UpdatedUser::FIRSTNAME => $updatedUserDto->firstname,
                        UpdatedUser::LASTNAME => $updatedUserDto->lastname,
                        UpdatedUser::EMAIL => $updatedUserDto->email,
                        UpdatedUser::TIMEZONE => $updatedUserDto->timezone,
                        UpdatedUser::RETRY => $updatedUserDto->retry,
                        UpdatedUser::IS_API_POST_SUCCESS => $updatedUserDto->isApiPostSuccess
                    ]
                );
            }

            DB::commit();
        }catch (Throwable $exception){
            DB::rollBack();
            report($exception);
            Log::error('Storing updated users failed');
        }
    }
}
