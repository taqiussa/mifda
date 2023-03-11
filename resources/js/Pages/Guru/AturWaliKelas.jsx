import React, { useEffect, useState } from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Tahun from '@/Components/Sia/Tahun'
import Kelas from '@/Components/Sia/Kelas'
import { trackPromise } from 'react-promise-tracker'
import Sweet from '@/Components/Sia/Sweet'
import Hapus from '@/Components/Sia/Hapus'
import PrimaryButton from '@/Components/Breeze/PrimaryButton'
import { toast } from 'react-toastify'
import Guru from '@/Components/Sia/Guru'
import getWaliKelas from '@/Functions/getWaliKelas'

const AturWaliKelas = ({ initTahun, listKelas, listUser }) => {

    const { data, setData, post, errors, delete: destroy } = useForm({
        tahun: initTahun,
        userId: '',
        kelasId: '',
    })

    const [listWaliKelas, setListWaliKelas] = useState([])

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    async function getDataWaliKelas() {
        const response = await getWaliKelas(data.tahun)
        setListWaliKelas(response.listWaliKelas)
    }

    const handleDelete = (id) => {
        Sweet.fire({
            title: 'Anda yakin menghapus?',
            text: "Hapus Wali kelas!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        })
            .then((result) => {
                if (result.isConfirmed) {
                    destroy(route('atur-wali-kelas.hapus',
                        {
                            id: id
                        }),
                        {
                            onSuccess: (page) => {
                                toast.success('Berhasil Hapus Wali Kelas')
                                setData({
                                    tahun: data.tahun,
                                    userId: data.userId,
                                    kelasId: data.kelasId,
                                })
                                getDataWaliKelas()
                            }
                        })
                }
            })
    }

    const submit = (e) => {
        e.preventDefault()
        post(route('atur-wali-kelas.simpan'), {
            onSuccess: (page) => {
                toast.success('Berhasil Atur Wali Kelas')
                setData({
                    tahun: data.tahun,
                    userId: data.userId,
                    kelasId: data.kelasId,
                })

                getDataWaliKelas()

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

        if (data.tahun
        ) {

            trackPromise(
                getDataWaliKelas()
            )

        }
        else {
            setListWaliKelas([])
        }
    }, [data.tahun])

    return (
        <>
            <Head title='Print Rapor' />
            <form onSubmit={submit} className='space-y-5 mt-10 mb-10'>

                <div className="lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2">

                    <Tahun
                        id="tahun"
                        name="tahun"
                        value={data.tahun}
                        message={errors.tahun}
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
                                Kelas
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Wali Kelas
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listWaliKelas && listWaliKelas.map((kelas, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {kelas.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {kelas.wali_kelas?.user?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">

                                    {
                                        kelas.wali_kelas.id &&
                                        <Hapus
                                            onClick={() => handleDelete(kelas.wali_kelas?.id)}
                                        />
                                    }
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}
AturWaliKelas.layout = page => <AppLayout children={page} />
export default AturWaliKelas