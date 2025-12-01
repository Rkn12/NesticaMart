<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class IndonesiaRegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Increase memory limit to handle large SQL file processing
        ini_set('memory_limit', '1024M');

        $url = 'https://raw.githubusercontent.com/cahyadsn/wilayah/master/db/wilayah.sql';
        
        $this->command->info('Downloading SQL file from GitHub...');
        $sql = Http::withoutVerifying()->get($url)->body();

        if (!$sql) {
            $this->command->error('Failed to download SQL file.');
            return;
        }
        
        $this->command->info('First 500 chars: ' . substr($sql, 0, 500));

        $this->command->info('Processing SQL...');

        // Remove CREATE TABLE, DROP TABLE, and other setup commands
        $lines = explode("\n", $sql);
        unset($sql); // Free up memory

        $filteredLines = [];
        $isInsert = false;

        foreach ($lines as $line) {
            $trimLine = trim($line);
            if (str_starts_with($trimLine, 'INSERT INTO')) {
                $isInsert = true;
                // Replace table name
                $line = str_replace('wilayah', 'indonesia_regions', $line);
                // Replace column names to match migration
                $line = str_replace('(kode, nama)', '(code, name)', $line);
                $line = str_replace('(kode,nama)', '(code,name)', $line);
                $filteredLines[] = $line;
            } elseif ($isInsert && $trimLine !== '' && !str_starts_with($trimLine, '--') && !str_starts_with($trimLine, '/*')) {
                // Continuation of INSERT statement
                $filteredLines[] = $line;
            }
        }
        
        unset($lines); // Free up memory

        $processedSql = implode("\n", $filteredLines);
        unset($filteredLines); // Free up memory

        if (empty($processedSql)) {
            $this->command->error('No INSERT statements found.');
            return;
        }

        $this->command->info('Inserting data...');
        
        // Execute the SQL
        try {
            // Clear existing data first to avoid duplicates if re-running
            DB::table('indonesia_regions')->truncate();
            
            DB::unprepared($processedSql);
            $this->command->info('Data inserted successfully.');
        } catch (\Exception $e) {
            $this->command->error('Error inserting data: ' . $e->getMessage());
        }
    }
}
