import React, { useState, useEffect } from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Tahun from '@/Components/Sia/Tahun'
import PrimaryButton from '@/Components/Breeze/PrimaryButton'
import Kelas from '@/Components/Sia/Kelas'
import { toast } from 'react-toastify';
import { trackPromise } from 'react-promise-tracker'
import Semester from '@/Components/Sia/Semester'
import MataPelajaran from '@/Components/Sia/MataPelajaran'
import KategoriNilai from '@/Components/Sia/KategoriNilai'
import JenisPenilaian from '@/Components/Sia/JenisPenilaian'
import getKelas from '@/Functions/getKelas'
import getKategoriNilai from '@/Functions/getKategoriNilai'
import getJenisPenilaian from '@/Functions/getJenisPenilaian'
import Nilai from '@/Components/Sia/Nilai'
import getNilaiSiswa from '@/Functions/getNilaiSiswa'
import Sweet from '@/Components/Sia/Sweet'

const InputNilai = ({ initTahun, initSemester, listMataPelajaran }) => {

    const { data, setData, post, processing, errors, reset } = useForm({
        tahun: initTahun,
        semester: initSemester,
        mataPelajaranId: '',
        kelasId: '',
        kategoriNilaiId: '',
        jenisPenilaianId: '',
        arrayInput: [],
    })

    const [listSiswa, setListSiswa] = useState([])
    const [listKategori, setListKategori] = useState([])
    const [listJenis, setListJenis] = useState([])
    const [listKelas, setListKelas] = useState([])
    const [count, setCount] = useState(0)

    async function getDataNilaiSiswa() {
        const response = await getNilaiSiswa(data.tahun, data.semester, data.mataPelajaranId, data.kelasId, data.kategoriNilaiId, data.jenisPenilaianId)
        setData({
            tahun: data.tahun,
            semester: data.semester,
            mataPelajaranId: data.mataPelajaranId,
            kelasId: data.kelasId,
            kategoriNilaiId: data.kategoriNilaiId,
            jenisPenilaianId: data.jenisPenilaianId,
            arrayInput: [],
        })
        setListSiswa([])
        setListSiswa(response.listSiswa)
    }

    async function getDataKategoriNilai() {
        const response = await getKategoriNilai(data.tahun, data.kelasId)
        setListKategori(response.listKategori)
    }

    async function getDataJenisPenilaian() {
        const response = await getJenisPenilaian(data.tahun, data.semester, data.kelasId, data.kategoriNilaiId)
        setListJenis(response.listJenis)
    }

    async function getDataKelas() {
        const response = await getKelas(data.tahun, data.mataPelajaranId)
        setListKelas(response.listKelas)
    }


    const handleDynamic = (e, index, id, nis, name) => {

        const newList = [...listSiswa]
        newList.splice(index, 1, {
            id: id ?? '',
            nis: nis,
            user: {
                name: name
            },
            nilai: {
                nilai: e.target.value
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
        post(route('input-nilai.simpan'), {
            onSuccess: (page) => {
                toast.success('Berhasil Simpan Nilai Siswa')
                setData({
                    tahun: data.tahun,
                    semester: data.semester,
                    mataPelajaranId: data.mataPelajaranId,
                    kelasId: data.kelasId,
                    kategoriNilaiId: data.kategoriNilaiId,
                    jenisPenilaianId: data.jenisPenilaianId,
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
            && data.mataPelajaranId
        ) {

            trackPromise(
                getDataKelas()
            )

        }
    }, [data.tahun, data.mataPelajaranId])

    useEffect(() => {

        if (data.tahun
            && data.kelasId
        ) {
            trackPromise(
                getDataKategoriNilai()
            )

        }
        return () => {
        }
    }, [data.tahun, data.kelasId])

    useEffect(() => {

        if (data.tahun
            && data.semester
            && data.kelasId
            && data.kategoriNilaiId
        ) {
            trackPromise(
                getDataJenisPenilaian()
            )

        }
        return () => {
        }
    }, [data.tahun, data.semester, data.kelasId, data.kategoriNilaiId])

    useEffect(() => {

        if (data.tahun
            && data.semester
            && data.mataPelajaranId
            && data.kelasId
            && data.kategoriNilaiId
            && data.jenisPenilaianId
        ) {
            trackPromise(
                getDataNilaiSiswa()
            )

        } else {
            setListSiswa([])
        }
        return () => {
        }
    }, [data.tahun, data.semester, data.mataPelajaranId, data.kelasId, data.kategoriNilaiId, data.jenisPenilaianId])

    useEffect(() => {

        setData({
            ...data,
            arrayInput: [...listSiswa],
        })

    }, [count])

    return (
        <>
            <Head title='Input Nilai' />
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

                    <KategoriNilai
                        id="kategoriNilaiId"
                        name="kategoriNilaiId"
                        value={data.kategoriNilaiId}
                        message={errors.kategoriNilaiId}
                        listKategori={listKategori}
                        isFocused={true}
                        handleChange={onHandleChange}
                    />

                    <JenisPenilaian
                        id="jenisPenilaianId"
                        name="jenisPenilaianId"
                        value={data.jenisPenilaianId}
                        message={errors.jenisPenilaianId}
                        listJenis={listJenis}
                        isFocused={true}
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
                                        <Nilai
                                            id={siswa.nis}
                                            name={siswa.nis}
                                            value={siswa.nilai.nilai ?? ''}
                                            handleChange={(e) => handleDynamic(e, index, siswa.id, siswa.nis, siswa.user.name)}
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
InputNilai.layout = page => <AppLayout children={page} />
export default InputNilai