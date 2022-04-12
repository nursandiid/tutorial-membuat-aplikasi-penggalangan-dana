<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Penggalangan Dana</title>

    <link rel="stylesheet" href="{{ public_path('/AdminLTE/dist/css/adminlte.min.css') }}">
</head>
<body>

    <h4 class="text-center">Laporan Penggalangan Dana</h4>
    <p class="text-center">
        Tanggal {{ tanggal_indonesia($start) }}
        s/d
        Tanggal {{ tanggal_indonesia($end) }}
    </p>

    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Tanggal</th>
                <th>Pemasukan</th>
                <th>Pengelaran</th>
                <th>Sisa Kas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr>
                @foreach ($row as $key => $col)
                    <td {!! $key > 1 ? 'class="text-right"' : '' !!}>{!! $col !!}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>