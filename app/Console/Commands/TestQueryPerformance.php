<?php

namespace App\Console\Commands;

use App\Models\Estudiante;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestQueryPerformance extends Command
{
    protected $signature = 'app:test-query-performance';

    protected $description = 'Tests the performance of problematic database queries.';

    public function handle()
    {
        $this->info('Starting query performance test...');

        // Test Query 1: SELECT with TIMESTAMPDIFF
        $startTime = microtime(true);
        $estudiantes = Estudiante::query()
            ->select('estudiante.*', DB::raw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS edad'))
            ->limit(10)
            ->offset(30)
            ->get();
        $endTime = microtime(true);
        $duration = round(($endTime - $startTime) * 1000, 2);
        $this->info("Query 1 (SELECT with TIMESTAMPDIFF) took: {$duration}ms");
        $this->info('Number of results: '.$estudiantes->count());

        // Test Query 2: count(*)
        $startTime = microtime(true);
        $count = Estudiante::count();
        $endTime = microtime(true);
        $duration = round(($endTime - $startTime) * 1000, 2);
        $this->info("Query 2 (count(*)) took: {$duration}ms");
        $this->info("Total count: {$count}");

        $this->info('Query performance test finished.');
    }
}
