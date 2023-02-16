import axios from "axios"

const getKelasWali = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-kelas-wali',
                {
                    tahun: tahun,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getKelasWali