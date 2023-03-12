import axios from "axios"

const getJenisPenilaianPerTingkat = async (tahun, semester, tingkat, kategoriNilaiId) => {
    try {
        const response = await axios.post(
            route('get-jenis-penilaian-per-tingkat',
                {
                    tahun: tahun,
                    semester: semester,
                    tingkat: tingkat,
                    kategoriNilaiId: kategoriNilaiId
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getJenisPenilaianPerTingkat