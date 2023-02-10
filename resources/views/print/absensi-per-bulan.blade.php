@extends('print')
@section('title', 'Print Per Bulan -')
@section('content')
    @include('header')
    @if (!empty($kelasId))

        <div class="capitalize font-bold text-xl text-center">
            laporan kehadiran siswa
        </div>
        <div class="flex justify-between">
            <div class="flex space-x-5">
                <div class="flex flex-col capitalize">
                    <div>
                        kelas
                    </div>
                    <div>
                        tahun
                    </div>
                </div>
                <div class="flex flex-col capitalize">
                    <div>: {{ $namaKelas }}</div>
                    <div>: {{ $tahun }}</div>
                </div>
            </div>
            <div class="flex space-x-5">
                <div class="flex flex-col capitalize">
                    <div>
                        bulan
                    </div>
                    <div>
                        wali kelas
                    </div>
                </div>
                <div class="flex flex-col capitalize">
                    <div>: {{ $namaBulan }}</div>
                    <div>: {{ $namaWaliKelas }}</div>
                </div>
            </div>
        </div>
        <table class="w-full border-2 border-collapse border-spacing-1 border-black text-sm">
            <thead>
                <tr>
                    <th class="border border-black " rowspan="2">No</th>
                    <th class="border border-black " rowspan="2">NIS</th>
                    <th class="border border-black " rowspan="2">Nama</th>
                    <th class="border border-black " colspan="7">Kehadiran</th>
                </tr>
                <tr>
                    <th class="border border-black ">H</th>
                    <th class="border border-black ">I</th>
                    <th class="border border-black ">S</th>
                    <th class="border border-black ">A</th>
                    <th class="border border-black ">B</th>
                    <th class="border border-black ">P</th>
                    <th class="border border-black">Presentase</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listSiswa as $key => $siswa)
                    <tr>
                        <td class="border border-black text-center">{{ $loop->iteration }}</td>
                        <td class="border border-black text-center">{{ $siswa->nis }}</td>
                        <td class="border border-black pl-3 whitespace-nowrap">{{ $siswa->user->name }}</td>
                        <td class="px-2 border border-black text-center">{{ $siswa->hadir }}</td>
                        <td class="px-2 border border-black text-center">{{ $siswa->izin }}</td>
                        <td class="px-2 border border-black text-center">{{ $siswa->sakit }}</td>
                        <td class="px-2 border border-black text-center">{{ $siswa->alpha }}</td>
                        <td class="px-2 border border-black text-center">{{ $siswa->bolos }}</td>
                        <td class="px-2 border border-black text-center">{{ $siswa->pulang }}</td>
                        @php
                            $total = round(($siswa->hadir / $maxHadir) * 100, 2);
                        @endphp
                        @if ($total < 80)
                            <td class="px-2 border border-black text-center bg-red-600 text-slate-200">
                                {{ $total . ' %' }}
                            </td>
                        @else
                            <td class="px-2 border border-black text-center">
                                {{ $total . ' %' }}
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex justify-end mt-5">
            <div class="flex flex-col justify-center items-center">
                <div>
                    Kendal, {{ tanggal(date('Y-m-d')) }}
                </div>
                <div class="mb-16">
                    Guru Bimbingan dan Konseling
                </div>
                <div class="font-bold">
                    {{ $namaGuruBk }}
                </div>
            </div>
        </div>
    @else
        <div class="capitalize font-bold text-xl text-center">
            Anda Belum memilih kelas
        </div>

    @endif
@endsection
