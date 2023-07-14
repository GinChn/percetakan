@if ($data_input['jenis_laporan'] == 'harian')
    <h3>Pemasukan {{ $data_input['tanggal_laporan'] }}</h3>
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

    <h3>Pengeluaran {{ isset($data_input['tanggal_laporan']) }}</h3>
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
@endif
