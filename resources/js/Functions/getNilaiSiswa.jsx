import axios from "axios"

const getNilaiSiswa = async (tahun, semester, mataPelajaranId, kelasId,kategoriNilaiId, jenisPenilaianId) => {
    try {
        const response = await axios.post(
            route('get-nilai-siswa',
                {
                    tahun: tahun,
                    semester: semester,
                    mataPelajaranId: mataPelajaranId,   
                    kelasId: kelasId,
                    kategoriNilaiId: kategoriNilaiId,
                    jenisPenilaianId: jenisPenilaianId,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getNilaiSiswa