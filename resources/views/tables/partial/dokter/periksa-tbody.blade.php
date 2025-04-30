@if(isset($periksa_pasiens) && count($periksa_pasiens) > 0)
    @foreach($periksa_pasiens as $key => $periksa)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $periksa->id }}</td>
            <td>{{ $periksa->pasien->nama }}</td>
            <td>{{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d M Y H:i') }}</td>
            <td>
                @if($periksa->catatan)
                    <span class="badge bg-success">Selesai</span>
                @else
                    <span class="badge bg-warning">Menunggu</span>
                @endif
            </td>
            <td>
                @if(!$periksa->catatan)
                <a href="{{ route('dokter.periksa.edit', $periksa->id) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-stethoscope"></i> Periksa
                </a>
                @else
                <a href="{{ route('dokter.periksa.show', $periksa->id) }}" class="btn btn-sm btn-info">
                    <i class="fas fa-eye"></i> Detail
                </a>
                @endif
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="6" class="text-center">Tidak ada pasien yang perlu diperiksa.</td>
    </tr>
@endif
