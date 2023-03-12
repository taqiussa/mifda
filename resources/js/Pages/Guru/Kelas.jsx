import React, { useRef } from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import PrimaryButton from '@/Components/Breeze/PrimaryButton'
import { toast } from 'react-toastify'
import Edit from '@/Components/Sia/Edit'
import axios from 'axios'
import Tingkat from '@/Components/Sia/Tingkat'

const Kelas = ({ listKelas }) => {

    const { data, setData, post, errors } = useForm({
        id: '',
        nama: '',
        tingkat: ''
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
        const response = await axios.post(route('kelas.edit', {
            id: id
        }))

        setData({
            id: response.data.kelas.id,
            nama: response.data.kelas.nama,
            tingkat: response.data.kelas.tingkat
        })

    }

    const submit = (e) => {
        e.preventDefault()
        post(route('kelas.simpan'), {
            onSuccess: (page) => {
                toast.success('Berhasil Simpan Kelas')
                setData({
                    id: '',
                    nama: '',
                    tingkat: ''
                })
            },
        })
    }

    return (
        <>
            <Head title='Kelas' />
            <form onSubmit={submit} className='space-y-5 mt-10 mb-10'>
                <div className="lg:grid lg:grid-cols-6 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2">
                    <div className='flex flex-col text-slate-600 capitalize'>
                        <div>
                            kelas
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

                    <Tingkat
                        id="tingkat"
                        name="tingkat"
                        value={data.tingkat}
                        message={errors.tingkat}
                        isFocused={true}
                        handleChange={onHandleChange}
                    />

                    <div className='flex items-end'>
                        <PrimaryButton onClick={submit}>
                            Simpan
                        </PrimaryButton>
                    </div>
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
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listKelas && listKelas.map((kelas, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {kelas.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 inline-flex space-x-3">
                                    <Edit
                                        onClick={() => handleEdit(kelas.id)}
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
Kelas.layout = page => <AppLayout children={page} />
export default Kelas