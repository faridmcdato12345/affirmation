<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateUserActiveCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:users-category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will add default value on active category type and will copy the current active category id of the user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            DB::beginTransaction();

            $this->line('Retrieving all users');
            $users = User::get();

            $this->line('Adding default values for category id and type');

            $progressBar = $this->output->createProgressBar(count($users));
            $progressBar->setOverwrite(false);
            $progressBar->start();
            $progressBar->setMessage('Starting...');

            foreach($users as $user) {
                $user->update([
                    'active_category_id' => $user->active_category,
                    'active_category_type' => Category::class
                ]);

                $progressBar->advance();
            }

            $this->info(PHP_EOL . 'Updating values has been successful!');
            $progressBar->finish();

            DB::commit();
        } catch(\Throwable $th) {
            $this->line('An error occured! Rolling back the changes');
            DB::rollback();
        }

        return Command::SUCCESS;
    }
}
