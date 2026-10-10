<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Student;

$students = Student::whereNull('nomor_pendaftaran')->get();
foreach ($students as $index => $s) {
    $year = date('Y', strtotime($s->created_at));
    $number = str_pad($index + 1, 4, '0', STR_PAD_LEFT);
    $s->update(['nomor_pendaftaran' => "PPDB-$year-$number"]);
    echo "Updated Student ID {$s->id} with number PPDB-$year-$number\n";
}
