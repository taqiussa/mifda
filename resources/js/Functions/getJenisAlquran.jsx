import axios from "axios"

const getJenisAlquran = async (kategoriAlquranId) => {
    try {
        const response = await axios.post(
            route('get-jenis-alquran',
                {
                    kategoriAlquranId: kategoriAlquranId
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getJenisAlquran