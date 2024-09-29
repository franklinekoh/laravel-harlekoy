<?php

namespace App\Console\Commands;

use App\Events\UserUpdated;
use Illuminate\Console\Command;
use App\Models\UpdatedUser;
use App\Services\ThirdPartyService;

class postUpdatedUsersData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:post-updated-users-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post updated user data to 3rd party endpoint';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    private ThirdPartyService $thirdPartyService;
    public function __construct()
    {
        parent::__construct();
        $this->thirdPartyService = resolve(ThirdPartyService::class);
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $updatedUsers = UpdatedUser::where(UpdatedUser::IS_API_POST_SUCCESS, false)
                            ->orWhere(UpdatedUser::RETRY, '>', 0)
                            ->limit(1000)
                            ->get();

        $subscribers = [];
        foreach ($updatedUsers as $updatedUser){
            $subscriber = [
                'email' => $updatedUser->email,
                'name' => $updatedUser->firstname.' '.$updatedUser->lastname,
                'timezone' => $updatedUser->timezone
            ];
            $subscribers[] = $subscriber;
        }

        $apiResponse = $this->thirdPartyService->postSubscribersData($subscribers);
        /**
         * Assuming the batch endpoint returns data in this format
         * {
            'success': true,
         *  'data': [
         * {
            'email': 'ekohfranklin@gmail.com',
         *  'name': 'Franklin Ekoh',
         *  'timezone': 'GMT + 1'
         * },
         * ...
         * ]
         * ...
         * }
         *
         *
         */

        if ($apiResponse['success'] === 'false'){
            foreach ($updatedUsers as $failedSubscriber){
                UpdatedUser::where(UpdatedUser::EMAIL, $failedSubscriber['email'])
                    ->update([
                        UpdatedUser::RETRY => $failedSubscriber->retry + 1
                    ]);
            }
        }
        if ($apiResponse['success'] && sizeof($apiResponse['data']) > 0){
            foreach ($apiResponse['data'] as $datum){
                UpdatedUser::where(UpdatedUser::EMAIL, $datum['email'])
                    ->update([
                        UpdatedUser::IS_API_POST_SUCCESS => 1,
                        UpdatedUser::RETRY => 0
                    ]);
            }
        }
    }
}
