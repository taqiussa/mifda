import axios from "axios"

const getNilaiAlquran = async (nis) => {
    try {
        const response = await axios.post(
            route('get-nilai-alquran-siswa',
                {
                    nis: nis,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getNilaiAlquran