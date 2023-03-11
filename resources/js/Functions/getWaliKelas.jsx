import axios from "axios"

const getWaliKelas = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-wali-kelas',
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

export default getWaliKelas