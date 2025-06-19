<!-- resources/views/dokter/dashboard.blade.php - ENHANCED -->
@extends('layout.dokter')

@section('title', 'Dashboard Dokter')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard Dokter</h1>
        <p class="text-muted">Selamat datang, {{ Auth::user()->nama }}!</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
    
    <!-- ✅ NEW: Jadwal Hari Ini Alert -->
    @if($jadwalHariIni)
      @php $status = $jadwalData['status']; @endphp
      <div class="row">
        <div class="col-12">
          <div class="alert alert-{{ $status['status'] == 'operational' ? 'warning' : ($status['status'] == 'finished' ? 'info' : 'success') }} alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="{{ $status['icon'] }}"></i> Jadwal Hari Ini ({{ $today }})</h5>
            <strong>{{ $jadwalHariIni->jam_mulai->format('H:i') }} - {{ $jadwalHariIni->jam_selesai->format('H:i') }}</strong>
            <span class="ml-2">{{ $status['label'] }}</span>
            @if($status['status'] == 'operational')
              <div class="mt-2">
                <small>
                  <i class="fas fa-clock"></i> Waktu sekarang: <strong id="current-time">{{ $jadwalData['current_time'] }}</strong> | 
                  Sisa waktu: <strong><span id="remaining-minutes">{{ $jadwalData['remaining_minutes'] }}</span> menit</strong>
                </small>
              </div>
            @endif
          </div>
        </div>
      </div>
    @else
      <div class="row">
        <div class="col-12">
          <div class="alert alert-secondary alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="fas fa-calendar-times"></i> Jadwal Hari Ini ({{ $today }})</h5>
            <strong>Tidak ada jadwal hari ini</strong>
            <p class="mb-0">
              <a href="{{ route('dokter.jadwal') }}" class="btn btn-sm btn-primary mt-2">
                <i class="fas fa-plus"></i> Atur Jadwal Praktik
              </a>
            </p>
          </div>
        </div>
      </div>
    @endif
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ $pasien_count ?? 0 }}</h3>
            <p>Pasien Hari Ini</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="{{ route('dokter.periksa') }}" class="small-box-footer">Lihat semua <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ $obat_count ?? 0 }}</h3>
            <p>Jumlah Obat</p>
          </div>
          <div class="icon">
            <i class="ion ion-medkit"></i>
          </div>
          <a href="{{ route('dokter.obat') }}" class="small-box-footer">Lihat semua <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      
      <div class="col-lg-3 col-6">
        <!-- ✅ ENHANCED: Smart Jadwal Display -->
        <div class="small-box {{ $jadwalHariIni ? 'bg-warning' : 'bg-secondary' }}">
          <div class="inner">
            @if($jadwalHariIni)
              <h3>{{ $jadwalHariIni->jam_mulai->format('H:i') }} - {{ $jadwalHariIni->jam_selesai->format('H:i') }}</h3>
              <p>Jadwal Hari Ini</p>
              @if($jadwalData['is_operational'])
                <div class="progress" style="height: 4px;">
                  @php
                    $totalMinutes = $jadwalHariIni->jam_mulai->diffInMinutes($jadwalHariIni->jam_selesai);
                    $remainingMinutes = $jadwalData['remaining_minutes'];
                    $progressPercent = (($totalMinutes - $remainingMinutes) / $totalMinutes) * 100;
                  @endphp
                  <div class="progress-bar" style="width: {{ $progressPercent }}%"></div>
                </div>
              @endif
            @else
              <h3><i class="fas fa-calendar-times"></i></h3>
              <p>Tidak Ada Jadwal</p>
            @endif
          </div>
          <div class="icon">
            <i class="ion {{ $jadwalHariIni ? 'ion-clock' : 'ion-calendar' }}"></i>
          </div>
          <a href="{{ route('dokter.jadwal') }}" class="small-box-footer">
            {{ $jadwalHariIni ? 'Kelola jadwal' : 'Atur jadwal' }} <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <!-- ./col -->
      
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{ $total_periksa ?? 0 }}</h3>
            <p>Total Pemeriksaan</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="{{ route('dokter.periksa') }}" class="small-box-footer">Info lainnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->
    
    <!-- ✅ NEW: Quick Actions & Status Cards -->
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-tasks mr-2"></i>
              Quick Actions
            </h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="info-box">
                  <span class="info-box-icon bg-primary">
                    <i class="fas fa-stethoscope"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Periksa Pasien</span>
                    <span class="info-box-number">{{ $pasien_count }} antrian</span>
                    <a href="{{ route('dokter.periksa') }}" class="btn btn-sm btn-primary mt-1">
                      <i class="fas fa-arrow-right"></i> Mulai Periksa
                    </a>
                  </div>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="info-box">
                  <span class="info-box-icon bg-success">
                    <i class="fas fa-pills"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Kelola Obat</span>
                    <span class="info-box-number">{{ $obat_count }} tersedia</span>
                    <a href="{{ route('dokter.obat') }}" class="btn btn-sm btn-success mt-1">
                      <i class="fas fa-arrow-right"></i> Kelola Obat
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-info-circle mr-2"></i>
              Status Praktik
            </h3>
          </div>
          <div class="card-body">
            @if($jadwalHariIni)
              @php $status = $jadwalData['status']; @endphp
              <div class="text-center">
                <i class="{{ $status['icon'] }} fa-3x mb-3 text-{{ $status['status'] == 'operational' ? 'warning' : ($status['status'] == 'finished' ? 'info' : 'success') }}"></i>
                <h5>{{ $status['label'] }}</h5>
                <p class="text-muted">
                  {{ $jadwalHariIni->jam_mulai->format('H:i') }} - {{ $jadwalHariIni->jam_selesai->format('H:i') }}
                </p>
                
                @if($jadwalData['is_operational'])
                  <div class="progress mb-3">
                    @php
                      $totalMinutes = $jadwalHariIni->jam_mulai->diffInMinutes($jadwalHariIni->jam_selesai);
                      $remainingMinutes = $jadwalData['remaining_minutes'];
                      $progressPercent = (($totalMinutes - $remainingMinutes) / $totalMinutes) * 100;
                    @endphp
                    <div class="progress-bar bg-warning" style="width: {{ $progressPercent }}%"></div>
                  </div>
                  <small class="text-muted">
                    Sisa {{ $jadwalData['remaining_minutes'] }} menit
                  </small>
                @endif
              </div>
            @else
              <div class="text-center">
                <i class="fas fa-calendar-times fa-3x mb-3 text-muted"></i>
                <h5>Tidak Ada Jadwal</h5>
                <p class="text-muted">Hari ini ({{ $today }})</p>
                <a href="{{ route('dokter.jadwal') }}" class="btn btn-primary btn-sm">
                  <i class="fas fa-plus"></i> Buat Jadwal
                </a>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('scripts')
<script>
$(function() {
  @if($jadwalHariIni && $jadwalData['is_operational'])
    // ✅ Real-time countdown untuk jadwal operasional
    function updateCountdown() {
        const now = new Date();
        const currentTime = now.toLocaleTimeString('id-ID', {
            timeZone: 'Asia/Jakarta',
            hour12: false,
            hour: '2-digit',
            minute: '2-digit'
        });
        
        $('#current-time').text(currentTime);
        
        // Update remaining minutes (simple calculation)
        const endTime = new Date();
        const [endHour, endMinute] = '{{ $jadwalHariIni->jam_selesai->format("H:i") }}'.split(':');
        endTime.setHours(parseInt(endHour), parseInt(endMinute), 0, 0);
        
        const diffMs = endTime - now;
        const diffMinutes = Math.max(0, Math.floor(diffMs / (1000 * 60)));
        
        $('#remaining-minutes').text(diffMinutes);
        
        // Auto redirect atau refresh jika waktu habis
        if (diffMinutes <= 0) {
            location.reload();
        }
    }
    
    // Update setiap menit
    updateCountdown();
    setInterval(updateCountdown, 60000);
  @endif
  
  // Auto-close alerts after 10 seconds
  setTimeout(function() {
    $('.alert').fadeOut('slow');
  }, 10000);
});
</script>
@endsection