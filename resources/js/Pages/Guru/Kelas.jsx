import React, { useEffect, useRef, useState } from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import PrimaryButton from '@/Components/Breeze/PrimaryButton'
import { toast } from 'react-toastify'
import Edit from '@/Components/Sia/Edit'
import axios from 'axios'

const MataPelajaran = ({ listMataPelajaran }) => {

    const { data, setData, post, processing, errors, reset } = useForm({
        id: '',
        nama: '',
        kelompok: '',
    })

    const inputRef = useRef(null)

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    const handleEdit = (id) => {

        getData(id)

        inputRef.current.focus()
        inputRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' })
    }

    async function getData(id) {
        const response = await axios.post(route('get-edit-mata-pelajaran', {
            id: id
        }))

        setData({
            id: response.data.mataPelajaran.id,
            nama: response.data.mataPelajaran.nama,
            kelompok: response.data.mataPelajaran.kelompok
        })

    }

    const submit = (e) => {
        e.preventDefault()
        post(route('mata-pelajaran.simpan'), {
            onSuccess: (page) => {
                toast.success('Berhasil Simpan Mata Pelajaran')
                setData({
                    id: '',
                    nama: '',
                    kelompok: '',
                })
            },
        })
    }

    return (
        <>
            <Head title='Print Rapor' />
            <form onSubmit={submit} className='space-y-5 mt-10 mb-10'>
                <div className="lg:grid lg:grid-cols-3 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2">
                    <div className='flex flex-col text-slate-600 capitalize col-span-2'>
                        <div>
                            mata pelajaran
                        </div>
                        <div>
                            <input
                                name="nama"
                                id="nama"
                                type='text'
                                value={data.nama}
                                onChange={onHandleChange}
                                ref={inputRef}
                                className='border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm w-full'
                            />
                        </div>
                        {errors.nama ?
                            <div className='text-sm text-red-600'>
                                {errors.nama}
                            </div>
                            :
                            null
                        }
                    </div>
                    <div className='flex flex-col text-slate-600 capitalize'>
                        <div>
                            kelompok
                        </div>
                        <div>
                            <input
                                name="kelompok"
                                id="kelompok"
                                type='text'
                                value={data.kelompok}
                                onChange={onHandleChange}
                                className='border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm w-full'
                            />
                        </div>
                        {errors.kelompok ?
                            <div className='text-sm text-red-600'>
                                {errors.kelompok}
                            </div>
                            :
                            null
                        }
                    </div>

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
                                Mata Pelajaran
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Kelompok
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listMataPelajaran && listMataPelajaran.map((mapel, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {mapel.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {mapel.kelompok}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 inline-flex space-x-3">
                                    <Edit
                                        onClick={() => handleEdit(mapel.id)}
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
MataPelajaran.layout = page => <AppLayout children={page} />
export default MataPelajaran