import React from 'react'
import SidebarLink from '@/Components/Sia/SidebarLink'
export default function SidebarGuru() {
    return (
        <div className='py-1'>
            <div className='text-slate-600 font-bold'>
                Guru
            </div>
            <div>
                <SidebarLink href={route('dashboard')} active={route().current('dashboard')} label='dashboard' />
                <SidebarLink href={route('absensi')} active={route().current('absensi')} label='absensi' />
                <SidebarLink href={route('input-kd')} active={route().current('input-kd')} label='input KD / TP' />
                <SidebarLink href={route('input-nilai')} active={route().current('input-nilai')} label='input nilai' />
                <SidebarLink href={route('input-nilai-ekstrakurikuler')} active={route().current('input-nilai-ekstrakurikuler')} label='input nilai ekstrakurikuler' />
                <SidebarLink href={route('input-nilai-sikap')} active={route().current('input-nilai-sikap')} label='input nilai sikap' />
                <SidebarLink href={route('print-absensi')} active={route().current('print-absensi')} label='print absensi' />
                <SidebarLink href={route('upload-nilai')} active={route().current('upload-nilai')} label='upload nilai' />
                <SidebarLink href={route('upload-nilai-sikap')} active={route().current('upload-nilai-sikap')} label='upload nilai sikap' />
            </div>
            <div className='text-slate-600 font-bold mt-2'>
                Wali Kelas
            </div>
            <div>
                <SidebarLink href={route('input-catatan')} active={route().current('input-catatan')} label='input catatan' />
                <SidebarLink href={route('print-rapor')} active={route().current('print-rapor')} label='print rapor' />
            </div>
        </div>
    )
}
