import React, { useEffect, useState } from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Tahun from '@/Components/Sia/Tahun'
import Kelas from '@/Components/Sia/Kelas'
import PrintLink from '@/Components/Sia/PrintLink'
import Semester from '@/Components/Sia/Semester'
import getKelasWali from '@/Functions/getKelasWali'
import { trackPromise } from 'react-promise-tracker'
import getSiswa from '@/Functions/getSiswa'
import DownloadLink from '@/Components/Sia/DownloadLink'

const PrintRapor = ({ initTahun, initSemester, listKelas, initKelasId }) => {

    const { data, setData, post, processing, errors, reset } = useForm({
        tahun: initTahun,
        semester: initSemester,
        kelasId: initKelasId,
    })

    const [listSiswa, setListSiswa] = useState([])

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    async function getDataKelasWali() {
        const response = await getKelasWali(data.tahun)
        if (response.kelasId) {
            setData({
                tahun: data.tahun,
                semester: data.semester,
                kelasId: response.kelasId
            });
        } else {
            setData({
                tahun: data.tahun,
                semester: data.semester,
                kelasId: ''
            });
        }
    }

    async function getDataSiswa() {
        const response = await getSiswa(data.tahun, data.kelasId)
        setListSiswa(response.listSiswa)
    }

    useEffect(() => {

        if (data.tahun) {

            trackPromise(
                getDataKelasWali()
            )

        }
    }, [data.tahun])

    useEffect(() => {

        if (data.tahun && data.kelasId
        ) {

            trackPromise(
                getDataSiswa()
            )

        }
        else {
            setListSiswa([])
        }
    }, [data.tahun, data.kelasId])

    return (
        <>
            <Head title='Print Rapor' />
            <div className='space-y-10 mt-10'>

                <div className="lg:grid lg:grid-cols-7 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2">

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

                    <Kelas
                        id="kelasId"
                        name="kelasId"
                        value={data.kelasId}
                        message={errors.kelasId}
                        isFocused={true}
                        listKelas={listKelas}
                        handleChange={onHandleChange}
                        disabled={true}
                    />

                </div>

            </div>
            <div className="overflow-x-auto">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th scope='col' className="py-3 px-2">
                                No
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                NIS
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nama
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
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
                                <td className="py-2 px-2 font-medium text-slate-600 inline-flex space-x-3">
                                    <PrintLink
                                        label='print'
                                        href={route('print-rapor.print',
                                            {
                                                tahun: data.tahun,
                                                semester: data.semester,
                                                kelasId: data.kelasId,
                                                nis: siswa.nis
                                            })}
                                    />
                                    <DownloadLink
                                        href={route('print-rapor.download', {
                                            tahun: data.tahun,
                                            semester: data.semester,
                                            kelasId: data.kelasId,
                                            nis: siswa.nis
                                        })}
                                        label='download'
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
PrintRapor.layout = page => <AppLayout children={page} />
export default PrintRapor