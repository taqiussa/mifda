import React from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Tahun from '@/Components/Sia/Tahun'
import Semester from '@/Components/Sia/Semester'
import Sweet from '@/Components/Sia/Sweet'
import Hapus from '@/Components/Sia/Hapus'
import PrimaryButton from '@/Components/Breeze/PrimaryButton'
import { toast } from 'react-toastify'
import moment from 'moment'
import Tanggal from '@/Components/Sia/Tanggal'
import { hariTanggal } from '@/Functions/functions'

const AturPenilaianRapor = ({ initTahun, initSemester, listTanggal }) => {

    const { data, setData, post, reset, errors, delete: destroy } = useForm({
        tahun: initTahun,
        semester: initSemester,
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
    })


    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    const handleDelete = (id) => {
        Sweet.fire({
            title: 'Anda yakin menghapus?',
            text: "Hapus Tanggal Rapor!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        })
            .then((result) => {
                if (result.isConfirmed) {
                    destroy(route('atur-tanggal-rapor.hapus',
                        {
                            id: id
                        }),
                        {
                            onSuccess: (page) => {

                                toast.success('Berhasil Hapus Tanggal Rapor')

                                setData({
                                    tahun: data.tahun,
                                    semester: data.semester,
                                    tanggal: data.tanggal
                                })

                                reset()

                            }
                        })
                }
            })
    }

    const submit = (e) => {
        e.preventDefault()
        post(route('atur-tanggal-rapor.simpan'), {
            onSuccess: (page) => {

                toast.success('Berhasil Atur Tanggal Rapor')


                setData({
                    tahun: data.tahun,
                    semester: data.semester,
                    tanggal: data.tanggal
                })

                reset()

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
            <Head title='Atur Tanggal Rapor' />
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

                    <Tanggal
                        id="tanggal"
                        name="tanggal"
                        label="tanggal"
                        value={data.tanggal}
                        message={errors.tanggal}
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
                                Tahun
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Semester
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Tanggal
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listTanggal && listTanggal.map((data, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {data.tahun}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {data.semester}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {data.tanggal && hariTanggal(data.tanggal)}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <Hapus
                                        onClick={() => handleDelete(data.id)}
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
AturPenilaianRapor.layout = page => <AppLayout children={page} />
export default AturPenilaianRapor