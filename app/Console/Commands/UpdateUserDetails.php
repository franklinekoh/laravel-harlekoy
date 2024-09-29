<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
Use App\Enum\TimeZoneEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Throwable;

class UpdateUserDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-user-details';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Updates user's firstname, lastname and timezone";

    /**
     * Execute the console command.
     */
    public function handle()
    {

        DB::beginTransaction();
        try {
            //  Assuming the table has thousands of records
            User::chunk(250, function (Collection $users){
                foreach ($users as $user){
                    // In real-world project, One May decide to create a helper function for getting a random timezone
                    // depending on how often random timezones needs to be assigned.
                    $timeZones = TimeZoneEnum::cases();
                    $chosenTimeZoneId = rand(0, sizeof($timeZones) -1);
                    $chosenTimeZone = $timeZones[$chosenTimeZoneId];

                    User::where(User::EMAIL, $user->email)
                        ->update([
                            User::FIRSTNAME => fake()->firstName(),
                            User::LASTNAME => fake()->lastName(),
                            User::TIMEZONE => $chosenTimeZone->value
                        ]);
                }
            });

            DB::commit();
            return Command::SUCCESS;
        }catch (Throwable $exception) {
            DB::rollBack();
            report($exception);
            return Command::FAILURE;
        }
    }
}
