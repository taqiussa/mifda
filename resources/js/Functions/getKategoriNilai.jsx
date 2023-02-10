import axios from "axios"

const getKategoriNilai = async (tahun, kelasId) => {
    try {
        const response = await axios.post(
            route('get-kategori-nilai',
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

export default getKategoriNilai