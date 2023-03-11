import React, { useEffect, useState } from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Tahun from '@/Components/Sia/Tahun'
import Semester from '@/Components/Sia/Semester'
import { trackPromise } from 'react-promise-tracker'
import Sweet from '@/Components/Sia/Sweet'
import Hapus from '@/Components/Sia/Hapus'
import PrimaryButton from '@/Components/Breeze/PrimaryButton'
import { toast } from 'react-toastify'
import getPenilaianRapor from '@/Functions/getPenilaianRapor'
import Kurikulum from '@/Components/Sia/Kurikulum'
import KategoriNilai from '@/Components/Sia/KategoriNilai'
import JenisPenilaian from '@/Components/Sia/JenisPenilaian'

const AturPenilaianRapor = ({ initTahun, initSemester, listKurikulum, listKategori, listJenis }) => {

    const { data, setData, post, errors, delete: destroy } = useForm({
        tahun: initTahun,
        semester: initSemester,
        kurikulumId: '',
        kategoriNilaiId: '',
        JenisPenilaianId: '',
    })

    const [listPenilaian, setListPenilaian] = useState([])

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    async function getDataPenilaianRapor() {
        const response = await getPenilaianRapor(data.tahun, data.semester)
        setListPenilaian(response.listPenilaian)
    }

    const handleDelete = (id) => {
        Sweet.fire({
            title: 'Anda yakin menghapus?',
            text: "Hapus Penilaian Rapor!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        })
            .then((result) => {
                if (result.isConfirmed) {
                    destroy(route('atur-penilaian-rapor.hapus',
                        {
                            id: id
                        }),
                        {
                            onSuccess: (page) => {

                                toast.success('Berhasil Hapus Penilaian Rapor')

                                setData({
                                    tahun: data.tahun,
                                    semester: data.semester,
                                    kurikulumId: data.kurikulumId,
                                    kategoriNilaiId: data.kategoriNilaiId,
                                    JenisPenilaianId: data.JenisPenilaianId,
                                })

                                getDataPenilaianRapor()

                            }
                        })
                }
            })
    }

    const submit = (e) => {
        e.preventDefault()
        post(route('atur-penilaian-rapor.simpan'), {
            onSuccess: (page) => {

                toast.success('Berhasil Atur Penilaian Rapor')

                setData({
                    tahun: data.tahun,
                    semester: data.semester,
                    kurikulumId: data.kurikulumId,
                    kategoriNilaiId: data.kategoriNilaiId,
                    JenisPenilaianId: data.JenisPenilaianId,
                })

                getDataPenilaianRapor()

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
            && data.semester
        ) {

            trackPromise(
                getDataPenilaianRapor()
            )

        }
        else {
            setListPenilaian([])
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

                    <Kurikulum
                        id="kurikulumId"
                        name="kurikulumId"
                        value={data.kurikulumId}
                        message={errors.kurikulumId}
                        isFocused={true}
                        listKurikulum={listKurikulum}
                        handleChange={onHandleChange}
                    />

                    <KategoriNilai
                        id="kategoriNilaiId"
                        name="kategoriNilaiId"
                        value={data.kategoriNilaiId}
                        message={errors.kategoriNilaiId}
                        isFocused={true}
                        listKategori={listKategori}
                        handleChange={onHandleChange}
                    />

                    <JenisPenilaian
                        id="jenisPenilaianId"
                        name="jenisPenilaianId"
                        value={data.jenisPenilaianId}
                        message={errors.jenisPenilaianId}
                        isFocused={true}
                        listJenis={listJenis}
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
                                Kurikulum
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Kategori Nilai
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Jenis Penilaian
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listPenilaian && listPenilaian.map((penilaian, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {penilaian.kurikulum?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {penilaian.kategori_nilai?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {penilaian.jenis_penilaian?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <Hapus
                                        onClick={() => handleDelete(penilaian.id)}
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