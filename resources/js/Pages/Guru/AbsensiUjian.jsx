import React, { useState, useEffect } from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Tahun from '@/Components/Sia/Tahun'
import PrimaryButton from '@/Components/Breeze/PrimaryButton'
import axios from 'axios'
import Tanggal from '@/Components/Sia/Tanggal'
import moment from 'moment'
import Jam from '@/Components/Sia/Jam'
import { toast } from 'react-toastify';
import { trackPromise } from 'react-promise-tracker'
import Ruang from '@/Components/Sia/Ruang'
import Semester from '@/Components/Sia/Semester'
import Ujian from '@/Components/Sia/Ujian'
import getAbsensiUjian from '@/Functions/getAbsensiUjian'

const AbsensiUjian = ({ initTahun, initSemester, listKehadiran, listRuang }) => {

    const { data, setData, post, processing, errors, reset } = useForm({
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        tahun: initTahun,
        semester: initSemester,
        namaUjian: '',
        namaRuang: '',
        jam: '',
        arrayInput: [],
    })

    const [listSiswa, setListSiswa] = useState([])
    const [count, setCount] = useState(0)
    const [show, setShow] = useState(false)

    async function getDataAbsensiUjian() {
        const response = await getAbsensiUjian(data.tanggal, data.tahun, data.jam, data.semester, data.namaRuang, data.namaUjian)
        setListSiswa(response.listSiswa)
    }

    const handleDynamic = (e, index, id, nis, name, guruName, namaKelas, kelasId) => {

        const newList = [...listSiswa]
        newList.splice(index, 1, {
            id: id ?? '',
            nis: nis,
            kelas_id: kelasId,
            user: {
                name: name
            },
            kelas: {
                nama: namaKelas
            },
            absensi: {
                guru: {
                    name: guruName
                },
                kehadiran_id: e.target.value
            }
        })

        setListSiswa(newList)
        setCount(count + 1)
    }

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    const handleNihil = (e) => {
        e.preventDefault()
        trackPromise(
            axios.post(
                route('absensi-ujian.nihil',
                    {
                        tanggal: data.tanggal,
                        tahun: data.tahun,
                        jam: data.jam,
                        semester: data.semester,
                        namaRuang: data.namaRuang,
                        namaUjian: data.namaUjian,
                    })
            )
                .then(e => {
                    setListSiswa(e.data.listSiswa)
                    toast.success('Berhasil Set Kehadiran')
                })
                .catch(error => {
                    console.log(error)
                })
        )
    }

    const submit = (e) => {
        e.preventDefault()
        post(route('absensi-ujian.simpan'), {
            onSuccess: (page) => {
                toast.success('Berhasil Simpan Absensi Peserta Ujian')
                setData({
                    tanggal: data.tanggal,
                    tahun: data.tahun,
                    jam: data.jam,
                    semester: data.semester,
                    namaRuang: data.namaRuang,
                    namaUjian: data.namaUjian,
                    arrayInput: [],
                })
            },
            onError: (error) => {
                toast.error('Gagal ' + error[0])
            }
        })
    }


    useEffect(() => {

        if (data.tanggal
            && data.tahun
            && data.jam
            && data.semester
            && data.namaRuang
            && data.namaUjian
        ) {
            setShow(false)

            trackPromise(
                getDataAbsensiUjian()
            )

            setShow(true)

        }
        return () => {
            setShow(false)
        }
    }, [data.tanggal, data.tahun, data.jam, data.semester, data.namaRuang, data.namaUjian])

    useEffect(() => {

        setData({
            ...data,
            arrayInput: [...listSiswa],
        })

    }, [count])
    return (
        <>
            <Head title='Absensi Ujian' />
            <form onSubmit={submit} className='space-y-3'>
                <div className="lg:grid lg:grid-cols-6 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2">
                    <Tanggal
                        id="tanggal"
                        name="tanggal"
                        label="tanggal"
                        value={data.tanggal}
                        message={errors.tanggal}
                        isFocused={true}
                        handleChange={onHandleChange}
                    />

                    <Tahun
                        id="tahun"
                        name="tahun"
                        value={data.tahun}
                        message={errors.tahun}
                        isFocused={true}
                        handleChange={onHandleChange}
                    />

                    <Ujian
                        id="namaUjian"
                        name="namaUjian"
                        value={data.namaUjian}
                        message={errors.namaUjian}
                        isFocused={true}
                        handleChange={onHandleChange}
                    />

                    <Semester
                        id="semester"
                        name="semester"
                        value={data.semester}
                        message={errors.semester}
                        isFocused={true}
                        handleChange={onHandleChange}
                    />

                    <Ruang
                        id="namaRuang"
                        name="namaRuang"
                        value={data.namaRuang}
                        message={errors.namaRuang}
                        isFocused={true}
                        handleChange={onHandleChange}
                    />

                    <Jam
                        id="jam"
                        name="jam"
                        value={data.jam}
                        message={errors.jam}
                        isFocused={true}
                        handleChange={onHandleChange}
                    />


                </div>
                {show && (

                    <div className="flex justify-end">
                        <PrimaryButton type='button' onClick={handleNihil}>
                            set hadir
                        </PrimaryButton>
                    </div>
                )}
                <div className="overflow-x-auto">
                    <table className="w-full text-sm text-slate-600">
                        <thead className="text-sm text-slate-600 bg-gray-50">
                            <tr>
                                <th scope='col' className="py-3 px-2">
                                    No
                                </th>
                                <th scope='col' className="py-3 px-2 text-left">
                                    Nama
                                </th>
                                <th scope='col' className="py-3 px-2 text-left">
                                    Kelas
                                </th>
                                <th scope='col' className="py-3 px-2 text-left">
                                    Kehadiran
                                </th>
                                <th scope='col' className="py-3 px-2 text-left">
                                    Guru
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {listSiswa && listSiswa.map((siswa, index) => (
                                <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                    <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                        {index + 1}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {siswa.user.name}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {siswa.kelas.nama}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        <select
                                            className="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm w-auto"
                                            onChange={(e) => handleDynamic(e, index, siswa.id, siswa.nis, siswa.user.name, siswa.absensi.guru?.name, siswa.kelas.nama, siswa.kelas_id)}
                                            name={siswa.nis}
                                            value={siswa.absensi.kehadiran_id ?? ""}
                                        >
                                            <option value="">Pilih Kehadiran</option>
                                            {listKehadiran.map((kehadiran, index) => (
                                                <option
                                                    key={index}
                                                    value={kehadiran.id}
                                                >
                                                    {kehadiran.nama}
                                                </option>
                                            ))}
                                        </select>
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {siswa.absensi.guru?.name}
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
                <div className='flex justify-end'>
                    <PrimaryButton type='submit' processing={processing}>
                        Simpan
                    </PrimaryButton>
                </div>
            </form>
        </>
    )
}
AbsensiUjian.layout = page => <AppLayout children={page} />
export default AbsensiUjian