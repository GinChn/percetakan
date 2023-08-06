<!DOCTYPE html>
<html>

<head>
    <title>Dokumen Bukti Pengeluaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 0 40px;
            /* Menggunakan px */
            box-sizing: border-box;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            /* Menggunakan px */
        }

        h1 {
            margin-bottom: 40px;
            font-size: 25px;
            /* Menggunakan px */
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
        }

        .content {
            line-height: 1.5;
        }

        .total {
            text-align: right;
            margin-bottom: 40px;
            /* Menggunakan px */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            width: 150px;
        }

        .signature {
            width: 300px;
            /* Menggunakan px */
            margin-top: 20px;
            /* Menggunakan px */
            float: right;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            width: 200px;
            margin: 0 auto;
            margin-bottom: 10px;
            /* Menggunakan px */
        }
    </style>
</head>

<body>
    <div class="header">
        <p class="company-name">AAL Digital Printing</p>
        <p>Jl. A. Yani KM. 3,5 Komplek Beringin</p>
        <p>Telp/wa: 0895 4111 95023 | Email: info@aalprinting.com</p>
    </div>

    <h1 style="text-align: center; text-transform: uppercase;">Bukti Pengeluaran</h1>

    <div class="content">
        <table>
            <tr>
                <th>Tanggal</th>
                <td>: {{ tanggal_indonesia($data->created_at, false) }}</td>
            </tr>
            <tr>
                <th>Nominal</th>
                <td>: {{ format_uang($data->nominal) }}</td>
            </tr>
            <tr>
                <th>Keterangan</th>
                <td>: {{ $data->keterangan }}</td>
            </tr>
            <tr>
                <th>Jumlah</th>
                <td>: {{ $data->jumlah }}</td>
            </tr>

        </table>
        <p>Pengeluaran ini merupakan bukti pembayaran untuk keperluan operasional perusahaan.</p>
    </div>

    <div class="total">
        <h3>Total Pengeluaran: {{ format_uang($data->total) }}</h3>
    </div>

    <div class="signature">
        <p>Disetujui {{ tanggal_indonesia($data->updated_at, false) }} oleh:</p>
        <p>Manajer</p>
        <br>
        <br>
        <br>
        <br>
        <p>{{ $data->manajer }}</p>
    </div>
</body>

</html>
