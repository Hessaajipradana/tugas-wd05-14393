<?php
// app/Models/JadwalPeriksa.php (ENHANCED - Operational Hours Logic)
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class JadwalPeriksa extends Model
{
    use HasFactory;

    protected $table = 'jadwal_periksa';
    
    protected $fillable = [
        'id_dokter',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'aktif'
    ];

    protected $casts = [
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
        'aktif' => 'boolean'
    ];

    // Business Logic: Validasi sebelum save
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($jadwal) {
            // Validasi tidak boleh bentrok dengan jadwal lain dokter yang sama
            $bentrok = static::where('id_dokter', $jadwal->id_dokter)
                            ->where('hari', $jadwal->hari)
                            ->where(function($query) use ($jadwal) {
                                $query->whereBetween('jam_mulai', [$jadwal->jam_mulai, $jadwal->jam_selesai])
                                      ->orWhereBetween('jam_selesai', [$jadwal->jam_mulai, $jadwal->jam_selesai])
                                      ->orWhere(function($q) use ($jadwal) {
                                          $q->where('jam_mulai', '<=', $jadwal->jam_mulai)
                                            ->where('jam_selesai', '>=', $jadwal->jam_selesai);
                                      });
                            })
                            ->exists();
            
            if ($bentrok) {
                throw new \Exception('Jadwal bentrok dengan jadwal lain di hari yang sama');
            }
        });
        
        static::updating(function ($jadwal) {
            // ✅ ENHANCED: Tidak boleh ubah jadwal saat sedang operasional
            if ($jadwal->isCurrentlyOperational()) {
                throw new \Exception('Tidak boleh mengubah jadwal saat sedang dalam jam operasional');
            }
            
            // Tidak boleh ubah jadwal di hari H (jika tidak sedang operasional)
            $today = Carbon::now('Asia/Jakarta')->locale('id')->dayName;
            if ($jadwal->hari === $today && !$jadwal->isCurrentlyOperational()) {
                // Boleh ubah setelah jam operasional selesai
                if (!$jadwal->isOperationalFinished()) {
                    throw new \Exception('Tidak boleh mengubah jadwal di hari H sebelum jam operasional dimulai');
                }
            }
        });
    }

    // Relasi ke dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter');
    }

    // Relasi ke daftar poli
    public function daftarPoli()
    {
        return $this->hasMany(DaftarPoli::class, 'id_jadwal');
    }

    // ✅ NEW: Cek apakah jadwal sedang dalam jam operasional
    public function isCurrentlyOperational()
    {
        $now = Carbon::now('Asia/Jakarta');
        $today = $now->locale('id')->dayName;
        
        // Harus hari yang sama dan jadwal aktif
        if ($this->hari !== $today || !$this->aktif) {
            return false;
        }
        
        // Parse jam mulai dan selesai untuk hari ini
        $jamMulai = Carbon::today('Asia/Jakarta')->setTimeFromTimeString($this->jam_mulai->format('H:i:s'));
        $jamSelesai = Carbon::today('Asia/Jakarta')->setTimeFromTimeString($this->jam_selesai->format('H:i:s'));
        
        // Cek apakah waktu sekarang berada di antara jam mulai dan selesai
        return $now->between($jamMulai, $jamSelesai);
    }

    // ✅ NEW: Cek apakah jadwal hari ini sudah selesai
    public function isOperationalFinished()
    {
        $now = Carbon::now('Asia/Jakarta');
        $today = $now->locale('id')->dayName;
        
        if ($this->hari !== $today) {
            return false;
        }
        
        $jamSelesai = Carbon::today('Asia/Jakarta')->setTimeFromTimeString($this->jam_selesai->format('H:i:s'));
        
        return $now->greaterThan($jamSelesai);
    }

    // ✅ NEW: Cek apakah jadwal belum dimulai hari ini
    public function isOperationalNotStarted()
    {
        $now = Carbon::now('Asia/Jakarta');
        $today = $now->locale('id')->dayName;
        
        if ($this->hari !== $today) {
            return false;
        }
        
        $jamMulai = Carbon::today('Asia/Jakarta')->setTimeFromTimeString($this->jam_mulai->format('H:i:s'));
        
        return $now->lessThan($jamMulai);
    }

    // ✅ NEW: Get status display untuk UI
    public function getOperationalStatus()
    {
        if (!$this->aktif) {
            return [
                'status' => 'inactive',
                'label' => 'Tidak Aktif',
                'class' => 'badge-secondary',
                'icon' => 'fas fa-times'
            ];
        }

        $now = Carbon::now('Asia/Jakarta');
        $today = $now->locale('id')->dayName;
        
        if ($this->hari !== $today) {
            return [
                'status' => 'active',
                'label' => 'Aktif',
                'class' => 'badge-success',
                'icon' => 'fas fa-check'
            ];
        }

        // Hari ini - cek jam operasional
        if ($this->isCurrentlyOperational()) {
            $jamSelesai = Carbon::today('Asia/Jakarta')->setTimeFromTimeString($this->jam_selesai->format('H:i:s'));
            $sisaWaktu = $now->diffInMinutes($jamSelesai);
            
            return [
                'status' => 'operational',
                'label' => "Sedang Operasional (sisa {$sisaWaktu} menit)",
                'class' => 'badge-warning',
                'icon' => 'fas fa-clock',
                'remaining_minutes' => $sisaWaktu
            ];
        }

        if ($this->isOperationalFinished()) {
            return [
                'status' => 'finished',
                'label' => 'Selesai Operasional',
                'class' => 'badge-info',
                'icon' => 'fas fa-check-circle'
            ];
        }

        if ($this->isOperationalNotStarted()) {
            $jamMulai = Carbon::today('Asia/Jakarta')->setTimeFromTimeString($this->jam_mulai->format('H:i:s'));
            $menunggu = $jamMulai->diffInMinutes($now);
            
            return [
                'status' => 'waiting',
                'label' => "Menunggu ({$menunggu} menit lagi)",
                'class' => 'badge-primary',
                'icon' => 'fas fa-hourglass-half'
            ];
        }

        return [
            'status' => 'active',
            'label' => 'Aktif',
            'class' => 'badge-success',
            'icon' => 'fas fa-check'
        ];
    }

    // ✅ NEW: Cek apakah dokter sedang ada yang operasional
    public static function isDoctorCurrentlyOperational($dokterId)
    {
        return static::where('id_dokter', $dokterId)
                    ->where('aktif', true)
                    ->get()
                    ->contains(function ($jadwal) {
                        return $jadwal->isCurrentlyOperational();
                    });
    }

    // ✅ NEW: Get jadwal yang sedang operasional untuk dokter
    public static function getCurrentOperationalSchedule($dokterId)
    {
        return static::where('id_dokter', $dokterId)
                    ->where('aktif', true)
                    ->get()
                    ->first(function ($jadwal) {
                        return $jadwal->isCurrentlyOperational();
                    });
    }

    // ✅ ENHANCED: set jadwal sebagai aktif dengan validasi operasional
    public function setAsActive()
    {
        // Cek apakah ada jadwal lain yang sedang operasional
        $currentOperational = static::getCurrentOperationalSchedule($this->id_dokter);
        
        if ($currentOperational && $currentOperational->id !== $this->id) {
            $status = $currentOperational->getOperationalStatus();
            throw new \Exception("Tidak dapat mengaktifkan jadwal. Masih dalam jam operasional: {$currentOperational->hari} {$currentOperational->jam_mulai->format('H:i')}-{$currentOperational->jam_selesai->format('H:i')} ({$status['remaining_minutes']} menit tersisa)");
        }
        
        // Nonaktifkan semua jadwal dokter ini
        static::where('id_dokter', $this->id_dokter)->update(['aktif' => false]);
        
        // Aktifkan jadwal ini
        $this->update(['aktif' => true]);
    }

    // Helper: mendapatkan nomor antrian berikutnya untuk tanggal tertentu
    public function getNextQueueNumber($date)
    {
        $lastQueue = $this->daftarPoli()
                          ->where('tanggal_daftar', $date)
                          ->max('no_antrian');
        
        return ($lastQueue ?? 0) + 1;
    }

    // Helper: apakah jadwal tersedia di tanggal tertentu
    public function isAvailableOn($date)
    {
        $dayName = Carbon::parse($date)->locale('id')->dayName;
        return $this->hari === $dayName && $this->aktif;
    }

    // Helper: jumlah pasien yang sudah daftar hari ini
    public function jumlahAntrianHariIni()
    {
        return $this->daftarPoli()
                   ->where('tanggal_daftar', Carbon::today('Asia/Jakarta')->format('Y-m-d'))
                   ->count();
    }

    // ✅ NEW: Cek apakah jadwal bisa di-edit
    public function canBeEdited()
    {
        // Tidak bisa edit jika sedang operasional
        if ($this->isCurrentlyOperational()) {
            return false;
        }
        
        // Tidak bisa edit di hari H sebelum operasional dimulai (kecuali sudah selesai)
        $today = Carbon::now('Asia/Jakarta')->locale('id')->dayName;
        if ($this->hari === $today && !$this->isOperationalFinished()) {
            return false;
        }
        
        return true;
    }

    // ✅ NEW: Get waktu tersisa hingga operasional selesai (dalam menit)
    public function getRemainingOperationalMinutes()
    {
        if (!$this->isCurrentlyOperational()) {
            return 0;
        }
        
        $now = Carbon::now('Asia/Jakarta');
        $jamSelesai = Carbon::today('Asia/Jakarta')->setTimeFromTimeString($this->jam_selesai->format('H:i:s'));
        
        return $now->diffInMinutes($jamSelesai);
    }
}