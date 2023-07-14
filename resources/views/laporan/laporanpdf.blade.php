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
        @php
            $tanggal = date_create($data_input['tanggal_laporan']);
            $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $tanggal_hasil = date_format($tanggal, 'j') . ' ' . $bulan[intval(date_format($tanggal, 'm')) - 1] . ' ' . date_format($tanggal, 'Y');
        @endphp
        <h3 style="text-align: center">Laporan Harian </h3>
        <h3 style="text-align: center">({{ $tanggal_hasil }})</h3>
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
                        @if ($data_laporan['total_masuk'])
                            {{ $data_laporan['total_masuk']->total_pemasukan_harian }}
                        @endif
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
                    <td>
                        @if ($data_laporan['total_keluar'])
                            {{ $data_laporan['total_keluar']->total_pengeluaran_harian }}
                        @endif
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
                        @if ($data_laporan['total_bersih'])
                            {{ $data_laporan['total_bersih'] }}
                        @endif
                    </td>
                </tr>
            </tfoot>
        </table>
    @elseif($data_input['jenis_laporan'] == 'bulanan')
        @php
            $tanggal_awal = date_create($data_input['tanggal_laporan_awal']);
            $tanggal_akhir = date_create($data_input['tanggal_laporan_akhir']);
            $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $tanggal_hasil_awal = date_format($tanggal_awal, 'j') . ' ' . $bulan[intval(date_format($tanggal_awal, 'm')) - 1] . ' ' . date_format($tanggal_awal, 'Y');
            $tanggal_hasil_akhir = date_format($tanggal_akhir, 'j') . ' ' . $bulan[intval(date_format($tanggal_akhir, 'm')) - 1] . ' ' . date_format($tanggal_akhir, 'Y');
        @endphp

        <h3 style="text-align: center">Laporan Periode</h3>
        <h3 style="text-align: center">{{ $tanggal_hasil_awal }} sampai {{ $tanggal_hasil_akhir }}</h3>
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
                        @if ($data_laporan['total_masuk'])
                            {{ $data_laporan['total_masuk'] }}
                        @endif
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
                        @if ($data_laporan['total_keluar'])
                            {{ $data_laporan['total_keluar'] }}
                        @endif
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
                        @if ($data_laporan['total_bersih'])
                            {{ $data_laporan['total_bersih'] }}
                        @endif
                    </td>
                </tr>
            </tfoot>
        </table>
    @endif
</body>

</html>
