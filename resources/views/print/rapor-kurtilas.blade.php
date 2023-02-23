@extends('print')
@section('title', 'Print Rapor -')
@section('content')
    <div class="flex justify-between border-b-2 border-slate-500 pb-2">
        <div>
            <div class="grid grid-cols-2 gap-4 capitalize">
                <div>nama sekolah</div>
                <div>: SMP Miftahul Huda</div>
            </div>
            <div class="grid grid-cols-2 gap-4 capitalize">
                <div>alamat</div>
                <div>: SMP Miftahul Huda</div>
            </div>
            <div class="grid grid-cols-2 gap-4 capitalize">
                <div>nama siswa</div>
                <div>: {{ $namaSiswa }}</div>
            </div>
            <div class="grid grid-cols-2 gap-4 capitalize">
                <div>NIS / NISN</div>
                <div>: {{ $nis }} / {{ $nisn }}</div>
            </div>
        </div>
        <div>
            <div class="grid grid-cols-2 gap-4 capitalize">
                <div>kelas</div>
                <div>: {{ $namaKelas }}</div>
            </div>
            <div class="grid grid-cols-2 gap-4 capitalize">
                <div>semester</div>
                <div>: {{ $semester }}</div>
            </div>
            <div class="grid grid-cols-2 gap-4 capitalize">
                <div>tahun</div>
                <div>: {{ $tahun }}</div>
            </div>
        </div>
    </div>
    <div class="text-center font-bold text-lg uppercase pt-2">
        laporan hasil belajar
    </div>
    <div class="font-bold text-md uppercase pt-2">
        a. sikap
    </div>
    <table width="100%">
        <tbody>
            <tr>
                <td class="capitalize border border-black p-2 w-1/3">dimensi</td>
                <td class="capitalize border border-black p-2">deskripsi</td>
            </tr>
            @foreach ($listSikap as $sikap)
            <tr class=" h-[100px]">
                <td class="border border-black p-2 text-justify align-middle">{{ $sikap->nama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
