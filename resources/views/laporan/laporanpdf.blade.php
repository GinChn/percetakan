<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table {
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            font-size: 13px;
        }

        tfoot {
            border-top: 1px solid #464646;
        }
    </style>
</head>

<body>
    @if ($data_input['jenis_laporan'] == 'harian')
        <h3 style="text-align: center">Laporan Harian </h3>
        <h4 style="text-align: center">({{ tanggal_indonesia($data_input['tanggal_laporan'], false) }})</h4>
        <h4>Pemasukan</h4>
        <table class="table">
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
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">Total Pemasukan</td>
                    <td>
                        {{ $data_laporan['total_masuk'] }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <h4>Pengeluaran</h4>
        <table class="table">
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
                    <td>
                        {{ $data_laporan['total_keluar'] }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <h4>BERSIH</h4>
        <table class="table">
            <tfoot>
                <tr>
                    <td colspan="4">Total Pemasukan Bersih</td>
                    <td colspan="2" style="text-align: center">
                        {{ $data_laporan['total_bersih'] }}
                    </td>
                </tr>
            </tfoot>
        </table>
    @elseif($data_input['jenis_laporan'] == 'bulanan')
        <h3 style="text-align: center">Laporan Periode</h3>
        <h4 style="text-align: center">{{ tanggal_indonesia($data_input['tanggal_laporan_awal'], false) }} sampai
            {{ tanggal_indonesia($data_input['tanggal_laporan_akhir'], false) }}</h4>
        <h4>Pemasukan</h4>
        <table class="table">
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
                    <td>
                        {{ $data_laporan['total_masuk'] }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <h4>Pengeluaran</h4>
        <table class="table">
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
                    <td>
                        {{ $data_laporan['total_keluar'] }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <h4>BERSIH</h4>
        <table class="table">
            <tfoot>
                <tr>
                    <td style="width: 55%">Total Pemasukan Bersih</td>
                    <td style="text-align: left">
                        {{ $data_laporan['total_bersih'] }}
                    </td>
                </tr>
            </tfoot>
        </table>
    @endif
</body>

</html>
