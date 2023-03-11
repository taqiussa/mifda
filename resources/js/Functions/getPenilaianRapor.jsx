import axios from "axios"

const getPenilaianRapor = async (tahun, semester) => {
    try {
        const response = await axios.post(
            route('get-penilaian-rapor',
                {
                    tahun: tahun,
                    semester: semester,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getPenilaianRapor