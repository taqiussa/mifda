import axios from "axios"

const getGuruKelas = async (tahun, semester) => {
    try {
        const response = await axios.post(
            route('get-guru-kelas',
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

export default getGuruKelas