<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentImport;

try {
    $data = Excel::toArray(new StudentImport(7), 'Template_Siswa_Tanpa_Kelas.csv');
    print_r($data);
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    if (method_exists($e, 'failures')) {
        foreach ($e->failures() as $failure) {
            echo "Row " . $failure->row() . ": " . implode(", ", $failure->errors()) . "\n";
        }
    }
}
