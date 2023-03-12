import axios from "axios"

const getKategoriNilaiPerTingkat = async (tahun, tingkat) => {
    try {
        const response = await axios.post(
            route('get-kategori-nilai-per-tingkat',
                {
                    tahun: tahun,
                    tingkat: tingkat
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getKategoriNilaiPerTingkat