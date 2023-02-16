<table>
    <thead>
        <tr>
            <td>tahun</td>
            <td>semester</td>
            <td>kelas_id</td>
            <td>mata_pelajaran_id</td>
            <td>kategori_sikap_id</td>
            <td>jenis_sikap_id</td>
            <td>nis</td>
            <td>nama</td>
            <td>jenis</td>
            <td>nilai</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($listSiswa as $siswa)
            @foreach ($listJenis as $jenis)
                <tr>
                    <td>{{ $tahun }}</td>
                    <td>{{ $semester }}</td>
                    <td>{{ $kelasId }}</td>
                    <td>{{ $mataPelajaranId }}</td>
                    <td>{{ $kategoriSikapId }}</td>
                    <td>{{ $jenis->id }}</td>
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->name }}</td>
                    <td>{{ $jenis->nama }}</td>
                    <td></td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
