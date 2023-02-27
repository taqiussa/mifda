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
import MataPelajaran from '@/Components/Sia/MataPelajaran'
import getMataPelajaran from '@/Functions/getMataPelajaran'
import getGuruKelas from '@/Functions/getGuruKelas'

const AturGuruKelas = ({ initTahun, initSemester, listKelas, listUser }) => {

    const { data, setData, post, processing, errors, reset } = useForm({
        tahun: initTahun,
        semester: initSemester,
        userId: '',
        mataPelajaranId: '',
        kelasId: '',
    })

    const [listMataPelajaran, setListMataPelajaran] = useState([])
    const [listGuruKelas, setListGuruKelas] = useState([])

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    async function getDataMataPelajaran() {
        const response = await getMataPelajaran(data.tahun, data.userId)
        setListMataPelajaran(response.listMataPelajaran)
    }

    async function getDataGuruKelas() {
        const response = await getGuruKelas(data.tahun, data.semester)
        setListGuruKelas(response.listGuruKelas)
    }

    const submit = (e) => {
        e.preventDefault()
        post(route('atur-guru-kelas.simpan'), {
            onSuccess: (page) => {
                toast.success('Berhasil Atur Guru Kelas')
                setData({
                    tahun: data.tahun,
                    semester: data.semester,
                    userId: data.userId,
                    mataPelajaranId: data.mataPelajaranId,
                    kelasId: data.kelasId,
                })

                getDataGuruKelas()

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

        if (data.tahun && data.userId
        ) {

            trackPromise(
                getDataMataPelajaran()
            )

        }
        else {
            setListMataPelajaran([])
        }
    }, [data.tahun, data.userId])

    useEffect(() => {

        if (data.tahun
            && data.semester
        ) {

            trackPromise(
                getDataGuruKelas()
            )

        }
        else {
            setListGuruKelas([])
        }
    }, [data.tahun, data.semester])

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

                    <MataPelajaran
                        id="mataPelajaranId"
                        name="mataPelajaranId"
                        value={data.mataPelajaranId}
                        message={errors.mataPelajaranId}
                        isFocused={true}
                        listMapel={listMataPelajaran}
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
                                Keterangan
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listGuruKelas && listGuruKelas.map((user, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {user.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <ul>
                                        {user.kelas && user.kelas.map((kelas, index) => (
                                            <li>
                                                {index + 1 + '. ' + kelas.kelas.nama + ' ' + kelas.mapel.nama}
                                            </li>
                                        ))}
                                    </ul>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}
AturGuruKelas.layout = page => <AppLayout children={page} />
export default AturGuruKelas