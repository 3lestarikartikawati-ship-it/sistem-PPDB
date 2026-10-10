<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class StudentImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, WithCustomCsvSettings
{
    protected $kelas;

    public function __construct($kelas)
    {
        $this->kelas = $kelas;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $nisn = $row['nisn'];
        
        // 1. Create or Find User based on NISN
        // If a user with this NISN doesn't exist, create one.
        $user = User::firstOrCreate(
            ['username' => $nisn],
            [
                'name' => $row['nama_lengkap'],
                'email' => $nisn . '@student.local', // Dummy email required by DB
                'password' => Hash::make($nisn), // Password is their NISN by default
                'role' => 'siswa'
            ]
        );

        // 2. Create or Update Student record
        return Student::updateOrCreate(
            ['nisn' => $nisn],
            [
                'user_id' => $user->id,
                'nama_lengkap' => $row['nama_lengkap'],
                'jenis_kelamin' => strtoupper($row['jenis_kelamin']),
                'kelas' => $this->kelas,
                'status' => 'aktif',
                'nomor_pendaftaran' => 'M-' . rand(1000, 9999) . '-' . $nisn // Generate random registration number
            ]
        );
    }

    public function rules(): array
    {
        return [
            'nisn' => 'required',
            'nama_lengkap' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P,l,p',
        ];
    }
}
