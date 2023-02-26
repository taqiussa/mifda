import React, { useEffect, useState } from 'react'
import { Head, useForm } from '@inertiajs/react'
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
import Guru from '@/Components/Sia/Guru'

const AturGuruKelas = ({ initTahun, initSemester, listKelas, listUser }) => {

    const { data, setData, post, processing, errors, reset } = useForm({
        tahun: initTahun,
        semester: initSemester,
        kelasId: '',
        userId: ''
    })

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
                    text: error.pesan,
                    icon: 'error',
                    confirmButtonText: 'Kembali'
                })
            }
        })
    }

    // useEffect(() => {

    //     if (data.tahun) {

    //         trackPromise(
    //             getDataKelasWali()
    //         )

    //     }
    // }, [data.tahun])

    // useEffect(() => {

    //     if (data.tahun && data.kelasId
    //     ) {

    //         trackPromise(
    //             getDataSiswa()
    //         )

    //     }
    //     else {
    //         setListSiswa([])
    //     }
    // }, [data.tahun, data.kelasId])

    // useEffect(() => {

    //     if (data.tahun
    //         && data.semester
    //         && data.kelasId
    //     ) {

    //         trackPromise(
    //             getDataCatatan()
    //         )

    //     }
    //     else {
    //         setListCatatan([])
    //     }
    // }, [data.tahun, data.semester, data.kelasId])

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

                    <div className="lg:col-span-2">

                        <Guru
                            id="userId"
                            name="userId"
                            value={data.userId}
                            message={errors.userId}
                            listUser={listUser}
                            handleChange={onHandleChange}
                        />

                    </div>

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
                        {/* {listCatatan && listCatatan.map((siswa, index) => (
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
                                    <Hapus />
                                </td>
                            </tr>
                        ))} */}
                    </tbody>
                </table>
            </div>
        </>
    )
}
AturGuruKelas.layout = page => <AppLayout children={page} />
export default AturGuruKelas