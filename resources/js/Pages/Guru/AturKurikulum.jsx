import React, { useEffect, useState } from 'react'
import { Head, router, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Tahun from '@/Components/Sia/Tahun'
import { trackPromise } from 'react-promise-tracker'
import Sweet from '@/Components/Sia/Sweet'
import Hapus from '@/Components/Sia/Hapus'
import PrimaryButton from '@/Components/Breeze/PrimaryButton'
import { toast } from 'react-toastify'
import Tingkat from '@/Components/Sia/Tingkat'
import Kurikulum from '@/Components/Sia/Kurikulum'
import getAturanKurikulum from '@/Functions/getAturanKurikulum'

const AturKurikulum = ({ initTahun, listKurikulum }) => {

    const { data, setData, post, errors } = useForm({
        tahun: initTahun,
        kurikulumId: '',
        tingkat: '',
    })

    const [listAturan, setListAturan] = useState([])

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    async function getDataAturanKurikulum() {
        const response = await getAturanKurikulum(data.tahun)
        setListAturan(response.listAturan)
    }

    const handleDelete = (id) => {
        Sweet.fire({
            title: 'Anda yakin menghapus?',
            text: "Hapus Aturan Kurikulum!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        })
            .then((result) => {
                if (result.isConfirmed) {
                    router.delete(route('atur-kurikulum.hapus',
                        {
                            id: id
                        }),
                        {
                            onSuccess: (page) => {
                                toast.success('Berhasil Hapus Kurikulum')
                                setData({
                                    tahun: data.tahun,
                                    kurikulumId: data.kurikulumId,
                                    tingkat: data.tingkat,
                                })

                                trackPromise(
                                    getDataAturanKurikulum()
                                )
                            }
                        })
                }
            })
    }

    useEffect(() => {

        if (data.tahun)
            trackPromise(
                getDataAturanKurikulum()
            )

    }, [data.tahun])

    const submit = (e) => {
        e.preventDefault()
        post(route('atur-kurikulum.simpan'), {
            onSuccess: (page) => {
                toast.success('Berhasil Atur Kurikulum')
                setData({
                    tahun: data.tahun,
                    kurikulumId: data.kurikulumId,
                    tingkat: data.tingkat,
                })

                trackPromise(
                    getDataAturanKurikulum()
                )
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

    return (
        <>
            <Head title='Atur Kurikulum' />
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

                    <Tingkat
                        id="tingkat"
                        name="tingkat"
                        value={data.tingkat}
                        message={errors.tingkat}
                        isFocused={true}
                        handleChange={onHandleChange}
                    />

                    <Kurikulum
                        id="kurikulumId"
                        name="kurikulumId"
                        value={data.kurikulumId}
                        message={errors.kurikulumId}
                        listKurikulum={listKurikulum}
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
                                Kurikulum
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listAturan && listAturan.map((aturan, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {aturan.tingkat}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {aturan.kurikulum?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <Hapus
                                        onClick={() => handleDelete(aturan.id)}
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
AturKurikulum.layout = page => <AppLayout children={page} />
export default AturKurikulum