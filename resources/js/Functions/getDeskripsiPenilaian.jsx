import axios from "axios"

const getDeskripsiPenilaian = async (tahun, semester, mataPelajaranId, tingkat) => {
    try {
        const response = await axios.post(
            route('get-deskripsi-penilaian',
                {
                    tahun: tahun,
                    semester: semester,
                    mataPelajaranId: mataPelajaranId,
                    tingkat: tingkat,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getDeskripsiPenilaian