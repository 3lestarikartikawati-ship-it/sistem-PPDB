<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Serve a private file securely.
     * Only the owning student, admin, or bendahara can access it.
     */
    public function show(string $path)
    {
        $user = auth()->user();

        // Admin and Bendahara can view any file
        if (!in_array($user->role, ['admin', 'bendahara'])) {
            // For students, verify they own this file
            $student = $user->student;

            if (!$student) {
                abort(403, 'Anda tidak memiliki akses ke berkas ini.');
            }

            $fileColumns = [
                'pas_foto', 'kartu_keluarga', 'ijazah_skl',
                'bukti_rapor', 'bukti_prestasi', 'bukti_beasiswa',
            ];

            $ownsFile = false;
            foreach ($fileColumns as $col) {
                if ($student->{$col} === $path) {
                    $ownsFile = true;
                    break;
                }
            }

            if (!$ownsFile) {
                abort(403, 'Anda tidak memiliki akses ke berkas ini.');
            }
        }

        if (!Storage::disk('local')->exists($path)) {
            abort(404, 'Berkas tidak ditemukan.');
        }

        return response()->file(Storage::disk('local')->path($path));
    }
}
