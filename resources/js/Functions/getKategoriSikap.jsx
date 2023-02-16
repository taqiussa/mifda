import axios from "axios"

const getKategoriSikap = async (tahun, kelasId) => {
    try {
        const response = await axios.post(
            route('get-kategori-sikap',
                {
                    tahun: tahun,
                    kelasId: kelasId
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getKategoriSikap