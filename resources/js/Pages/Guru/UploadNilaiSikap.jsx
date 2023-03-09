import React, { useState, useEffect } from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Tahun from '@/Components/Sia/Tahun'
import Kelas from '@/Components/Sia/Kelas'
import { toast } from 'react-toastify';
import { trackPromise } from 'react-promise-tracker'
import Semester from '@/Components/Sia/Semester'
import MataPelajaran from '@/Components/Sia/MataPelajaran'
import KategoriSikap from '@/Components/Sia/KategoriSikap'
import JenisSikap from '@/Components/Sia/JenisSikap'
import getKelas from '@/Functions/getKelas'
import getJenisSikap from '@/Functions/getJenisSikap'
import getNilaiSikap from '@/Functions/getNilaiSikap'
import DownloadLink from '@/Components/Sia/DownloadLink'
import FileUpload from '@/Components/Sia/FileUpload'
import PrimaryButton from '@/Components/Breeze/PrimaryButton'
import getMataPelajaran from '@/Functions/getMataPelajaran'

const UploadNilaiSikap = ({ initTahun, initSemester, listKategori }) => {

    const { data, setData, post, processing, errors } = useForm({
        tahun: initTahun,
        semester: initSemester,
        mataPelajaranId: '',
        kelasId: '',
        kategoriSikapId: '',
        jenisSikapId: '',
        fileImport: '',
    })

    const [listJenis, setListJenis] = useState([])
    const [listKelas, setListKelas] = useState([])
    const [listMataPelajaran, setListMataPelajaran] = useState([])
    const [listSiswa, setListSiswa] = useState([])

    async function getDataMataPelajaran() {
        const response = await getMataPelajaran(data.tahun)
        setListMataPelajaran(response.listMataPelajaran)
    }

    async function getDataNilaiSikap() {
        const response = await getNilaiSikap(data.tahun, data.semester, data.mataPelajaranId, data.kelasId, data.kategoriSikapId, data.jenisSikapId)
        setListSiswa(response.listSiswa)
    }

    async function getDataJenisSikap() {
        const response = await getJenisSikap(data.tahun, data.semester, data.kelasId, data.kategoriSikapId)
        setListJenis(response.listJenis)
    }

    async function getDataKelas() {
        const response = await getKelas(data.tahun, data.mataPelajaranId)
        setListKelas(response.listKelas)
    }

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.type === 'file' ? event.target.files[0] : event.target.value);
    }

    const submit = (e) => {
        e.preventDefault()
        post(route('upload-nilai-sikap.import'), {
            onSuccess: (page) => {
                toast.success('Berhasil Upload Nilai Sikap')
                setData({
                    tahun: data.tahun,
                    semester: data.semester,
                    mataPelajaranId: data.mataPelajaranId,
                    kelasId: data.kelasId,
                    kategoriSikapId: data.kategoriSikapId,
                    jenisSikapId: data.jenisSikapId,
                    fileImport: ''
                })
                getDataNilaiSikap()
            },
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
        ) {

            trackPromise(
                getDataKelas()
            )

        }
    }, [data.tahun, data.mataPelajaranId])

    useEffect(() => {

        if (data.tahun
            && data.semester
            && data.kelasId
            && data.kategoriSikapId
        ) {
            trackPromise(
                getDataJenisSikap()
            )

        }
        return () => {
        }
    }, [data.tahun, data.semester, data.kelasId, data.kategoriSikapId])

    useEffect(() => {

        if (data.tahun
            && data.semester
            && data.mataPelajaranId
            && data.kelasId
            && data.kategoriSikapId
            && data.jenisSikapId
        ) {
            trackPromise(
                getDataNilaiSikap()
            )

        } else {
            setListSiswa([])
        }
        return () => {
        }
    }, [data.tahun, data.semester, data.mataPelajaranId, data.kelasId, data.kategoriSikapId, data.jenisSikapId])

    return (
        <>
            <Head title='Upload Nilai Sikap' />
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

                    <Semester
                        id="semester"
                        name="semester"
                        value={data.semester}
                        message={errors.semester}
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

                    <Kelas
                        id="kelasId"
                        name="kelasId"
                        value={data.kelasId}
                        message={errors.kelasId}
                        isFocused={true}
                        listKelas={listKelas}
                        handleChange={onHandleChange}
                    />

                    <KategoriSikap
                        id="kategoriSikapId"
                        name="kategoriSikapId"
                        value={data.kategoriSikapId}
                        message={errors.kategoriSikapId}
                        listKategori={listKategori}
                        isFocused={true}
                        handleChange={onHandleChange}
                    />

                    <JenisSikap
                        id="jenisSikapId"
                        name="jenisSikapId"
                        value={data.jenisSikapId}
                        message={errors.jenisSikapId}
                        listJenis={listJenis}
                        isFocused={true}
                        handleChange={onHandleChange}
                    />

                </div>

                <DownloadLink
                    href={route('upload-nilai-sikap.export', {
                        tahun: data.tahun,
                        semester: data.semester,
                        mataPelajaranId: data.mataPelajaranId,
                        kategoriSikapId: data.kategoriSikapId,
                        jenisSikapId: data.jenisSikapId,
                        kelasId: data.kelasId,
                    })}
                    label='download draft'
                />

                <div className='flex flex-row space-x-3'>

                    <FileUpload
                        id="fileImport"
                        name="fileImport"
                        message={errors.fileImport}
                        isFocused={true}
                        handleChange={onHandleChange}
                    />

                    <div className='flex flex-col'>
                        <div>
                            &nbsp;
                        </div>
                        <div>
                            <PrimaryButton onClick={submit} processing={processing}>Upload</PrimaryButton>
                        </div>
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
                                Nis
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nama
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nilai
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
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.nilai_sikap.nilai ?? ''}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}
UploadNilaiSikap.layout = page => <AppLayout children={page} />
export default UploadNilaiSikap