<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            font-size: 13px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tfoot {
            border-top: 1px solid #464646;
        }

        h3,
        h4 {
            text-align: center;
        }

        .total-label {
            font-weight: bold;
        }

        td.text-right {
            text-align: right;
        }

        .total-column {
            width: 100px;
            /* Adjust the width as needed */
        }



        .empty-td {
            width: 50%;
        }
    </style>
</head>

<body>
    @if ($data_input['jenis_laporan'] == 'harian')
        <h3>Laporan Harian</h3>
        <h4>({{ tanggal_indonesia($data_input['tanggal_laporan'], false) }})</h4>

        <h4>Pemasukan</h4>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>No Nota</th>
                    <th>Nama Pelanggan</th>
                    <th>No HP</th>
                    <th class="total-column">Total Bayar</th> <!-- Add the class for fixed width -->
                </tr>
            </thead>
            <tbody>
                @if (isset($data_laporan['data_masuk']))
                    @foreach ($data_laporan['data_masuk'] as $index => $masuk)
                        <tr>
                            <td>{{ tanggal_indonesia($masuk->created_at, false) }}</td>
                            <td>{{ $masuk->no_nota }}</td>
                            <td>{{ $masuk->nama_pelanggan }}</td>
                            <td>{{ $masuk->no_telp }}</td>
                            <td class="text-right total-column">{{ format_uang($masuk->total) }}</td>
                            <!-- Add the class for right-aligned text and fixed width -->
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="total-label">Total Pemasukan</td>
                    <td class="text-right total-column">{{ format_uang($data_laporan['total_masuk']) }}</td>
                    <!-- Add the class for right-aligned text and fixed width -->
                </tr>
            </tfoot>
        </table>

        <h4>Pengeluaran</h4>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Nominal</th>
                    <th>Qty</th>
                    <th class="total-column">Total</th>
                </tr>
            </thead>
            <tbody>
                @if ($data_laporan['data_keluar'])
                    @foreach ($data_laporan['data_keluar'] as $index => $keluar)
                        <tr>
                            <td>{{ tanggal_indonesia($keluar->created_at, false) }}</td>
                            <td>{{ $keluar->keterangan }}</td>
                            <td>{{ format_uang($keluar->nominal) }}</td>
                            <td>{{ $keluar->jumlah }}</td>
                            <td class="text-right total-column">{{ format_uang($keluar->total) }}</td>
                            <!-- Add the class for right-aligned text and fixed width -->
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="total-label">Total Pengeluaran</td>
                    <td class="text-right total-column">{{ format_uang($data_laporan['total_keluar']) }}</td>
                    <!-- Add the class for right-aligned text and fixed width -->
                </tr>
            </tfoot>
        </table>

        <h4>BERSIH</h4>
        <table>
            <tfoot>
                <tr>
                    <td style="width: 55% " class="total-label">Total Pemasukan Bersih</td>
                    <td class="text-right total-column">{{ format_uang($data_laporan['total_bersih']) }}</td>
                </tr>
            </tfoot>
        </table>
    @elseif($data_input['jenis_laporan'] == 'bulanan')
        <h3>Laporan Periode</h3>
        <h4>{{ tanggal_indonesia($data_input['tanggal_laporan_awal'], false) }} sampai
            {{ tanggal_indonesia($data_input['tanggal_laporan_akhir'], false) }}</h4>

        <h4>Pemasukan</h4>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th class="text-right total-column">Pemasukan</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($data_laporan['data_masuk']))
                    @foreach ($data_laporan['data_masuk'] as $index => $masuk)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ tanggal_indonesia($masuk->tanggal, false) }}</td>
                            <td class="text-right total-column">{{ format_uang($masuk->total_tagihan) }}</td>
                            <!-- Add the class for right-aligned text and fixed width -->
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="total-label">Total Pemasukan</td>
                    <td class="text-right total-column">{{ format_uang($data_laporan['total_masuk']) }}</td>
                </tr>
            </tfoot>
        </table>

        <h4>Pengeluaran</h4>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th class="text-right total-column">Pengeluaran</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($data_laporan['data_keluar']))
                    @foreach ($data_laporan['data_keluar'] as $index => $keluar)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ tanggal_indonesia($keluar->tanggal, false) }}</td>
                            <td class="text-right total-column">{{ format_uang($keluar->total_pengeluaran) }}</td>
                            <!-- Add the class for right-aligned text and fixed width -->
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="total-label">Total Pengeluaran</td>
                    <td class="text-right total-column">{{ format_uang($data_laporan['total_keluar']) }}</td>
                    <!-- Add the class for right-aligned text and fixed width -->
                </tr>
            </tfoot>
        </table>

        <h4>BERSIH</h4>
        <table>
            <tfoot>
                <tr>
                    <td style="width: 50%" class="total-label">Total Pemasukan Bersih</td>
                    <td class="text-right total-column">{{ format_uang($data_laporan['total_bersih']) }}</td>
                    <!-- Add the class for right-aligned text and fixed width -->
                </tr>
            </tfoot>
        </table>
    @endif
    <h4>Total Bahan Keluar</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Bahan</th>
                <th>Jumlah Keluar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_laporan['total_bahan'] as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama_bahan }}</td>
                    <td>
                        @if ($item->satuan == 'Meter')
                            {{ $item->total_keluar }} {{ $item->satuan }}
                        @else
                            {{ $item->total_jumlah }} {{ $item->satuan }}
                        @endif
                    </td>
                </tr>
            @endforeach
    </table>
</body>

</html>
