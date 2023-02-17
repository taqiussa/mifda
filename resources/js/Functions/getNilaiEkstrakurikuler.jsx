import axios from "axios"

const getNilaiEkstrakurikuler = async (tahun, semester, ekstrakurikulerId) => {
    try {
        const response = await axios.post(
            route('get-nilai-ekstrakurikuler',
                {
                    tahun: tahun,
                    semester: semester,
                    ekstrakurikulerId: ekstrakurikulerId,   
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getNilaiEkstrakurikuler