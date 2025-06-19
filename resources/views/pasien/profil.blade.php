<!-- resources/views/pasien/profil.blade.php -->
@extends('layout.pasien')

@section('title', 'Profil Saya')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Profil Saya</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('pasien.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Profil</li>
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
      <!-- Profil Info -->
      <div class="col-md-4">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle"
                   src="{{ asset('dist/img/avatar5.png') }}"
                   alt="User profile picture">
            </div>

            <h3 class="profile-username text-center">{{ $pasien->nama }}</h3>

            <p class="text-muted text-center">Pasien - No. RM: {{ $pasien->no_rm }}</p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Email Login</b> <a class="float-right">{{ $user->email }}</a>
              </li>
              <li class="list-group-item">
                <b>No. RM</b> 
                <a class="float-right">
                  <span class="badge badge-success">{{ $pasien->no_rm }}</span>
                </a>
              </li>
              <li class="list-group-item">
                <b>No. KTP</b> 
                <a class="float-right">
                  <code>{{ $pasien->no_ktp }}</code>
                </a>
              </li>
              <li class="list-group-item">
                <b>No. HP</b> <a class="float-right">{{ $pasien->no_hp }}</a>
              </li>
              <li class="list-group-item">
                <b>Alamat</b> <a class="float-right">{{ Str::limit($pasien->alamat, 30) ?? '-' }}</a>
              </li>
              <li class="list-group-item">
                <b>Bergabung</b> <a class="float-right">{{ $pasien->created_at->format('M Y') }}</a>
              </li>
            </ul>

            <!-- ✅ Quick Stats -->
            <div class="row text-center">
              <div class="col-4">
                <div class="description-block">
                  <h5 class="description-header">{{ $pasien->daftarPoli()->count() }}</h5>
                  <span class="description-text">Kunjungan</span>
                </div>
              </div>
              <div class="col-4">
                <div class="description-block">
                  <h5 class="description-header">{{ $pasien->riwayatPeriksa()->count() }}</h5>
                  <span class="description-text">Pemeriksaan</span>
                </div>
              </div>
              <div class="col-4">
                <div class="description-block">
                  @php
                    $lastVisit = $pasien->riwayatPeriksa()->latest('tgl_periksa')->first();
                  @endphp
                  <h5 class="description-header">
                    {{ $lastVisit ? $lastVisit->tgl_periksa->diffInDays() : '-' }}
                  </h5>
                  <span class="description-text">Hari Lalu</span>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- ✅ Info Card -->
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Informasi Penting</h3>
          </div>
          <div class="card-body">
            <div class="alert alert-info">
              <h6><i class="icon fas fa-info"></i> Tentang Data Anda:</h6>
              <ul class="mb-0 pl-3">
                <li><strong>No. RM & No. KTP</strong> tidak dapat diubah</li>
                <li>Data ini digunakan untuk identifikasi medis</li>
                <li>Jika ada kesalahan, hubungi administrator</li>
                <li>Password sebaiknya diganti secara berkala</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- /.col -->
      
      <div class="col-md-8">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#form-edit-profil" data-toggle="tab">Edit Profil</a></li>
              <li class="nav-item"><a class="nav-link" href="#form-ganti-password" data-toggle="tab">Ganti Password</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <!-- Edit Profil Tab -->
              <div class="active tab-pane" id="form-edit-profil">
                <form method="POST" action="{{ route('pasien.profil.update') }}">
                  @csrf
                  @method('PUT')
                  
                  <!-- ✅ Read-only Fields -->
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">No. Rekam Medis</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control-plaintext" 
                             value="{{ $pasien->no_rm }}" readonly>
                      <small class="text-muted">Nomor rekam medis tidak dapat diubah</small>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">No. KTP</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control-plaintext" 
                             value="{{ $pasien->no_ktp }}" readonly>
                      <small class="text-muted">Nomor KTP tidak dapat diubah</small>
                    </div>
                  </div>

                  <hr>

                  <!-- ✅ Editable Fields -->
                  <div class="form-group row">
                    <label for="nama" class="col-sm-3 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                             id="nama" name="nama" value="{{ old('nama', $pasien->nama) }}" required>
                      @error('nama')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                      <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                id="alamat" name="alamat" rows="3" required>{{ old('alamat', $pasien->alamat) }}</textarea>
                      @error('alamat')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="no_hp" class="col-sm-3 col-form-label">No. HP</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control @error('no_hp') is-invalid @enderror" 
                             id="no_hp" name="no_hp" value="{{ old('no_hp', $pasien->no_hp) }}" required>
                      @error('no_hp')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                      <small class="text-muted">Gunakan format: 081234567890</small>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <div class="offset-sm-3 col-sm-9">
                      <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                      </button>
                      <button type="reset" class="btn btn-secondary ml-2">
                        <i class="fas fa-undo"></i> Reset
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->

              <!-- Ganti Password Tab -->
              <div class="tab-pane" id="form-ganti-password">
                <form method="POST" action="{{ route('pasien.password.update') }}">
                  @csrf
                  @method('PUT')
                  
                  <div class="form-group row">
                    <label for="current_password" class="col-sm-3 col-form-label">Password Lama</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                             id="current_password" name="current_password" required>
                      @error('current_password')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="password" class="col-sm-3 col-form-label">Password Baru</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control @error('password') is-invalid @enderror" 
                             id="password" name="password" required minlength="8">
                      @error('password')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                      <small class="text-muted">Minimal 8 karakter</small>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="password_confirmation" class="col-sm-3 col-form-label">Konfirmasi Password</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" 
                             id="password_confirmation" name="password_confirmation" required minlength="8">
                      <small class="text-muted">Ulangi password baru</small>
                    </div>
                  </div>

                  <!-- ✅ Password Strength Indicator -->
                  <div class="form-group row">
                    <div class="offset-sm-3 col-sm-9">
                      <div class="progress" style="height: 4px;">
                        <div class="progress-bar" id="password-strength" style="width: 0%"></div>
                      </div>
                      <small class="text-muted" id="password-feedback">Masukkan password untuk melihat kekuatan</small>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <div class="offset-sm-3 col-sm-9">
                      <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key"></i> Ganti Password
                      </button>
                      <button type="reset" class="btn btn-secondary ml-2">
                        <i class="fas fa-times"></i> Batal
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('scripts')
<script>
$(function () {
    // Auto-close alerts after 5 seconds
    $(".alert").fadeTo(5000, 500).slideUp(500);
    
    // ✅ Password strength checker & konfirmasi hanya di form ganti password
$('#form-ganti-password #password').on('keyup', function() {
    const password = $(this).val();
    const strength = checkPasswordStrength(password);
    
    $('#password-strength')
        .removeClass('bg-danger bg-warning bg-success')
        .addClass(strength.class)
        .css('width', strength.percent + '%');
        
    $('#password-feedback').text(strength.message);
});

$('#form-ganti-password #password_confirmation').on('keyup', function() {
    var password = $('#form-ganti-password #password').val();
    var confirmPassword = $(this).val();
    
    if (password !== confirmPassword && confirmPassword.length > 0) {
        $(this).removeClass('is-valid').addClass('is-invalid');
        if (!$(this).next('.invalid-feedback').length) {
            $(this).after('<div class="invalid-feedback">Password tidak sama</div>');
        }
    } else if (confirmPassword.length > 0) {
        $(this).removeClass('is-invalid').addClass('is-valid');
        $(this).next('.invalid-feedback').remove();
    }
});

// ✅ Form validation before submit
$('#form-ganti-password').on('submit', function(e) {
    var password = $('#password').val();
    var confirmPassword = $('#password_confirmation').val();

    if (password !== confirmPassword) {
        e.preventDefault();
        $('#password_confirmation').addClass('is-invalid');
        if (!$('#password_confirmation').next('.invalid-feedback').length) {
            $('#password_confirmation').after('<div class="invalid-feedback">Password tidak sama</div>');
        }
        return false;
    }
});


    // ✅ Phone number formatting
    $('#no_hp').on('input', function() {
        let value = $(this).val().replace(/\D/g, ''); // Remove non-digits
        if (value.length > 0 && !value.startsWith('0')) {
            value = '0' + value;
        }
        $(this).val(value);
    });
});
</script>
@endsection