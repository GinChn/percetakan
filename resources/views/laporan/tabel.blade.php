@if ($data_input['jenis_laporan'] == 'harian')
    @php
        $tanggal = date_create($data_input['tanggal_laporan']);
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $tanggal_hasil = date_format($tanggal, 'j') . ' ' . $bulan[intval(date_format($tanggal, 'm')) - 1] . ' ' . date_format($tanggal, 'Y');
    @endphp
    <h3>Laporan Harian ({{ $tanggal_hasil }})</h3>
    <h3>Pemasukan</h3>
    <table class="table-pemasukan">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No Nota</th>
                <th>Nama Pelanggan</th>
                <th>No HP</th>
                <th>Total Tagihan</th>
            </tr>
        </thead>

        <tbody>
            @if (isset($data_laporan['data_masuk']))
                @foreach ($data_laporan['data_masuk'] as $index => $masuk)
                    <tr>
                        <td>{{ $masuk->created_at }}</td>
                        <td>{{ $masuk->no_nota }}</td>
                        <td>{{ $masuk->nama_pelanggan }}</td>
                        <td>{{ $masuk->no_telp }}</td>
                        <td>{{ $masuk->total }}</td>
                        <td></td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Total Pemasukan</td>
                <td bgcolor="yellow">
                    @if ($data_laporan['total_masuk'])
                        {{ $data_laporan['total_masuk']->total_pemasukan_harian }}
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>

    <h3>Pengeluaran</h3>
    <table class="table-pengeluaran">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Nominal</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @if ($data_laporan['data_keluar'])
                @foreach ($data_laporan['data_keluar'] as $index => $keluar)
                    <tr>
                        <td>{{ $keluar->created_at }}</td>
                        <td>{{ $keluar->keterangan }}</td>
                        <td>{{ $keluar->harga }}</td>
                        <td>{{ $keluar->jumlah }}</td>
                        <td>{{ $keluar->total }}</td>
                        <td></td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Total Pengeluaran</td>
                <td bgcolor="yellow">
                    @if ($data_laporan['total_keluar'])
                        {{ $data_laporan['total_keluar']->total_pengeluaran_harian }}
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>

    <h3>BERSIH</h3>
    <table>
        <tr>
            <td colspan="4">Total Pemasukan Bersih</td>
            <td bgcolor="orange">
                @if ($data_laporan['total_bersih'])
                    {{ $data_laporan['total_bersih'] }}
                @endif
            </td>
        </tr>
    </table>
@elseif($data_input['jenis_laporan'] == 'bulanan')
    @php
        $tanggal_awal = date_create($data_input['tanggal_laporan_awal']);
        $tanggal_akhir = date_create($data_input['tanggal_laporan_akhir']);
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $tanggal_hasil_awal = date_format($tanggal_awal, 'j') . ' ' . $bulan[intval(date_format($tanggal_awal, 'm')) - 1] . ' ' . date_format($tanggal_awal, 'Y');
        $tanggal_hasil_akhir = date_format($tanggal_akhir, 'j') . ' ' . $bulan[intval(date_format($tanggal_akhir, 'm')) - 1] . ' ' . date_format($tanggal_akhir, 'Y');
    @endphp

    <h3>Laporan Periode {{ $tanggal_hasil_awal }} sampai {{ $tanggal_hasil_akhir }}</h3>
    <h3>Pemasukan</h3>
    <table class="table-pemasukan">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pemasukan</th>
            </tr>
        </thead>

        <tbody>
            @if (isset($data_laporan['data_masuk']))
                @foreach ($data_laporan['data_masuk'] as $index => $masuk)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $masuk->tanggal }}</td>
                        <td class="total-masuk">{{ $masuk->total_tagihan }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Total Pemasukan</td>
                <td bgcolor="yellow">
                    @if ($data_laporan['total_masuk'])
                        {{ $data_laporan['total_masuk'] }}
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>

    <h3>Pengeluaran</h3>
    <table class="table-pengeluaran">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($data_laporan['data_keluar']))
                @foreach ($data_laporan['data_keluar'] as $index => $keluar)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $keluar->tanggal }}</td>
                        <td class="total-keluar">{{ $keluar->total_pengeluaran }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Total Pengeluaran</td>
                <td bgcolor="yellow">
                    @if ($data_laporan['total_keluar'])
                        {{ $data_laporan['total_keluar'] }}
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>

    <h3>BERSIH</h3>
    <table>
        <tr>
            <td colspan="2">Total Pemasukan Bersih</td>
            <td bgcolor="orange">
                @if ($data_laporan['total_bersih'])
                    {{ $data_laporan['total_bersih'] }}
                @endif
            </td>
        </tr>
    </table>
@endif
