import axios from "axios"

const getKkm = async (tahun, mataPelajaranId) => {
    try {
        const response = await axios.post(
            route('get-kkm',
                {
                    tahun: tahun,
                    mataPelajaranId: mataPelajaranId
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getKkm