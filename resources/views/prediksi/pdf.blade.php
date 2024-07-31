<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Prediksi</title>
    <style>
        /* CSS styling untuk PDF */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Laporan Prediksi</h2>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Nama Obat</th>
                    <th rowspan="2">Tahun</th>
                    <th colspan="12" class="text-center">Bulan</th>
                </tr>
                <tr>
                    @for ($month = 1; $month <= 12; $month++)
                        <th>{{ $month }}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach ($prediksis as $namaObat => $prediksiObat)
                    @foreach ($years as $year)
                        <tr>
                            <td>{{ $namaObat }}</td>
                            <td>{{ $year }}</td>
                            @for ($month = 1; $month <= 12; $month++)
                                <td>
                                    @php
                                        $found = false;
                                        if (isset($prediksisPerYear[$namaObat][$year])) {
                                            foreach ($prediksisPerYear[$namaObat][$year] as $prediksi) {
                                                $prediksiMonth = \Carbon\Carbon::createFromFormat('M-Y', $prediksi->bulan_tahun)->format('m');
                                                if ($prediksiMonth == str_pad($month, 2, '0', STR_PAD_LEFT)) {
                                                    echo $prediksi->hasil_prediksi;
                                                    $found = true;
                                                    break;
                                                }
                                            }
                                        }
                                        if (!$found) {
                                            echo '-';
                                        }
                                    @endphp
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
