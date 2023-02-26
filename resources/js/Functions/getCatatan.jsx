import axios from "axios"

const getCatatan = async (tahun, semester, kelasId) => {
    try {
        const response = await axios.post(
            route('get-catatan',
                {
                    tahun: tahun,
                    semester: semester,
                    kelasId: kelasId,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getCatatan