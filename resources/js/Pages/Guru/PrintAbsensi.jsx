import React from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Tahun from '@/Components/Sia/Tahun'
import Kelas from '@/Components/Sia/Kelas'
import PrintLink from '@/Components/Sia/PrintLink'
import Semester from '@/Components/Sia/Semester'
import Bulan from '@/Components/Sia/Bulan'

const PrintAbsensi = ({ initBulan, initTahun, initSemester, listKelas }) => {

    const { data, setData, post, processing, errors, reset } = useForm({
        bulan: initBulan,
        tahun: initTahun,
        tahunPerSemester: initTahun,
        semester: initSemester,
        kelasId: '',
        kelasIdPerSemester: '',
    })

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    return (
        <>
            <Head title='Print Absensi' />
            <div className='space-y-10 mt-10'>

                <div className="lg:grid lg:grid-cols-7 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2">
                    <Bulan
                        id="bulan"
                        name="bulan"
                        value={data.bulan}
                        message={errors.bulan}
                        isFocused={true}
                        handleChange={onHandleChange}
                    />

                    <Tahun
                        id="tahun"
                        name="tahun"
                        value={data.tahun}
                        message={errors.tahun}
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
                    />

                    <div className=' flex flex-col justify-end'>
                        {/* 👇️ open link in new tab */}
                        <PrintLink
                            label='per bulan'
                            href={route('print-absensi.print-per-bulan',
                                {
                                    bulan: data.bulan,
                                    tahun: data.tahun,
                                    kelasId: data.kelasId
                                })}
                        />
                    </div>
                </div>

                <div className="lg:grid lg:grid-cols-7 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2">

                    <Tahun
                        id="tahunPerSemester"
                        name="tahunPerSemester"
                        value={data.tahunPerSemester}
                        message={errors.tahunPerSemester}
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
                        id="kelasIdPerSemester"
                        name="kelasIdPerSemester"
                        value={data.kelasIdPerSemester}
                        message={errors.kelasIdPerSemester}
                        isFocused={true}
                        listKelas={listKelas}
                        handleChange={onHandleChange}
                    />

                    <div className=' flex flex-col justify-end'>
                        {/* 👇️ open link in new tab */}
                        <PrintLink
                            label='per semester'
                            href={route('print-absensi.print-per-semester', {
                                tahun: data.tahunPerSemester,
                                semester: data.semester,
                                kelasId: data.kelasIdPerSemester
                            })}
                        />
                    </div>
                </div>

            </div>
        </>
    )
}
PrintAbsensi.layout = page => <AppLayout children={page} />
export default PrintAbsensi