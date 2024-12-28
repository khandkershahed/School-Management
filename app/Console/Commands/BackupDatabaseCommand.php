<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-database-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Database Backup';

    /**
     * Execute the console command.
     */
    // public function handle()
    // {
    //     $databaseName = config('database.connections.mysql.database');
    //     $userName = config('database.connections.mysql.username');
    //     $password = config('database.connections.mysql.password');
    //     $date = date('Y-m-d_H-i-s');
    //     $fileName = storage_path("app/{$databaseName}_{$date}_backup.sql");

    //     exec("mysqldump -u $userName -p$password $databaseName > $fileName");
    // }

    public function handle()
    {
        $databaseName = config('database.connections.mysql.database');
        $userName = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $date = date('Y-m-d_H-i-s');
        $fileName = storage_path("app/{$databaseName}_{$date}_backup.sql");

        // Command to backup the database
        $command = "mysqldump -u $userName -p$password $databaseName";

        // Open a process for the command
        $descriptors = [
            1 => ["pipe", "w"], // stdout (write)
            2 => ["pipe", "w"], // stderr (write)
        ];

        $process = proc_open($command, $descriptors, $pipes);

        if (is_resource($process)) {
            // Open the output file for writing
            $file = fopen($fileName, 'w');

            // Write the output of the command into the file
            stream_copy_to_stream($pipes[1], $file);

            fclose($file);
            fclose($pipes[1]);

            // Close the process
            proc_close($process);
        }
    }
}
