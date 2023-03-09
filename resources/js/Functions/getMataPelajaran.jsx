import axios from "axios"

const getMataPelajaran = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-mata-pelajaran',
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
// const getMataPelajaran = async (tahun, userId) => {
//     try {
//         const response = await axios.post(
//             route('get-mata-pelajaran',
//                 {
//                     tahun: tahun,
//                     userId: userId,
//                 })
//         )
//         return response.data;
//     }
//     catch (error) {
//         console.log(error)
//     }
// }

export default getMataPelajaran