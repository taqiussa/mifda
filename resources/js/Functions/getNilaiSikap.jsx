import axios from "axios"

const getNilaiSikap = async (tahun, semester, mataPelajaranId, kelasId, kategoriSikapId, jenisSikapId) => {
    try {
        const response = await axios.post(
            route('get-nilai-sikap',
                {
                    tahun: tahun,
                    semester: semester,
                    mataPelajaranId: mataPelajaranId,   
                    kelasId: kelasId,
                    kategoriSikapId: kategoriSikapId,
                    jenisSikapId: jenisSikapId,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getNilaiSikap