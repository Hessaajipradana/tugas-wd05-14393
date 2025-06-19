<!-- resources/views/dokter/profil.blade.php -->
@extends('layout.dokter')

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
          <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Home</a></li>
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
                   src="{{ asset('dist/img/avatar4.png') }}"
                   alt="User profile picture">
            </div>

            <h3 class="profile-username text-center">{{ $dokter->nama }}</h3>

            <p class="text-muted text-center">{{ $dokter->poli->nama_poli }}</p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Email Login</b> <a class="float-right">{{ $user->email }}</a>
              </li>
              <li class="list-group-item">
                <b>No. HP</b> <a class="float-right">{{ $dokter->no_hp }}</a>
              </li>
              <li class="list-group-item">
                <b>Alamat</b> <a class="float-right">{{ $dokter->alamat ?? '-' }}</a>
              </li>
              <li class="list-group-item">
                <b>Bergabung</b> <a class="float-right">{{ $dokter->created_at->format('M Y') }}</a>
              </li>
            </ul>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
      
      <div class="col-md-8">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Edit Profil</a></li>
              <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Ganti Password</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <!-- Edit Profil Tab -->
              <div class="active tab-pane" id="profile">
                <form id="profileForm" method="POST" action="{{ route('dokter.profil.update') }}">
                  @csrf
                  @method('PUT')
                  
                  <div class="form-group row">
                    <label for="nama" class="col-sm-3 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                             id="nama" name="nama" value="{{ old('nama', $dokter->nama) }}" required>
                      @error('nama')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                      <small class="text-muted">Termasuk gelar dokter (Dr., Sp.A, dll)</small>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                      <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                id="alamat" name="alamat" rows="3">{{ old('alamat', $dokter->alamat) }}</textarea>
                      @error('alamat')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="no_hp" class="col-sm-3 col-form-label">No. HP</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control @error('no_hp') is-invalid @enderror" 
                             id="no_hp" name="no_hp" value="{{ old('no_hp', $dokter->no_hp) }}" required>
                      @error('no_hp')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="id_poli" class="col-sm-3 col-form-label">Poliklinik</label>
                    <div class="col-sm-9">
                      <select class="form-control @error('id_poli') is-invalid @enderror" 
                              id="id_poli" name="id_poli" required>
                        <option value="">-- Pilih Poliklinik --</option>
                        @foreach($polis as $poli)
                        <option value="{{ $poli->id }}" 
                                {{ old('id_poli', $dokter->id_poli) == $poli->id ? 'selected' : '' }}>
                          {{ $poli->nama_poli }}
                        </option>
                        @endforeach
                      </select>
                      @error('id_poli')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <div class="offset-sm-3 col-sm-9">
                      <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->

              <!-- Ganti Password Tab -->
              <div class="tab-pane" id="password">
                <form id="passwordForm" method="POST" action="{{ route('dokter.password.update') }}">
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
                    <label for="new_password" class="col-sm-3 col-form-label">Password Baru</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control @error('password') is-invalid @enderror" 
                             id="new_password" name="password" required minlength="8">
                      @error('password')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                      <small class="text-muted">Minimal 8 karakter</small>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="new_password_confirmation" class="col-sm-3 col-form-label">Konfirmasi Password</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" 
                             id="new_password_confirmation" name="password_confirmation" required minlength="8">
                      <div class="invalid-feedback" id="password-mismatch-error" style="display: none;">
                        Password tidak sama
                      </div>
                      <small class="text-muted">Ulangi password baru</small>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <div class="offset-sm-3 col-sm-9">
                      <button type="submit" class="btn btn-warning" id="passwordSubmitBtn">
                        <i class="fas fa-key"></i> Ganti Password
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
    
    // Password confirmation validation - HANYA untuk form password
    $('#new_password_confirmation').on('keyup blur', function() {
        var password = $('#new_password').val();
        var confirmPassword = $(this).val();
        var errorDiv = $('#password-mismatch-error');
        var submitBtn = $('#passwordSubmitBtn');
        
        if (confirmPassword.length > 0) {
            if (password !== confirmPassword) {
                $(this).removeClass('is-valid').addClass('is-invalid');
                errorDiv.show();
                submitBtn.prop('disabled', true);
            } else {
                $(this).removeClass('is-invalid').addClass('is-valid');
                errorDiv.hide();
                submitBtn.prop('disabled', false);
            }
        } else {
            $(this).removeClass('is-valid is-invalid');
            errorDiv.hide();
            submitBtn.prop('disabled', false);
        }
    });
    
    // Juga validasi ketika password baru diubah
    $('#new_password').on('keyup blur', function() {
        var confirmPassword = $('#new_password_confirmation').val();
        if (confirmPassword.length > 0) {
            $('#new_password_confirmation').trigger('keyup');
        }
    });
    
    // Form validation HANYA untuk password form saat submit
    $('#passwordForm').on('submit', function(e) {
        var password = $('#new_password').val();
        var confirmPassword = $('#new_password_confirmation').val();
        
        if (password !== confirmPassword) {
            e.preventDefault();
            $('#new_password_confirmation').addClass('is-invalid');
            $('#password-mismatch-error').show();
            $('#passwordSubmitBtn').prop('disabled', true);
            return false;
        }
    });
    
    // Reset validation saat pindah tab
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        if ($(e.target).attr('href') === '#password') {
            // Reset form password saat buka tab password
            $('#passwordForm')[0].reset();
            $('#new_password_confirmation').removeClass('is-valid is-invalid');
            $('#password-mismatch-error').hide();
            $('#passwordSubmitBtn').prop('disabled', false);
        }
    });
});
</script>
@endsection