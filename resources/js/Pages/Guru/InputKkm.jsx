import React, { useState, useEffect } from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Tahun from '@/Components/Sia/Tahun'
import { trackPromise } from 'react-promise-tracker'
import Semester from '@/Components/Sia/Semester'
import MataPelajaran from '@/Components/Sia/MataPelajaran'
import KategoriNilai from '@/Components/Sia/KategoriNilai'
import JenisPenilaian from '@/Components/Sia/JenisPenilaian'
import getMataPelajaran from '@/Functions/getMataPelajaran'
import Tingkat from '@/Components/Sia/Tingkat'
import getJenisPenilaianPerTingkat from '@/Functions/getJenisPenilaianPerTingkat'
import getKategoriNilaiPerTingkat from '@/Functions/getKategoriNilaiPerTingkat'
import PrimaryButton from '@/Components/Breeze/PrimaryButton'
import getDeskripsiPenilaian from '@/Functions/getDeskripsiPenilaian'
import { toast } from 'react-toastify'
import Hapus from '@/Components/Sia/Hapus'
import Sweet from '@/Components/Sia/Sweet'

const InputKkm = ({ initTahun, initSemester }) => {

    const { data, setData, post, errors, delete: destroy } = useForm({
        tahun: initTahun,
        semester: initSemester,
        mataPelajaranId: '',
        tingkat: '',
        kategoriNilaiId: '',
        jenisPenilaianId: '',
        deskripsi: ''
    })


    const [listJenis, setListJenis] = useState([])
    const [listKategori, setListKategori] = useState([])
    const [listMataPelajaran, setListMataPelajaran] = useState([])
    const [listDeskripsi, setListDeskripsi] = useState([])

    async function getDataMataPelajaran() {
        const response = await getMataPelajaran(data.tahun)

        setListMataPelajaran(response.listMataPelajaran)
    }

    async function getDataKategoriNilai() {
        const response = await getKategoriNilaiPerTingkat(data.tahun, data.tingkat)
        setListKategori(response.listKategori)
    }

    async function getDataJenisPenilaian() {
        const response = await getJenisPenilaianPerTingkat(data.tahun, data.semester, data.tingkat, data.kategoriNilaiId)
        setListJenis(response.listJenis)
    }

    async function getDataListDeskripsi() {
        const response = await getDeskripsiPenilaian(data.tahun, data.semester, data.mataPelajaranId, data.tingkat)
        setListDeskripsi(response.listDeskripsi)
    }

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    const submit = (e) => {
        e.preventDefault()
        post(route('input-kd.simpan'), {
            onSuccess: (page) => {
                toast.success('Berhasil Simpan Deskripsi Penilaian')
                setData({
                    tahun: data.tahun,
                    semester: data.semester,
                    mataPelajaranId: data.mataPelajaranId,
                    tingkat: data.tingkat,
                    kategoriNilaiId: data.kategoriNilaiId,
                    jenisPenilaianId: data.jenisPenilaianId,
                    deskripsi: data.deskripsi
                })

                getDataListDeskripsi()
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

    const handleDelete = (id) => {
        Sweet.fire({
            title: 'Anda yakin menghapus?',
            text: "Hapus Deskripsi Penilaian!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        })
            .then((result) => {
                if (result.isConfirmed) {
                    destroy(route('input-kd.hapus',
                        {
                            id: id
                        }),
                        {
                            onSuccess: (page) => {
                                toast.success('Berhasil Hapus Deskripsi Penilaian')
                                setData({
                                    tahun: data.tahun,
                                    semester: data.semester,
                                    mataPelajaranId: data.mataPelajaranId,
                                    tingkat: data.tingkat,
                                    kategoriNilaiId: data.kategoriNilaiId,
                                    jenisPenilaianId: data.jenisPenilaianId,
                                    deskripsi: data.deskripsi
                                })
                                getDataListDeskripsi()
                            }
                        })
                }
            })
    }

    useEffect(() => {

        if (data.tahun)
            trackPromise(
                getDataMataPelajaran()
            )

    }, [data.tahun])

    useEffect(() => {

        if (data.tahun
            && data.tingkat
        )
            trackPromise(
                getDataKategoriNilai()
            )

    }, [data.tahun, data.tingkat])

    useEffect(() => {

        if (data.tahun
            && data.tingkat
            && data.semester
            && data.mataPelajaranId
        )
            trackPromise(
                getDataListDeskripsi()
            )
    }, [data.tahun, data.tingkat, data.semester, data.mataPelajaranId])

    useEffect(() => {

        if (data.tahun
            && data.tingkat
            && data.semester
            && data.kategoriNilaiId
        )
            trackPromise(
                getDataJenisPenilaian()
            )
    }, [data.tahun, data.tingkat, data.semester, data.kategoriNilaiId])

    return (
        <>
            <Head title='Input KKM' />
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

                    <Tingkat
                        id="tingkat"
                        name="tingkat"
                        value={data.tingkat}
                        message={errors.tingkat}
                        isFocused={true}
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

                <div className='flex flex-col text-slate-600'>
                    <div>
                        Deskripsi KD / TP
                    </div>
                    <div>
                        <textarea
                            name="deskripsi"
                            id="deskripsi"
                            rows="3"
                            value={data.deskripsi}
                            onChange={onHandleChange}
                            className='border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm w-full'
                        >

                        </textarea>
                    </div>
                    {errors.deskripsi ?
                        <div className='text-sm text-red-600'>
                            {errors.deskripsi}
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
                                Kategori Nilai
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Jenis Penilaian
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Deskripsi KD / TP
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listDeskripsi && listDeskripsi.map((deskripsi, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {deskripsi.kategori_nilai?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {deskripsi.jenis_penilaian?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {deskripsi.deskripsi}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <Hapus onClick={() => handleDelete(deskripsi.id)} />
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}
InputKkm.layout = page => <AppLayout children={page} />
export default InputKkm