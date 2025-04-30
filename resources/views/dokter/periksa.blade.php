<!-- resources/views/dokter/periksa.blade.php -->
@extends('layout.dokter')

@section('title', 'Periksa Pasien')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Periksa Pasien</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Periksa Pasien</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Daftar Pasien Yang Perlu Diperiksa -->
    <div class="row">
      <div class="col-12">
        @include('tables.table', [
    'title' => 'Daftar Pasien Yang Perlu Diperiksa',
    'tableId' => 'periksaTable',
    'tableClass' => 'table-bordered table-striped',
    'thead' => view('tables.partial.dokter.periksa-thead'),
    'tbody' => view('tables.partial.dokter.periksa-tbody', ['periksa_pasiens' => $periksa_pasiens])
])
      </div>
    </div>
    <!-- /.row -->
    
    <!-- Riwayat Pemeriksaan -->
    <div class="row">
      <div class="col-12">
          @include('tables.table', [
    'title' => 'Riwayat Pemeriksaan',
    'tableId' => 'riwayatTable',
    'tableClass' => 'table-bordered table-striped',
    'thead' => view('tables.partial.dokter.riwayat-thead'),
    'tbody' => view('tables.partial.dokter.riwayat-tbody', ['riwayat_periksa' => $riwayat_periksa])
])
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- Modal Periksa -->
<div class="modal fade" id="modal-periksa">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Periksa Pasien</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('dokter.periksa.update', 1) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="pasien">Nama Pasien</label>
                <input type="text" class="form-control" id="pasien" value="Citra Dewi" readonly>
              </div>
              <div class="form-group">
                <label for="tgl_periksa">Tanggal Periksa</label>
                <input type="text" class="form-control" id="tgl_periksa" value="18 Apr 2025 10:00" readonly>
              </div>
              <div class="form-group">
                <label for="keluhan">Keluhan</label>
                <textarea class="form-control" id="keluhan" rows="3" readonly>Demam dan sakit kepala selama 2 hari</textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="catatan">Catatan Pemeriksaan</label>
                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3" required></textarea>
                @error('catatan')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>
              <div class="form-group">
                <label>Obat</label>
                <div class="select2-purple">
                  <select class="select2" multiple="multiple" name="obat_ids[]" data-placeholder="Pilih obat" style="width: 100%;">
                    <option value="1">Paracetamol (Tablet 500mg) - Rp 10.000</option>
                    <option value="2">Amoxicillin (Kapsul 500mg) - Rp 25.000</option>
                    <option value="3">Ibuprofen (Tablet 400mg) - Rp 15.000</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="biaya_periksa">Biaya Periksa (Rp)</label>
                <input type="number" class="form-control @error('biaya_periksa') is-invalid @enderror" id="biaya_periksa" name="biaya_periksa" value="150000" required>
                @error('biaya_periksa')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan Pemeriksaan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection

@section('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('scripts')
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    });
    
    $("#riwayatTable").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "pageLength": 5
    });
  });
</script>
@endsection