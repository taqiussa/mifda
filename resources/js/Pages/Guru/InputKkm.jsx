import React, { useState, useEffect } from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Tahun from '@/Components/Sia/Tahun'
import { trackPromise } from 'react-promise-tracker'
import MataPelajaran from '@/Components/Sia/MataPelajaran'
import getMataPelajaran from '@/Functions/getMataPelajaran'
import Tingkat from '@/Components/Sia/Tingkat'
import PrimaryButton from '@/Components/Breeze/PrimaryButton'
import { toast } from 'react-toastify'
import Hapus from '@/Components/Sia/Hapus'
import Sweet from '@/Components/Sia/Sweet'
import getKkm from '@/Functions/getKkm'
import Kkm from '@/Components/Sia/Kkm'

const InputKkm = ({ initTahun }) => {

    const { data, setData, post, errors, delete: destroy } = useForm({
        tahun: initTahun,
        mataPelajaranId: '',
        tingkat: '',
        kkm: ''
    })


    const [listMataPelajaran, setListMataPelajaran] = useState([])
    const [listKkm, setListKkm] = useState([])

    async function getDataMataPelajaran() {
        const response = await getMataPelajaran(data.tahun)

        setListMataPelajaran(response.listMataPelajaran)
    }

    async function getDataKkm() {
        const response = await getKkm(data.tahun, data.mataPelajaranId)

        setListKkm(response.listKkm)
    }

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    const submit = (e) => {
        e.preventDefault()
        post(route('input-kkm.simpan'), {
            onSuccess: (page) => {
                toast.success('Berhasil Simpan KKM Penilaian')
                setData({
                    tahun: data.tahun,
                    semester: data.semester,
                    mataPelajaranId: data.mataPelajaranId,
                    kkm: data.kkm,
                    tingkat: data.tingkat
                })
                getDataKkm()
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
            text: "Hapus KKM Penilaian!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        })
            .then((result) => {
                if (result.isConfirmed) {
                    destroy(route('input-kkm.hapus',
                        {
                            id: id
                        }),
                        {
                            onSuccess: (page) => {
                                toast.success('Berhasil Hapus KKM Penilaian')
                                setData({
                                    tahun: data.tahun,
                                    semester: data.semester,
                                    mataPelajaranId: data.mataPelajaranId,
                                    kkm: data.kkm,
                                    tingkat: data.tingkat
                                })
                                getDataKkm()
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
            && data.mataPelajaranId
        )
            trackPromise(
                getDataKkm()
            )

    }, [data.tahun, data.mataPelajaranId])

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

                    <Kkm
                        id="kkm"
                        name="kkm"
                        value={data.kkm}
                        message={errors.kkm}
                        isFocused={true}
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
                                Tingkat
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                KKM
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listKkm && listKkm.map((kkm, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {kkm.tingkat}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {kkm.kkm}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <Hapus onClick={() => handleDelete(kkm.id)} />
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