import axios from "axios"

const getAbsensiUjian = async (tanggal, tahun, jam, semester, namaRuang, namaUjian) => {
    try {
        const response = await axios.post(
            route('get-absensi-ujian',
                {
                    tanggal: tanggal,
                    tahun: tahun,
                    jam: jam,
                    semester: semester,
                    namaRuang: namaRuang,
                    namaUjian: namaUjian
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getAbsensiUjian