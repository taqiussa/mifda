import axios from "axios"

const getJenisPenilaian = async (tahun, semester, kelasId, kategoriNilaiId) => {
    try {
        const response = await axios.post(
            route('get-jenis-penilaian',
                {
                    tahun: tahun,
                    semester: semester,
                    kelasId: kelasId,
                    kategoriNilaiId: kategoriNilaiId
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getJenisPenilaian