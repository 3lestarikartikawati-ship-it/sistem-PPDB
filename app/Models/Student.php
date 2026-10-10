<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($student) {
            // Set Nomor Pendaftaran
            $year = date('Y');
            $latest = self::where('nomor_pendaftaran', 'LIKE', "PPDB-$year-%")
                ->latest('id')
                ->first();
            
            if ($latest) {
                $lastNumber = intval(substr($latest->nomor_pendaftaran, -4));
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '0001';
            }
            
            $student->nomor_pendaftaran = "PPDB-$year-$newNumber";

            // Set Gelombang
            $settings = \App\Models\Setting::pluck('value', 'key');
            $now = now()->format('Y-m-d');
            
            if ($now >= ($settings['tgl_mulai_gel1'] ?? '') && $now <= ($settings['tgl_selesai_gel1'] ?? '')) {
                $student->gelombang = '1';
            } elseif ($now >= ($settings['tgl_mulai_gel2'] ?? '') && $now <= ($settings['tgl_selesai_gel2'] ?? '')) {
                $student->gelombang = '2';
            } else {
                $student->gelombang = '1'; // Default or outside range
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function studentPayments()
    {
        return $this->hasMany(StudentPayment::class);
    }

    public function getTargetInfakAttribute()
    {
        return (int) (Setting::where('key', 'biaya_infak')->value('value') ?? 180000);
    }

    public function getTargetLkAttribute()
    {
        $defaults = ['7' => 157000, '8' => 154000, '9' => 275000];
        $key = 'biaya_lk_' . $this->kelas;
        return (int) (Setting::where('key', $key)->value('value') ?? ($defaults[$this->kelas] ?? 0));
    }

    public function getTargetSeragamAttribute()
    {
        $osis = (int) (Setting::where('key', 'biaya_seragam_osis')->value('value') ?? 0);
        $olahraga = (int) (Setting::where('key', 'biaya_seragam_olahraga')->value('value') ?? 0);
        $batik = (int) (Setting::where('key', 'biaya_seragam_batik')->value('value') ?? 0);
        $identitas = (int) (Setting::where('key', 'biaya_seragam_identitas')->value('value') ?? 0);

        $total = $osis + $olahraga + $batik + $identitas;

        // Fallback ke biaya_seragam lama jika belum diatur
        if ($total === 0) {
            return (int) (Setting::where('key', 'biaya_seragam')->value('value') ?? 336000);
        }

        return $total;
    }

    public function getTotalTargetAttribute()
    {
        return $this->target_infak + $this->target_lk + $this->target_seragam;
    }
}
