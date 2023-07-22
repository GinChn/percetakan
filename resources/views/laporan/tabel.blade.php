@if ($data_input['jenis_laporan'] == 'harian')
    <h3>Laporan Harian ({{ tanggal_indonesia($data_input['tanggal_laporan'], false) }})</h3>
    <h3>Pemasukan</h3>
    <table class="table-pemasukan">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No Nota</th>
                <th>Nama Pelanggan</th>
                <th>No HP</th>
                <th>Total Bayar</th>
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
                    {{ $data_laporan['total_masuk'] }}
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
                        <td>{{ $keluar->nominal }}</td>
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
                    {{ $data_laporan['total_keluar'] }}
                </td>
            </tr>
        </tfoot>
    </table>

    <h3>BERSIH</h3>
    <table>
        <tr>
            <td colspan="4">Total Pemasukan Bersih</td>
            <td bgcolor="orange">
                {{ $data_laporan['total_bersih'] }}
            </td>
        </tr>
    </table>
@elseif($data_input['jenis_laporan'] == 'bulanan')
    <h3>Laporan Periode {{ tanggal_indonesia($data_input['tanggal_laporan_awal'], false) }} sampai
        {{ tanggal_indonesia($data_input['tanggal_laporan_akhir'], false) }}</h3>
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
                    {{ $data_laporan['total_masuk'] }}
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
                    {{ $data_laporan['total_keluar'] }}
                </td>
            </tr>
        </tfoot>
    </table>

    <h3>BERSIH</h3>
    <table>
        <tr>
            <td colspan="2">Total Pemasukan Bersih</td>
            <td bgcolor="orange">
                {{ $data_laporan['total_bersih'] }}
            </td>
        </tr>
    </table>
@endif
