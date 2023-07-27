@extends('layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pembayaran</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="table2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>No Nota</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Tanggal</th>
                                    <th>Total Pembayaran</th>
                                    <th>Bayar</th>
                                    <th>Kembali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembayaran as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->no_nota }}</td>
                                        <td>{{ $item->nama_pelanggan }}</td>
                                        <td>{{ tanggal_indonesia($item->created_at) }}</td>
                                        <td>{{ format_uang($item->total) }}</td>
                                        <td>{{ format_uang($item->bayar) }}</td>
                                        <td>{{ format_uang($item->kembali) }}</td>
                                        <td>
                                            @if ($item->status_pembayaran == 'Lunas')
                                                <span class="badge badge-success">
                                                    {{ $item->status_pembayaran }}
                                                </span>
                                            @else
                                                <span class="badge badge-danger">
                                                    {{ $item->status_pembayaran }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status_pembayaran == 'Lunas')
                                                <div class="btn-group">
                                                    <a href="/pembayaran/{{ $item->id_pesanan }}"
                                                        class="btn btn-default btn-sm"><i class="fas fa-list"></i>
                                                        Detail</a>
                                                    <button type="button"
                                                        class="btn btn-default btn-sm dropdown-toggle dropdown-icon"
                                                        data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu" role="menu">
                                                        <button class="dropdown-item"
                                                            onclick="nota('{{ route('pembayaran.nota', $item->id_pesanan) }}', 'Nota')"><i
                                                                class="fas fa-barcode"></i> Struk</button>
                                                        {{-- <a class="dropdown-item"
                                                            href="/pembayaran/{{ $item->id_pesanan }}/edit"><i
                                                                class="fas fa-edit"></i> Edit</a> --}}
                                                    </div>
                                                @else
                                                    <a href="{{ route('bayar.pesanan', $item->id_pesanan) }}"
                                                        class="btn btn-sm btn-default">
                                                        Pembayaran
                                                    </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // tambahkan untuk delete cookie innerHeight terlebih dahulu
        document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

        function nota(url, title) {
            popupCenter(url, title, 625, 500);
        }

        function popupCenter(url, title, w, h) {
            const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
            const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;

            const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document
                .documentElement.clientWidth : screen.width;
            const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document
                .documentElement.clientHeight : screen.height;

            const systemZoom = width / window.screen.availWidth;
            const left = (width - w) / 2 / systemZoom + dualScreenLeft
            const top = (height - h) / 2 / systemZoom + dualScreenTop
            const newWindow = window.open(url, title,
                `
            scrollbars=yes,
            width  = ${w / systemZoom}, 
            height = ${h / systemZoom}, 
            top    = ${top}, 
            left   = ${left}
        `
            );

            if (window.focus) newWindow.focus();
        }
    </script>
@endsection
