import React, { useEffect, useState } from 'react'
import { Head, router, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Tahun from '@/Components/Sia/Tahun'
import Kelas from '@/Components/Sia/Kelas'
import Semester from '@/Components/Sia/Semester'
import getKelasWali from '@/Functions/getKelasWali'
import { trackPromise } from 'react-promise-tracker'
import getSiswa from '@/Functions/getSiswa'
import Siswa from '@/Components/Sia/Siswa'
import Sweet from '@/Components/Sia/Sweet'
import Hapus from '@/Components/Sia/Hapus'
import getCatatan from '@/Functions/getCatatan'
import PrimaryButton from '@/Components/Breeze/PrimaryButton'
import { toast } from 'react-toastify'

const InputCatatan = ({ initTahun, initSemester, listKelas, initKelasId }) => {

    const { data, setData, post, processing, errors, reset } = useForm({
        tahun: initTahun,
        semester: initSemester,
        kelasId: initKelasId,
        catatan: '',
        nis: ''
    })

    const [listSiswa, setListSiswa] = useState([])
    const [listCatatan, setListCatatan] = useState([])

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    async function getDataKelasWali() {
        const response = await getKelasWali(data.tahun)
        if (response.kelasId) {
            setData({
                tahun: data.tahun,
                semester: data.semester,
                kelasId: response.kelasId
            });
        } else {
            setData({
                tahun: data.tahun,
                semester: data.semester,
                kelasId: ''
            });
        }
    }

    async function getDataSiswa() {
        const response = await getSiswa(data.tahun, data.kelasId)
        setListSiswa(response.listSiswa)
    }

    async function getDataCatatan() {
        const response = await getCatatan(data.tahun, data.semester, data.kelasId)
        setListCatatan(response.listCatatan)
    }

    const handleDelete = (id) => {
        Sweet.fire({
            title: 'Anda yakin menghapus?',
            text: "Hapus Catatan Wali Kelas!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        })
            .then((result) => {
                if (result.isConfirmed) {
                    router.delete(route('input-catatan.hapus',
                        {
                            id: id
                        }),
                        {
                            onSuccess: (page) => {
                                toast.success('Berhasil Hapus Catatan Wali Kelas')
                                setData({
                                    tahun: data.tahun,
                                    semester: data.semester,
                                    kelasId: data.kelasId,
                                    catatan: data.catatan,
                                    nis: data.nis
                                })
                                getDataCatatan()
                            }
                        })
                }
            })
    }

    const submit = (e) => {
        e.preventDefault()
        post(route('input-catatan.simpan'), {
            onSuccess: (page) => {
                toast.success('Berhasil Simpan Catatan Wali Kelas')
                setData({
                    tahun: data.tahun,
                    semester: data.semester,
                    kelasId: data.kelasId,
                    catatan: data.catatan,
                    nis: data.nis
                })

                getDataCatatan()

            },
            onError: (error) => {
                Sweet.fire({
                    title: 'Gagal!',
                    text: error,
                    icon: 'error',
                    confirmButtonText: 'Kembali'
                })
            }
        })
    }

    useEffect(() => {

        if (data.tahun) {

            trackPromise(
                getDataKelasWali()
            )

        }
    }, [data.tahun])

    useEffect(() => {

        if (data.tahun && data.kelasId
        ) {

            trackPromise(
                getDataSiswa()
            )

        }
        else {
            setListSiswa([])
        }
    }, [data.tahun, data.kelasId])

    useEffect(() => {

        if (data.tahun
            && data.semester
            && data.kelasId
        ) {

            trackPromise(
                getDataCatatan()
            )

        }
        else {
            setListCatatan([])
        }
    }, [data.tahun, data.semester, data.kelasId])

    return (
        <>
            <Head title='Print Rapor' />
            <form onSubmit={submit} className='space-y-5 mt-10 mb-10'>

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

                    <Kelas
                        id="kelasId"
                        name="kelasId"
                        value={data.kelasId}
                        message={errors.kelasId}
                        isFocused={true}
                        listKelas={listKelas}
                        handleChange={onHandleChange}
                        disabled={true}
                    />
                    <div className="lg:col-span-2">

                        <Siswa
                            id="nis"
                            name="nis"
                            value={data.nis}
                            message={errors.nis}
                            listSiswa={listSiswa}
                            handleChange={onHandleChange}
                        />

                    </div>

                </div>
                <div className='flex flex-col text-slate-600 capitalize'>
                    <div>
                        catatan wali kelas
                    </div>
                    <div>
                        <textarea
                            name="catatan"
                            id="catatan"
                            rows="3"
                            value={data.catatan}
                            onChange={onHandleChange}
                            className='border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm w-full'
                        >

                        </textarea>
                    </div>
                    {errors.catatan ?
                        <div className='text-sm text-red-600'>
                            {errors.catatan}
                        </div>
                        :
                        null
                    }
                </div>
                <div className="flex justify-end">
                    <PrimaryButton onClick={submit}>
                        Simpan
                    </PrimaryButton>
                </div>
            </form>
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
                                Catatan
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listCatatan && listCatatan.map((siswa, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.user.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.catatan}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 inline-flex space-x-3">
                                    <Hapus
                                        onClick={() => handleDelete(siswa.id)}
                                    />
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}
InputCatatan.layout = page => <AppLayout children={page} />
export default InputCatatan