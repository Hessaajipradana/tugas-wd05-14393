<!-- resources/views/pasien/riwayat.blade.php -->
@extends('layout.pasien')

@section('title', 'Riwayat Periksa')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Riwayat Periksa</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('pasien.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Riwayat Periksa</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        @include('tables.table', [
    'title' => 'Daftar Riwayat Periksa',
    'tableId' => 'riwayatTable',
    'tableClass' => 'table-bordered table-striped',
    'thead' => view('tables.partial.pasien.riwayat-thead'),
    'tbody' => view('tables.partial.pasien.riwayat-tbody', ['riwayats' => $riwayats])
])
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- Modal Detail -->
@if(isset($riwayats) && count($riwayats) > 0)
  @foreach($riwayats as $riwayat)
  <div class="modal fade" id="modal-detail-{{ $riwayat->id }}">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail Pemeriksaan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <dl class="row">
            <dt class="col-sm-4">ID Periksa</dt>
            <dd class="col-sm-8">{{ $riwayat->id }}</dd>
            
            <dt class="col-sm-4">Tanggal Periksa</dt>
            <dd class="col-sm-8">{{ \Carbon\Carbon::parse($riwayat->tgl_periksa)->format('d M Y H:i') }}</dd>
            
            <dt class="col-sm-4">Dokter</dt>
            <dd class="col-sm-8">{{ $riwayat->dokter->nama }}</dd>
            
            <dt class="col-sm-4">Catatan Dokter</dt>
            <dd class="col-sm-8">{{ $riwayat->catatan_dokter }}</dd>
            
            <dt class="col-sm-4">Obat</dt>
            <dd class="col-sm-8">
              @if(count($riwayat->obat) > 0)
                <ul class="pl-3 mb-0">
                  @foreach($riwayat->obat as $obat)
                    <li>{{ $obat->nama_obat }} ({{ $obat->kemasan }}) - Rp {{ number_format($obat->harga, 0, ',', '.') }}</li>
                  @endforeach
                </ul>
              @else
                <span class="text-muted">-</span>
              @endif
            </dd>
            
            <dt class="col-sm-4">Biaya Obat</dt>
            <dd class="col-sm-8">
              @php
                $total_obat = 0;
                foreach($riwayat->obat as $obat) {
                  $total_obat += $obat->harga;
                }
              @endphp
              Rp {{ number_format($total_obat, 0, ',', '.') }}
            </dd>
            
            <dt class="col-sm-4">Biaya Periksa</dt>
            <dd class="col-sm-8">Rp {{ number_format($riwayat->biaya_periksa - $total_obat, 0, ',', '.') }}</dd>
            
            <dt class="col-sm-4">Total Biaya</dt>
            <dd class="col-sm-8">Rp {{ number_format($riwayat->biaya_periksa, 0, ',', '.') }}</dd>
          </dl>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary" onclick="window.print()">Cetak</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  @endforeach
@endif
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('scripts')
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script>
  $(function () {
    $("#riwayatTable").DataTable({
      "responsive": true, 
      "lengthChange": false, 
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#riwayatTable_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection