<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rapor - Kurtilas</title>
    <style type="text/css">
        body {
            font-family: 'Times New Roman', Times, serif !important;
            font-size: 12pt;
            margin-top: 1cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 2cm;
        }

        @page {
            margin: 0cm 0cm;
        }

        footer {
            position: fixed;
            bottom: 1cm;
            left: 1cm;
            right: 0cm;
            font-size: 11pt !important;
        }

        .table {
            border-collapse: collapse;
            border: solid 1px #000;
            width: 100%
        }

        .table tr td,
        .table tr th {
            border: solid 1px #000;
            padding: 3px;
        }

        .table tr th {
            font-weight: bold;
            text-align: center
        }

        .rgt {
            text-align: right;
        }

        .ctr {
            text-align: center;
        }

        .tbl {
            font-weight: bold
        }

        table tr td {
            vertical-align: top
        }

        .font_kecil {
            font-size: 12px
        }

        div.footer {
            position: fixed;
            bottom: 0px;
        }

        @media screen {
            div.footer {
                display: none;
            }
        }

        @media print {
            div.footer {
                position: fixed;
                bottom: 0px;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

            /* div.header-space {
                height: 100px;
            } */
        }

        table {
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }
    </style>
</head>

<body>
    <footer>
        {{ $namaSiswa }} | {{ $nis }} | Kelas : {{ $namaKelas }} | {{ $tahun }}
    </footer>
    <div style="text-align: center">
        <h4>PENCAPAIAN KOMPETENSI SISWA</h4>
    </div>
    <table style="text-align:justify; border-collapse:collapse;" width="100%">
        <tbody>
            <tr>
                <td width="15%">Nama Sekolah</td>
                <td width="1%">:</td>
                <td width="45%" style="white-space: nowrap">SMP MIFTAHUL HUDA</td>
                <td width="8%">&nbsp;</td>
                <td width="15%">Kelas</td>
                <td width="1%">:</td>
                <td width="15%">{{ $namaKelas }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td style="white-space: nowrap">Desa Peron Kec. Limbangan Kab. Kendal</td>
                <td>&nbsp;</td>

                <td>Semester</td>
                <td>:</td>
                <td>{{ $semester }}
                    /
                    @switch($semester)
                        @case(1)
                            Ganjil
                        @break

                        @default
                            Genap
                    @endswitch
                </td>
            </tr>
            <tr>
                <td>Nama Siswa</td>
                <td>:</td>
                <td style="white-space: nowrap">{{ $namaSiswa }}</td>
                <td>&nbsp;</td>

                <td>Tahun Pelajaran</td>
                <td>:</td>
                <td style="white-space: nowrap">{{ $tahun }}</td>
            </tr>
            <tr>
                <td>NIS / NISN</td>
                <td>:</td>
                <td>{{ $nis }} / {{ $nisn }}</td>
                <td colspan="4"></td>
            </tr>
        </tbody>
    </table>
    <hr>
    <br>
    <b>Sikap</b>
    <div style="padding:5px;"></div>
    <table style="border-collapse: collapse" width="100%">
        <tbody>
            <tr>
                <td>1. Sikap Spiritual</td>
            </tr>
            <tr style="border: solid 1px #000;">
                <td width="35.7%" style="padding: 10px">Deskripsi</td>
                <td width="64.3%" style="padding: 10px">: Lorem ipsum dolor, sit amet consectetur adipisicing elit. Perspiciatis harum ratione amet nostrum sequi! Asperiores cupiditate quas eos! Aspernatur voluptates amet ea iste soluta ratione, nostrum placeat libero molestiae culpa accusantium, saepe harum nisi? Quae iste quibusdam, dolorum quam libero distinctio eos obcaecati exercitationem, sequi porro reprehenderit harum dicta labore!</td>
            </tr>
        </tbody>
    </table>
    <div style="page-break-before: always"></div>
    <b>B. PENGETAHUAN DAN KETERAMPILAN</b>
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Mata Pelajaran</th>
                <th width="8%">Nilai</th>
                <th width="46%">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="4" style="text-align: left">Kelompok A</td>
            </tr>
            @foreach ($kelompok_a as $mapel)
                <tr style="page-break-inside: avoid;height: 140px;">
                    <td style="text-align: center ; vertical-align:middle;">{{ $loop->iteration }}</td>
                    <td style="text-align: left ; vertical-align:middle;padding-left:10px;">{{ $mapel->mapel->nama }}
                    </td>
                    <td style="text-align: center ; vertical-align:middle;">
                        {{ floor($mapel->mapel->penilaian->avg('nilai')) }}
                    </td>
                    <td style="text-align: justify ;padding:10px;vertical-align:middle;">
                        @foreach ($mapel->mapel->penilaian as $nilai)
                            @php
                                if ($nilai->nilai < 60) {
                                    $predikat_a = 'Perlu penguatan';
                                } elseif ($nilai->nilai < 70) {
                                    $predikat_a = 'Menunjukkan penguasaan yang cukup';
                                } elseif ($nilai->nilai < 80) {
                                    $predikat_a = 'Menunjukkan penguasaan yang baik';
                                } else {
                                    $predikat_a = 'Menunjukkan penguasaan yang sangat baik';
                                }
                            @endphp
                            @foreach ($mapel->mapel->kd as $kd)
                                @if ($kd->jenis_penilaian_id === $nilai->jenis_penilaian_id)
                                    {{ $predikat_a . ' dalam ' . $kd->deskripsi . '.' }}
                                @endif
                            @endforeach
                        @endforeach
                    </td>
                </tr>
            @endforeach
            <tr style="page-break-before: always">
                <td colspan="4" style="text-align: left">Kelompok B</td>
            </tr>
            @foreach ($kelompok_b as $mapel)
                <tr style="page-break-inside: avoid;height: 140px;">
                    <td style="text-align: center; vertical-align:middle;">{{ $loop->iteration + 7 }}</td>
                    <td style="text-align: left; vertical-align:middle;padding-left:10px;">{{ $mapel->mapel->nama }}
                    </td>
                    <td style="text-align: center; vertical-align:middle;">
                        {{ floor($mapel->mapel->penilaian->avg('nilai')) }}
                    </td>
                    <td style="text-align: justify; padding:10px; vertical-align:middle;">
                        @foreach ($mapel->mapel->penilaian as $nilai)
                            @php
                                if ($nilai->nilai < 60) {
                                    $predikat_a = 'Perlu penguatan';
                                } elseif ($nilai->nilai < 70) {
                                    $predikat_a = 'Menunjukkan penguasaan yang cukup';
                                } elseif ($nilai->nilai < 80) {
                                    $predikat_a = 'Menunjukkan penguasaan yang baik';
                                } else {
                                    $predikat_a = 'Menunjukkan penguasaan yang sangat baik';
                                }
                            @endphp
                            @foreach ($mapel->mapel->kd as $kd)
                                @if ($kd->jenis_penilaian_id === $nilai->jenis_penilaian_id)
                                    {{ $predikat_a . ' dalam ' . $kd->deskripsi . '.' }}
                                @endif
                            @endforeach
                        @endforeach
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" style="text-align: left">Kelompok C</td>
            </tr>
            @foreach ($kelompok_c as $mapel)
                <tr style="page-break-inside: avoid;height: 140px;">
                    <td style="text-align: center ; vertical-align:middle;">{{ $loop->iteration + 10 }}</td>
                    <td style="text-align: left ; vertical-align:middle;padding-left:10px;">{{ $mapel->mapel->nama }}
                    </td>
                    <td style="text-align: center ; vertical-align:middle;">
                        {{ floor($mapel->mapel->penilaian->avg('nilai')) }}
                    </td>
                    <td style="text-align: justify; padding:10px; vertical-align:middle;">
                        @foreach ($mapel->mapel->penilaian as $nilai)
                            @php
                                if ($nilai->nilai < 60) {
                                    $predikat_a = 'Perlu penguatan';
                                } elseif ($nilai->nilai < 70) {
                                    $predikat_a = 'Menunjukkan penguasaan yang cukup';
                                } elseif ($nilai->nilai < 80) {
                                    $predikat_a = 'Menunjukkan penguasaan yang baik';
                                } else {
                                    $predikat_a = 'Menunjukkan penguasaan yang sangat baik';
                                }
                            @endphp
                            @foreach ($mapel->mapel->kd as $kd)
                                @if ($kd->jenis_penilaian_id === $nilai->jenis_penilaian_id)
                                    {{ $predikat_a . ' dalam ' . $kd->deskripsi . '.' }}
                                @endif
                            @endforeach
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="page-break-before: always"></div>
    <b>C. EKSTRAKURIKULER</b>
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Nama Kegiatan</th>
                <th width="10%">Nilai</th>
                <th width="55%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penilaianEkstrakurikuler as $nilai)
                <tr>
                    <td class="ctr" style=" vertical-align:middle;">1.</td>
                    <td style=" vertical-align:middle;padding-left:10px;">{{ $nilai->nilai }}</td>
                    <td class="ctr" style="vertical-align: middle;">{{ $nilai->nilai }}</td>
                    <td style="padding: 10px;">
                        @if ($nilai->nilai > 90)
                            Menunjukkan penguasaan yang sangat baik dalam
                            {{ $nilai->ekstrakurikuler->deskripsiEkstrakurikuler->deskripsi }}
                        @elseif ($nilai->nilai > 80)
                            Menunjukkan penguasaan yang baik dalam
                            {{ $nilai->ekstrakurikuler->deskripsiEkstrakurikuler->deskripsi }}
                        @elseif ($nilai->nilai > 70)
                            Menunjukkan penguasaan yang cukup dalam
                            {{ $nilai->ekstrakurikuler->deskripsiEkstrakurikuler->deskripsi }}
                        @else
                            Perlu bimbingan dalam {{ $nilai->ekstrakurikuler->deskripsiEkstrakurikuler->deskripsi }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="ctr" style=" vertical-align:middle;">-</td>
                    <td style=" vertical-align:middle;padding-left:10px;">-</td>
                    <td class="ctr" style="vertical-align: middle;">-</td>
                    <td style="padding: 10px;">
                        -
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
    <div style="padding:5px;"></div>
    <b>D. KETIDAKHADIRAN</b>
    <table class="table">
        <tbody>
            <tr>
                <td width="60%" style="padding-left:10px;">Sakit</td>
                <td width="40%" class="ctr"> {{ $sakit }} hari</td>
            </tr>
            <tr>
                <td style="padding-left:10px;">Izin</td>
                <td class="ctr"> {{ $izin }} hari</td>
            </tr>
            <tr>
                <td style="padding-left:10px;">Tanpa Keterangan</td>
                <td class="ctr"> {{ $alpha }} hari</td>
            </tr>
            </tr>
        </tbody>
    </table>
    <div style="padding:5px;"></div>
    <b>E. PRESTASI</b>
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Jenis Prestasi</th>
                <th width="55%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($listPrestasi as $prestasi)
                <tr>
                    <td width="5%" style="text-align: center; vertical-align:middle;">{{ $loop->iteration }}</td>
                    <td width="40%" style="vertical-align: middle;padding:10px;">{{ $prestasi->prestasi }}</th>
                    <td width="55%" style="vertical-align: middle;padding:10px;">{{ $prestasi->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td width="5%" style="text-align: center">-</td>
                    <td width="40%">-</th>
                    <td width="55%">-</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:5px;"></div>
    <b>F. CATATAN WALIKELAS</b>
    <table class="table">
        <tr>
            <td style="border:#000 1px solid;padding:5px;">
                {{ $catatan->catatan ?? '-' }}
            </td>
        </tr>
    </table>
    <div style="padding:5px;"></div>
    @if ($tingkat == 9 && $semester == 2)
        <p>
            <b>Keputusan</b> berdasarkan pencapaian kompetensi pada semester ke-1 sampai dengan ke-5, peserta didik
            ditetapkan *)
        </p>
        <p>
            @if ($naik)
                Lulus<br>
                <s>
                    Tidak Lulus
                </s>
            @else
                <s>
                    Lulus
                </s>
                <br>
                Tidak Lulus
            @endif
            <br>
            *) Coret yang tidak perlu
        </p>
    @elseif ($semester == 2)
        <p>
            <b>Keputusan</b> berdasarkan pencapaian kompetensi pada semester ke-1 dan ke-2, peserta didik ditetapkan *)
        </p>
        <p>
            @if ($naik)
                Naik Kelas<br>
                <s>
                    Tinggal Kelas
                </s>
            @else
                <s>
                    Naik Kelas
                </s>
                <br>
                Tinggal Kelas
            @endif
            <br>
            *) Coret yang tidak perlu
        </p>
    @else
    @endif
    <div style="padding:15px;"></div>
    <table style="text-align:center;table-layout:fixed;" width="100%">
        <tr>
            <td style="text-align:center">Mengetahui</td>
            <td style="text-align:center">
                Ngampel,
                @isset($tanggalRapor->tanggal)
                    {{ tanggal($tanggalRapor->tanggal) }}
                @endisset
            </td>
        </tr>
        <tr>
            <td style="text-align:center">Orang Tua/Wali</td>
            <td style="text-align:center">Wali Kelas</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align:center"><u><b>..........................</b></u></td>
            <td style="text-align:center"><u><b>{{ $namaWaliKelas }}</b></u></td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align:center" colspan="2">Mengetahui,</td>
        </tr>
        <tr>
            <td style="text-align:center" colspan="2">Kepala Sekolah</td>
        </tr>
        <tr>
            <td style="text-align:center" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align:center" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align:center" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align:center" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align:center" colspan="2">
                <u>
                    <b>
                        Agus Arif Fahmie,S.Pd
                        <br>
                    </b>
                </u>
            </td>
        </tr>
    </table>
</body>

</html>
