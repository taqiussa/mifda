import axios from "axios"

const getAnalisisAlquran = async (tahun, semester, kelasId, kategoriNilaiId, jenisPenilaianId, jenisAnalisis) => {
    try {
        const response = await axios.post(
            route('get-analisis-alquran',
                {
                    tahun: tahun,
                    semester: semester,
                    kelasId: kelasId,
                    kategoriNilaiId: kategoriNilaiId,
                    jenisPenilaianId: jenisPenilaianId,
                    jenisAnalisis: jenisAnalisis,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getAnalisisAlquran