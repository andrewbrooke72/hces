<?php

namespace HCES\Console\Commands;

use HCES\SystemSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;

class SystemSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'arsenal:up';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Launch arsenal installer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try{
            DB::beginTransaction();
            $this->info('Installing arsenal...');
            $this->info('Creating system settings...');
            if(is_null(SystemSetting::first())){
                $system_setting = new SystemSetting();
                $system_setting->save();
                $this->info('System settings created!');
            }else{
                $this->info('System settings found');
                $this->info('Skipping...');
            }
            DB::commit();
            $this->info('Arsenal installation completed!');
        }catch (Exception $exception){
            $this->error($exception->getMessage());
            DB::rollback();
        }
    }
}
