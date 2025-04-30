@if(isset($riwayats) && count($riwayats) > 0)
    @foreach($riwayats as $key => $riwayat)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $riwayat->id }}</td>
        <td>{{ \Carbon\Carbon::parse($riwayat->tgl_periksa)->format('d M Y H:i') }}</td>
        <td>{{ $riwayat->dokter->nama }}</td>
        <td>{{ $riwayat->catatan_dokter }}</td>
        <td>
            @if(count($riwayat->obat) > 0)
                <ul class="pl-3 mb-0">
                    @foreach($riwayat->obat as $obat)
                        <li>{{ $obat->nama_obat }} ({{ $obat->kemasan }})</li>
                    @endforeach
                </ul>
            @else
                <span class="text-muted">-</span>
            @endif
        </td>
        <td>Rp {{ number_format($riwayat->biaya_periksa, 0, ',', '.') }}</td>
        <td>
            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-detail-{{ $riwayat->id }}">
                <i class="fas fa-eye"></i> Detail
            </button>
        </td>
    </tr>
    @endforeach
@else
    <tr>
        <td colspan="8" class="text-center">Belum ada riwayat pemeriksaan.</td>
    </tr>
@endif
