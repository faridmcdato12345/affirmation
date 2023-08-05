<?php

namespace App\Console\Commands;

use App\Models\Affirmation;
use App\Models\Progress;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateProgressTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:progress-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will add default value to the affirmation type because the relationship has been changed into polymorphic';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            DB::beginTransaction();

            $this->line('Retrieving all progress data');
            $progress = Progress::get();

            $this->line('Adding default values for category id and type');

            $progressBar = $this->output->createProgressBar(count($progress));
            $progressBar->setOverwrite(false);
            $progressBar->start();
            $progressBar->setMessage('Starting...');

            foreach($progress as $data) {
                $data->update([
                    'affirmation_type' => Affirmation::class
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
