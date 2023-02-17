import React, { useState, useEffect } from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Tahun from '@/Components/Sia/Tahun'
import PrimaryButton from '@/Components/Breeze/PrimaryButton'
import Kelas from '@/Components/Sia/Kelas'
import { toast } from 'react-toastify';
import { trackPromise } from 'react-promise-tracker'
import Semester from '@/Components/Sia/Semester'
import getKelas from '@/Functions/getKelas'
import getKategoriNilai from '@/Functions/getKategoriNilai'
import getJenisPenilaian from '@/Functions/getJenisPenilaian'
import Nilai from '@/Components/Sia/Nilai'
import Sweet from '@/Components/Sia/Sweet'
import Ekstrakurikuler from '@/Components/Sia/Ekstrakurikuler'
import getNilaiEkstrakurikuler from '@/Functions/getNilaiEkstrakurikuler'

const InputNilaiEkstrakurikuler = ({ initTahun, initSemester, listEkstrakurikuler }) => {

    const { data, setData, post, processing, errors, reset } = useForm({
        tahun: initTahun,
        semester: initSemester,
        ekstrakurikulerId: '',
        arrayInput: [],
    })

    const [listSiswa, setListSiswa] = useState([])
    const [count, setCount] = useState(0)

    async function getDataNilaiEkstrakurikuler() {
        const response = await getNilaiEkstrakurikuler(data.tahun, data.semester, data.ekstrakurikulerId)
        setData({
            tahun: data.tahun,
            semester: data.semester,
            ekstrakurikulerId: data.ekstrakurikulerId,
            arrayInput: [],
        })
        setListSiswa([])
        setListSiswa(response.listSiswa)
    }

    const handleDynamic = (e, index, id, nis, name, kelasId, namaKelas) => {

        const newList = [...listSiswa]
        newList.splice(index, 1, {
            id: id ?? '',
            nis: nis,
            user: {
                name: name
            },
            nilai: {
                nilai: e.target.value
            },
            kelas:
            {
                id: kelasId,
                nama: namaKelas
            }
        })

        setListSiswa(newList)

        setCount(count + 1)
    }

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    const submit = (e) => {
        e.preventDefault()
        post(route('input-nilai-ekstrakurikuler.simpan'), {
            onSuccess: (page) => {
                toast.success('Berhasil Simpan Nilai Ekstra Siswa')
                setData({
                    tahun: data.tahun,
                    semester: data.semester,
                    ekstrakurikulerId: data.ekstrakurikulerId,
                    arrayInput: [],
                })
            },
            onError: (error) => {
                Sweet.fire({
                    title: 'Gagal!',
                    text: error.pesan,
                    icon: 'error',
                    confirmButtonText: 'Kembali'
                })
            }
        })
    }

    useEffect(() => {

        if (data.tahun
            && data.semester
            && data.ekstrakurikulerId
        ) {
            trackPromise(
                getDataNilaiEkstrakurikuler()
            )

        } else {
            setListSiswa([])
        }
        return () => {
        }
    }, [data.tahun, data.semester, data.ekstrakurikulerId])

    useEffect(() => {

        setData({
            ...data,
            arrayInput: [...listSiswa],
        })

    }, [count])

    return (
        <>
            <Head title='Input Nilai Ekstrakurikuler' />
            <form onSubmit={submit} className='space-y-3'>
                <div className="lg:grid lg:grid-cols-6 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2">

                    <Tahun
                        id="tahun"
                        name="tahun"
                        value={data.tahun}
                        message={errors.tahun}
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

                    <Ekstrakurikuler
                        id="ekstrakurikulerId"
                        name="ekstrakurikulerId"
                        value={data.ekstrakurikulerId}
                        message={errors.ekstrakurikulerId}
                        isFocused={true}
                        listEkstrakurikuler={listEkstrakurikuler}
                        handleChange={onHandleChange}
                    />

                </div>
                <div className="overflow-x-auto">
                    <table className="w-full text-sm text-slate-600">
                        <thead className="text-sm text-slate-600 bg-gray-50">
                            <tr>
                                <th scope='col' className="py-3 px-2">
                                    No
                                </th>
                                <th scope='col' className="py-3 px-2 text-left">
                                    Nis
                                </th>
                                <th scope='col' className="py-3 px-2 text-left">
                                    Nama
                                </th>
                                <th scope='col' className="py-3 px-2 text-left">
                                    Kelas
                                </th>
                                <th scope='col' className="py-3 px-2 text-left">
                                    Nilai
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
                                        {siswa.nis}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {siswa.user.name}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {siswa.kelas.nama}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        <Nilai
                                            id={siswa.nis}
                                            name={siswa.nis}
                                            value={siswa.nilai.nilai ?? ''}
                                            handleChange={(e) => handleDynamic(e, index, siswa.id, siswa.nis, siswa.user.name, siswa.kelas.id, siswa.kelas?.nama)}
                                        />

                                        {
                                            (() => {
                                                if (data.arrayInput.length > 0 && data.arrayInput[index].nilai.nilai > 100) {
                                                    return (
                                                        <span className='text-red-500'>Nilai maksimal 100</span>
                                                    )
                                                }
                                            })
                                                ()}
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
InputNilaiEkstrakurikuler.layout = page => <AppLayout children={page} />
export default InputNilaiEkstrakurikuler