<!-- resources/views/dokter/jadwal.blade.php - ENHANCED -->
@extends('layout.dokter')

@section('title', 'Jadwal Periksa')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Jadwal Periksa Saya</h1>
        <!-- ✅ Real-time Operational Status -->
        <div id="operational-status" class="mt-2">
          @if(isset($isCurrentlyOperational) && $isCurrentlyOperational)
            @php $current = $currentOperationalSchedule; @endphp
            <div class="alert alert-warning mb-0 py-2">
              <i class="fas fa-clock mr-2"></i>
              <strong>Sedang Operasional:</strong> {{ $current->hari }} 
              {{ $current->jam_mulai->format('H:i') }}-{{ $current->jam_selesai->format('H:i') }}
              <span class="ml-2" id="remaining-time"></span>
            </div>
          @else
            <div class="alert alert-info mb-0 py-2" id="non-operational-status">
              <i class="fas fa-check-circle mr-2"></i>
              <strong>Status:</strong> Tidak sedang operasional
            </div>
          @endif
        </div>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Jadwal Periksa</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <i class="icon fas fa-check"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <i class="icon fas fa-ban"></i> {{ session('error') }}
    </div>
    @endif

    <div class="row">
      <div class="col-md-4">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title" id="form-title">Tambah Jadwal Baru</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form id="jadwalForm" method="POST" action="{{ route('dokter.jadwal.store') }}">
            @csrf
            <input type="hidden" name="_method" id="method" value="POST">
            <input type="hidden" name="id" id="jadwal_id">
            
            <div class="card-body">
              <div class="form-group">
                <label for="hari">Hari Praktik</label>
                <select class="form-control @error('hari') is-invalid @enderror" id="hari" name="hari" required>
                  <option value="">-- Pilih Hari --</option>
                  <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                  <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                  <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                  <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                  <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                  <option value="Sabtu" {{ old('hari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                  <option value="Minggu" {{ old('hari') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                </select>
                @error('hari')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              
              <div class="form-group">
                <label for="jam_mulai">Jam Mulai</label>
                <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" 
                       id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}" required>
                @error('jam_mulai')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              
              <div class="form-group">
                <label for="jam_selesai">Jam Selesai</label>
                <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror" 
                       id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai') }}" required>
                @error('jam_selesai')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary" id="btnSimpan">
                <i class="fas fa-save"></i> Simpan Jadwal
              </button>
              <button type="button" id="btnCancel" class="btn btn-default" style="display: none;">
                <i class="fas fa-times"></i> Batal
              </button>
            </div>
          </form>
        </div>
        <!-- /.card -->

        <!-- ✅ ENHANCED: Info Box dengan Real-time Clock -->
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Informasi Jadwal</h3>
            <div class="card-tools">
              <span class="badge badge-info" id="current-time">
                <i class="fas fa-clock"></i> <span id="live-clock">{{ \Carbon\Carbon::now('Asia/Jakarta')->format('H:i:s') }}</span>
              </span>
            </div>
          </div>
          <div class="card-body">
            <div class="alert alert-info">
              <h5><i class="icon fas fa-info"></i> Aturan Jadwal:</h5>
              <ul class="mb-0 pl-3">
                <li>Anda dapat memiliki lebih dari satu jadwal</li>
                <li>Hanya <strong>satu jadwal</strong> yang dapat aktif dalam satu waktu</li>
                <li>Jadwal tidak dapat diubah saat <strong>sedang operasional</strong></li>
                <li>Tidak bisa aktifkan jadwal lain saat masih dalam jam operasional</li>
                <li>Pastikan tidak ada jadwal yang bentrok</li>
              </ul>
            </div>

            <!-- ✅ NEW: Operational Hours Status -->
            <div class="alert alert-warning" id="operational-warning" style="display: none;">
              <h6><i class="fas fa-exclamation-triangle"></i> Peringatan Operasional:</h6>
              <p class="mb-0">Anda sedang dalam jam operasional. Tidak dapat mengaktifkan jadwal lain hingga operasional selesai.</p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Daftar Jadwal Periksa</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-sm btn-info" id="refresh-status">
                <i class="fas fa-sync-alt"></i> Refresh Status
              </button>
            </div>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-bordered table-striped" id="jadwalTable">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>Hari</th>
                  <th>Jam Mulai</th>
                  <th>Jam Selesai</th>
                  <th>Status</th>
                  <th width="25%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($jadwals as $key => $jadwal)
                @php $status = $jadwal->getOperationalStatus(); @endphp
                <tr data-jadwal-id="{{ $jadwal->id }}">
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $jadwal->hari }}</td>
                  <td>{{ $jadwal->jam_mulai->format('H:i') }}</td>
                  <td>{{ $jadwal->jam_selesai->format('H:i') }}</td>
                  <td>
                    <span class="badge {{ $status['class'] }} status-badge" id="status-{{ $jadwal->id }}">
                      <i class="{{ $status['icon'] }}"></i> <span class="status-text">{{ $status['label'] }}</span>
                    </span>
                  </td>
                  <td>
                    <div class="btn-group" id="actions-{{ $jadwal->id }}">
                      @if(!$jadwal->aktif)
                        <button type="button" 
                                class="btn btn-sm btn-success btn-activate"
                                data-id="{{ $jadwal->id }}"
                                data-hari="{{ $jadwal->hari }}"
                                data-jam="{{ $jadwal->jam_mulai->format('H:i') }}-{{ $jadwal->jam_selesai->format('H:i') }}"
                                title="Aktifkan jadwal ini">
                          <i class="fas fa-power-off"></i> Aktifkan
                        </button>
                      @else
                        <span class="badge badge-success">
                          <i class="fas fa-check"></i> Jadwal Aktif
                        </span>
                      @endif
                      
                      @if($jadwal->canBeEdited())
                        <button type="button" class="btn btn-sm btn-warning btn-edit"
                                data-id="{{ $jadwal->id }}"
                                data-hari="{{ $jadwal->hari }}"
                                data-jam_mulai="{{ $jadwal->jam_mulai->format('H:i') }}"
                                data-jam_selesai="{{ $jadwal->jam_selesai->format('H:i') }}"
                                title="Edit jadwal">
                          <i class="fas fa-edit"></i>
                        </button>
                      @else
                        <span class="badge badge-warning" title="Tidak dapat diubah saat operasional">
                          <i class="fas fa-lock"></i> Terkunci
                        </span>
                      @endif
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ✅ NEW: Modal Konfirmasi Aktivasi dengan Operational Warning -->
  <div class="modal fade" id="activateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title">Konfirmasi Aktivasi Jadwal</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yakin ingin mengaktifkan jadwal?</p>
          <div class="alert alert-info">
            <strong>Jadwal yang akan diaktifkan:</strong><br>
            <strong id="activate-schedule-info"></strong>
          </div>
          <div class="alert alert-warning" id="operational-alert" style="display: none;">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Peringatan:</strong> <span id="operational-message"></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <form id="activateForm" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-success" id="confirm-activate">
              <i class="fas fa-power-off"></i> Ya, Aktifkan
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /.content -->
@endsection

@section('scripts')
<script>
$(function () {
    // Auto-close alerts after 5 seconds
    $("#success-alert, #error-alert").fadeTo(5000, 500).slideUp(500);
    
    // ✅ Real-time Clock
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', {
            timeZone: 'Asia/Jakarta',
            hour12: false
        });
        $('#live-clock').text(timeString);
    }
    
    updateClock();
    setInterval(updateClock, 1000);
    
    // DataTable inisialisasi
    $('#jadwalTable').DataTable({
      responsive: true,
      lengthChange: false,
      autoWidth: false,
      order: [[1, 'asc']], // Sort by hari
      language: {
        search: "Cari:",
        lengthMenu: "Tampilkan _MENU_ data per halaman",
        zeroRecords: "Data tidak ditemukan",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
        infoFiltered: "(difilter dari _MAX_ total data)",
        paginate: {
          first: "Pertama",
          last: "Terakhir",
          next: "Selanjutnya",
          previous: "Sebelumnya"
        }
      }
    });

    // ✅ ENHANCED: Real-time Status Update
    function updateScheduleStatus() {
        $.ajax({
            url: '/dokter/jadwal/status',
            method: 'GET',
            success: function(response) {
                // Update setiap status jadwal
                $.each(response.schedules, function(jadwalId, data) {
                    const statusBadge = $('#status-' + jadwalId);
                    const actionsDiv = $('#actions-' + jadwalId);
                    
                    // Update status badge
                    statusBadge.removeClass().addClass('badge ' + data.class + ' status-badge');
                    statusBadge.find('i').removeClass().addClass(data.icon);
                    statusBadge.find('.status-text').text(data.label);
                    
                    // Update action buttons berdasarkan status
                    updateActionButtons(jadwalId, data, response.is_currently_operational);
                });
                
                // Update operational warning
                if (response.is_currently_operational) {
                    $('#operational-warning').show();
                    $('#operational-status').show();
                } else {
                    $('#operational-warning').hide();
                    $('#non-operational-status').show();
                }
            },
            error: function() {
                console.log('Error updating schedule status');
            }
        });
    }
    
    function updateActionButtons(jadwalId, data, isCurrentlyOperational) {
        const actionsDiv = $('#actions-' + jadwalId);
        const activateBtn = actionsDiv.find('.btn-activate');
        const editBtn = actionsDiv.find('.btn-edit');
        
        // Disable/enable buttons berdasarkan status
        if (data.is_operational) {
            // Jadwal sedang operasional - disable semua except yang active
            activateBtn.prop('disabled', true).attr('title', 'Sedang operasional');
            editBtn.prop('disabled', true).attr('title', 'Tidak dapat diedit saat operasional');
        } else if (isCurrentlyOperational && !data.status.includes('active')) {
            // Ada jadwal lain yang operasional - disable activate
            activateBtn.prop('disabled', true).attr('title', 'Masih ada jadwal operasional lain');
        } else {
            // Normal state
            activateBtn.prop('disabled', false).attr('title', 'Aktifkan jadwal ini');
            if (data.can_be_edited) {
                editBtn.prop('disabled', false).attr('title', 'Edit jadwal');
            }
        }
    }
    
    // Update status setiap 30 detik
    setInterval(updateScheduleStatus, 30000);
    
    // Manual refresh
    $('#refresh-status').on('click', function() {
        updateScheduleStatus();
        $(this).find('i').addClass('fa-spin');
        setTimeout(() => {
            $(this).find('i').removeClass('fa-spin');
        }, 1000);
    });

    // ✅ ENHANCED: Activate button dengan modal konfirmasi
    $(document).on('click', '.btn-activate', function () {
        if ($(this).prop('disabled')) {
            return false;
        }
        
        const id = $(this).data('id');
        const hari = $(this).data('hari');
        const jam = $(this).data('jam');
        
        $('#activate-schedule-info').text(hari + ' ' + jam);
        $('#activateForm').attr('action', '/dokter/jadwal/' + id + '/activate');
        
        // Cek apakah ada peringatan operasional
        $.ajax({
            url: '/dokter/jadwal/status',
            method: 'GET',
            success: function(response) {
                if (response.is_currently_operational) {
                    $('#operational-alert').show();
                    $('#operational-message').text('Anda masih dalam jam operasional. Aktivasi mungkin akan gagal.');
                    $('#confirm-activate').removeClass('btn-success').addClass('btn-warning');
                } else {
                    $('#operational-alert').hide();
                    $('#confirm-activate').removeClass('btn-warning').addClass('btn-success');
                }
                
                $('#activateModal').modal('show');
            }
        });
    });

    // Handler edit jadwal (existing)
    $(document).on('click', '.btn-edit', function () {
        if ($(this).prop('disabled')) {
            alert('Jadwal tidak dapat diedit saat sedang operasional!');
            return false;
        }
        
        $('#jadwal_id').val($(this).data('id'));
        $('#hari').val($(this).data('hari'));
        $('#jam_mulai').val($(this).data('jam_mulai'));
        $('#jam_selesai').val($(this).data('jam_selesai'));
        $('#form-title').text('Edit Jadwal');
        
        $('.card-primary').removeClass('card-primary').addClass('card-warning');
        $('#btnSimpan').removeClass('btn-primary').addClass('btn-warning').html('<i class="fas fa-save"></i> Update Jadwal');
        $('#method').val('PUT');
        $('#jadwalForm').attr('action', '/dokter/jadwal/' + $(this).data('id'));
        $('#btnCancel').show();
        
        // Scroll to form
        $('html, body').animate({
            scrollTop: $("#jadwalForm").offset().top - 100
        }, 500);
    });

    // Cancel edit
    $('#btnCancel').on('click', function () {
        resetForm();
    });

    function resetForm() {
        $('#jadwalForm')[0].reset();
        $('#form-title').text('Tambah Jadwal Baru');
        $('.card-warning').removeClass('card-warning').addClass('card-primary');
        $('#btnSimpan').removeClass('btn-warning').addClass('btn-primary').html('<i class="fas fa-save"></i> Simpan Jadwal');
        $('#method').val('POST');
        $('#jadwalForm').attr('action', '{{ route('dokter.jadwal.store') }}');
        $('#btnCancel').hide();
    }
    
    // Validasi jam
    $('#jam_selesai').on('change', function() {
        var jamMulai = $('#jam_mulai').val();
        var jamSelesai = $(this).val();
        
        if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
            alert('Jam selesai harus lebih besar dari jam mulai!');
            $(this).val('');
        }
    });
    
    // ✅ Initial status update
    updateScheduleStatus();
});
</script>
@endsection