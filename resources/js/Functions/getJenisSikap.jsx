import axios from "axios"

const getJenisSikap = async (tahun, semester, kelasId, kategoriSikapId) => {
    try {
        const response = await axios.post(
            route('get-jenis-sikap',
                {
                    tahun: tahun,
                    semester: semester,
                    kelasId: kelasId,
                    kategoriSikapId: kategoriSikapId
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getJenisSikap