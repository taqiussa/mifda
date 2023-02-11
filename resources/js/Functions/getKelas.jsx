import axios from "axios"

const getJenisPenilaian = async (tahun, mataPelajaranId) => {
    try {
        const response = await axios.post(
            route('get-kelas',
                {
                    tahun: tahun,
                    mataPelajaranId: mataPelajaranId,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getJenisPenilaian