@if(isset($upcoming_periksa) && count($upcoming_periksa) > 0)
    @foreach($upcoming_periksa as $key => $periksa)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d M Y H:i') }}</td>
            <td>{{ $periksa->dokter->nama }}</td>
            <td><span class="badge badge-warning">Menunggu</span></td>
            <td>
                <form action="{{ route('pasien.periksa.destroy', $periksa->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran?')">
                        <i class="fas fa-trash"></i> Batalkan
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="5" class="text-center">Belum ada jadwal pemeriksaan yang akan datang.</td>
    </tr>
@endif
