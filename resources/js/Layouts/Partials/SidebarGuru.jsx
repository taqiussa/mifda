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
                <SidebarLink href={route('input-nilai')} active={route().current('input-nilai')} label='input nilai' />
                <SidebarLink href={route('input-nilai-sikap')} active={route().current('input-nilai-sikap')} label='input nilai sikap' />
                <SidebarLink href={route('print-absensi')} active={route().current('print-absensi')} label='print absensi' />
                <SidebarLink href={route('upload-nilai')} active={route().current('upload-nilai')} label='upload nilai' />

            </div>
        </div>
    )
}
