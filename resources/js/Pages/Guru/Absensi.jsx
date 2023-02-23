import React, { useState, useEffect } from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Tahun from '@/Components/Sia/Tahun'
import PrimaryButton from '@/Components/Breeze/PrimaryButton'
import axios from 'axios'
import Kelas from '@/Components/Sia/Kelas'
import Tanggal from '@/Components/Sia/Tanggal'
import moment from 'moment'
import Jam from '@/Components/Sia/Jam'
import { toast } from 'react-toastify';
import { trackPromise } from 'react-promise-tracker'
import getAbsensiSiswa from '@/Functions/getAbsensiSiswa'
import Sweet from '@/Components/Sia/Sweet'

const Absensi = ({ initTahun, listKehadiran, listKelas }) => {

    const { data, setData, post, processing, errors, reset } = useForm({
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        tahun: initTahun,
        jam: '',
        kelasId: '',
        arrayInput: [],
    })

    const [listSiswa, setListSiswa] = useState([])
    const [count, setCount] = useState(0)
    const [show, setShow] = useState(false)
    const [message, setMessage] = useState([])

    async function getDataAbsensiSiswa() {
        const response = await getAbsensiSiswa(data.tanggal, data.tahun, data.jam, data.kelasId)
        setListSiswa(response.listSiswa)
    }

    const handleDynamic = (e, index, id, nis, name, guruName) => {

        const newList = [...listSiswa]
        newList.splice(index, 1, {
            id: id ?? '',
            nis: nis,
            user: {
                name: name
            },
            absensi: {
                kehadiran_id: e.target.value,
                guru: {
                    name: guruName
                },
            }
        })

        setListSiswa(newList)
        setCount(count + 1)

        axios.post(route('absensi.simpan',
            {
                tanggal: data.tanggal,
                tahun: data.tahun,
                jam: data.jam,
                kelasId: data.kelasId,
                nis: nis,
                kehadiranId: e.target.value
            }))
            .then(response => {
                setMessage({
                    nis: response.data.nis,
                    message: response.data.message
                })
            })
            .catch(error => {
                console.log(error)
            })
    }

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    const handleNihil = (e) => {
        e.preventDefault()

        trackPromise(
            axios.post(
                route('absensi.nihil',
                    {
                        tanggal: data.tanggal,
                        tahun: data.tahun,
                        jam: data.jam,
                        kelasId: data.kelasId,
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

    useEffect(() => {

        if (data.tanggal
            && data.tahun
            && data.jam
            && data.kelasId
        ) {
            setShow(false)

            trackPromise(
                getDataAbsensiSiswa()
            )

            setShow(true)

        }
        return () => {
            setShow(false)
        }
    }, [data.tanggal, data.tahun, data.jam, data.kelasId])

    useEffect(() => {

        setData({
            ...data,
            arrayInput: [...listSiswa],
        })


    }, [count])

    return (
        <>
            <Head title='Absensi' />
            <div className='space-y-3'>
                <div className="lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2">
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

                    <Jam
                        id="jam"
                        name="jam"
                        value={data.jam}
                        message={errors.jam}
                        isFocused={true}
                        handleChange={onHandleChange}
                    />

                    <Kelas
                        id="kelasId"
                        name="kelasId"
                        value={data.kelasId}
                        message={errors.kelasId}
                        isFocused={true}
                        listKelas={listKelas}
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
                                        <div className='flex flex-col'>

                                            <select
                                                className="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm w-auto"
                                                onChange={(e) => handleDynamic(e, index, siswa.id, siswa.nis, siswa.user.name, siswa.absensi.guru?.name)}
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

                                            {
                                                (() => {
                                                    if (message && message.nis == siswa.nis) {
                                                        return (
                                                            <span className='text-emerald-500'>{message.message}</span>
                                                        )
                                                    }
                                                })
                                                    ()}

                                        </div>
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {siswa.absensi.guru?.name}
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </>
    )
}
Absensi.layout = page => <AppLayout children={page} />
export default Absensi