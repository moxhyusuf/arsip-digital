<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Arsip</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>

<body>

    <h2>
        Laporan Arsip
    </h2>

    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No Registrasi</th>
                <th>Unit Pengolah</th>
                <th>Kategori</th>
                <th>Nama Arsip</th>
                <th>Status Retensi</th>
                <th>Status Validasi</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($arsip as $item)
                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $item->created_at->format('d-m-Y') }}
                    </td>

                    <td>
                        {{ $item->no_registrasi }}
                    </td>

                    <td>
                        {{ $item->user->nama }}
                    </td>

                    <td>
                        {{ $item->kategori->nama }}
                    </td>

                    <td>
                        {{ $item->nama }}
                    </td>

                    <td>
                        {{ ucfirst($item->status_retensi) }}
                    </td>

                    <td>
                        {{ ucfirst($item->status_validasi) }}
                    </td>

                </tr>
            @endforeach

        </tbody>

    </table>

</body>

</html>
