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
                <SidebarLink href={route('print-absensi')} active={route().current('print-absensi')} label='print absensi' />
            </div>
        </div>
    )
}
