<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DbBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Database Backup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = "orz-db-backup-".date("dmy", time()).".sql";
        $path = storage_path()."/app/backup/".$filename;
        if(env('APP_ENV') == 'production') {
            $command = "mysqldump --defaults-extra-file=".env('DUMP_SQL')." ".env('DB_DATABASE')." > ".$path;
        } else if(env('APP_ENV') == 'local') {
            $command = "mysqldump --user=".env('DB_USERNAME')." --password=".env('DB_PASSWORD')." --host=".env('DB_HOST')." ".env('DB_DATABASE')." > ".$path;
        }
        exec($command);
    }
}
