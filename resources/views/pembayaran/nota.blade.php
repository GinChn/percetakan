<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota</title>

    <?php
    $style = '
                                            <style>
                                                * {
                                                    font-family: "consolas", sans-serif;
                                                }
                                                p {
                                                    display: block;
                                                    margin: 3px;
                                                    font-size: 8pt;
                                                }
                                                table td {
                                                    font-size: 8pt;
                                                }
                                                .text-center {
                                                    text-align: center;
                                                }
                                                .text-right {
                                                    text-align: right;
                                                }
                                        
                                                @media print {
                                                    @page {
                                                margin: 0;
                                                size: 58mm;
                                                    
                                            }
                                            ';
    ?>
    <?php
    $style .= !empty($_COOKIE['innerHeight']) ? $_COOKIE['innerHeight'] . 'mm; }' : '}';
    ?>
    <?php
    $style .= '
                                                    html, body {
                                                        width: 58mm;
                                                    }
                                                    .btn-print {
                                                        display: none;
                                                    }
                                                }
                                            </style>
                                            ';
    ?>

    {!! $style !!}
</head>

<body onload="window.print()">
    <button class="btn-print" style="position: absolute; right: 1rem; top: rem;" onclick="window.print()">Print</button>
    <div class="text-center">
        <h3 style="margin-bottom: 5px;">AAL Digital Printing</h3>
        <p>Jl.A.Yani KM. 3,5</p>
        <p>Komplek Beringin</p>
        <p>Telp/wa : 0895 4111 95023</p>
    </div>
    <div class="clear-both" style="clear: both;"></div>
    <p class="text-center">================================</p>
    @foreach ($data as $item)
        <p>No Nota &emsp; &emsp; : {{ $item->no_nota }}</p>
        <p>Tanggal &emsp; &emsp; : {{ date('d-m-Y', strtotime($item->created_at)) }}</p>
        <p>Pelanggan &emsp; : {{ $item->nama_pelanggan }}</p>
        <p>Kasir &emsp; &emsp; &emsp; : {{ $item->kasir }}</p>
    @endforeach
    <p class="text-center">-------------------------------</p>
    <table width="100%" style="border: 0;">
        @foreach ($detail as $item)
            @if ($item->satuan == 'Meter')
                <tr>
                    <td colspan="3">{{ $item->nama_pesanan }} {{ $item->panjang }} x {{ $item->lebar }}</td>
                </tr>
            @else
                <tr>
                    <td colspan="3">{{ $item->nama_pesanan }}</td>
                </tr>
            @endif
            <tr>
                <td>{{ $item->jumlah }} x {{ format_uang($item->totalharga) }}</td>
                <td class="text-right">{{ format_uang($item->subtotal) }}</td>
            </tr>
        @endforeach
    </table>
    <p class="text-center">-------------------------------</p>
    @foreach ($data as $item)
        <table width="100%" style="border: 0;">
            <tr>
                <td>Total:</td>
                <td class="text-right">{{ format_uang($item->total) }}</td>
            </tr>
            <tr>
                <td>Diterima:</td>
                <td class="text-right">{{ format_uang($item->bayar) }}</td>
            </tr>
            <tr>
                <td>Kembali:</td>
                <td class="text-right">{{ format_uang($item->kembali) }}</td>
            </tr>
        </table>
    @endforeach

    <p class="text-center">================================</p>
    <p class="text-center">Nota Harap Dibawa Saat Pengambilan Pesanan</p>
    <p class="text-center">-- TERIMA KASIH --</p>

    <script>
        let body = document.body;
        let html = document.documentElement;
        let height = Math.max(
            body.scrollHeight, body.offsetHeight,
            html.clientHeight, html.scrollHeight, html.offsetHeight
        );

        document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "innerHeight=" + ((height + 50) * 0.264583);
    </script>
</body>

</html>
