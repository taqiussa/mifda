import axios from "axios"

const getAturanKurikulum = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-aturan-kurikulum',
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

export default getAturanKurikulum