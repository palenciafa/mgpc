<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    protected $signature = 'db:backup';
    protected $description = 'Backup the entire database to a SQL file';

    public function handle()
    {
        try {
            $this->info('Starting database backup...');

            // Get database credentials from .env
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');

            // Create backups directory if it doesn't exist
            $backupDir = storage_path('backups');
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            // Generate filename with timestamp
            $backupFile = $backupDir . DIRECTORY_SEPARATOR . 'backup_' . now()->format('Y-m-d_H-i-s') . '.sql';

            // Build mysqldump command using full path to XAMPP's mysqldump
            $mysqldumpPath = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';
            
            if (!file_exists($mysqldumpPath)) {
                $this->error("✗ mysqldump not found at: {$mysqldumpPath}");
                return Command::FAILURE;
            }

            $command = "\"{$mysqldumpPath}\" --user=\"{$username}\" --password=\"{$password}\" --host=\"{$host}\" \"{$database}\" > \"{$backupFile}\"";

            // Execute the command
            exec($command, $output, $returnCode);

            if ($returnCode === 0) {
                $this->info("✓ Database backed up successfully!");
                $this->info("Location: {$backupFile}");
                $this->info("Size: " . formatBytes(filesize($backupFile)));
                
                // Clean up old backups (keep only last 10)
                $this->cleanupOldBackups($backupDir);
                
                return Command::SUCCESS;
            } else {
                $this->error("✗ Backup failed with error code: {$returnCode}");
                return Command::FAILURE;
            }
        } catch (\Exception $e) {
            $this->error("✗ Error: " . $e->getMessage());
            return Command::FAILURE;
        }
    }

    private function cleanupOldBackups($backupDir, $keepCount = 10)
    {
        $files = glob($backupDir . DIRECTORY_SEPARATOR . 'backup_*.sql');
        
        if (count($files) > $keepCount) {
            // Sort by modification time
            usort($files, function ($a, $b) {
                return filemtime($a) - filemtime($b);
            });

            // Delete old backups
            $filesToDelete = array_splice($files, 0, count($files) - $keepCount);
            foreach ($filesToDelete as $file) {
                unlink($file);
                $this->info("Cleaned up old backup: " . basename($file));
            }
        }
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
