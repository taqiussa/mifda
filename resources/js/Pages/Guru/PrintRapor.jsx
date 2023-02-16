import React, { useEffect } from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Tahun from '@/Components/Sia/Tahun'
import Kelas from '@/Components/Sia/Kelas'
import PrintLink from '@/Components/Sia/PrintLink'
import Semester from '@/Components/Sia/Semester'
import getKelasWali from '@/Functions/getKelasWali'
import { trackPromise } from 'react-promise-tracker'

const PrintRapor = ({ initTahun, initSemester, listKelas, initKelasId }) => {

    const { data, setData, post, processing, errors, reset } = useForm({
        tahun: initTahun,
        semester: initSemester,
        kelasId: initKelasId,
    })



    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    async function getDataKelasWali() {
        const response = await getKelasWali(data.tahun)
        setData({ kelasId: response.kelasId })
    }

    useEffect(() => {

        if (data.tahun) {

            trackPromise(
                getDataKelasWali()
            )

        }
    }, [data.tahun])

    return (
        <>
            <Head title='Print Kehadiran' />
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
                        disable={true}
                    />

                    <div className=' flex flex-col justify-end'>
                        {/* 👇️ open link in new tab */}
                        <PrintLink
                            label='print'
                            href={route('print-absensi.print-per-bulan',
                                {
                                    bulan: data.bulan,
                                    tahun: data.tahun,
                                    kelasId: data.kelasId
                                })}
                        />

                    </div>
                </div>

            </div>
        </>
    )
}
PrintRapor.layout = page => <AppLayout children={page} title="Print Kehadiran" />
export default PrintRapor