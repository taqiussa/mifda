import axios from "axios"

const getAbsensiEkstrakurikuler = async (tanggal, tahun, semester, ekstrakurikulerId, jenisKelamin) => {
    try {
        const response = await axios.post(
            route('get-absensi-ekstrakurikuler',
                {
                    tanggal: tanggal,
                    tahun: tahun,
                    semester: semester,
                    ekstrakurikulerId: ekstrakurikulerId,
                    jenisKelamin: jenisKelamin
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getAbsensiEkstrakurikuler