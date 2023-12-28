<?php

namespace App\Console\Commands;

use App\Models\AppVersion;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Predis\Command\Redis\COMMAND as RedisCOMMAND;

class UpdateApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:app {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used specifically when there is a new version of the app.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dataString = $this->argument('data');
        $dataList = explode(',',$dataString);
        $currentVersion = AppVersion::latest()->first();
        if($currentVersion){
            $newVersion = floatval($currentVersion->version_number) + 0.01;
            $this->__insertDb($newVersion,$dataList);
        }else{
            $initialVersionNumber = 1.0;
            $this->__insertDb($initialVersionNumber,$dataList);
        }
    }

    private function __insertDb($version,$dataList)
    {
        
        try {
            DB::beginTransaction();
            $__appversions = AppVersion::create(['version_number' => $version]);
            $this->__insertAppVersion($__appversions);
            $this->__insertUpdateDescription($__appversions,$dataList);
            $this->__updateUser();
            DB::commit();
        } catch (\Throwable $th) {
            $this->line($th);
            $this->line('An error occured! Rolling back the changes');
            DB::rollback();
        }
        
        return Command::SUCCESS;
    }
    private function __insertAppVersion($appVersions)
    {
        $versionBar = $this->output->createProgressBar(1);
        $versionBar->start();
        foreach ($appVersions as $__appV) {
            $versionBar->advance();
        }
        $this->info(' Adding the new version has been successful!');
        $versionBar->finish();
    }

    private function __insertUpdateDescription($appVersion,$dataList)
    {
        $descBar = $this->output->createProgressBar(count($dataList));
        foreach ($dataList as $data) {
            $appVersion->update_descriptions()->create(['description' => $data]);
            sleep(1);
            $descBar->advance();
        }
        $this->info(' Adding the update description has been successful!');
        $descBar->finish();
    }
    private function __updateUser()
    {
        $users = User::all();
        $this->withProgressBar($users, function($user){
            $user->app_update_trigger = 1;
            $user->save();
            sleep(1);
        });
        $this->info(' User update has been successful!');
    }
}
