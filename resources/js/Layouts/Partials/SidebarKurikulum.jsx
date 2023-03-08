import React from 'react'
import SidebarLink from '@/Components/Sia/SidebarLink'
export default function SidebarKurikulum() {
    return (
        <div className='py-1'>
            <div className='text-slate-600 font-bold'>
                Kurikulum
            </div>
            <div>
                <SidebarLink href={route('atur-guru-kelas')} active={route().current('atur-guru-kelas')} label='atur guru kelas' />
                <SidebarLink href={route('kelas')} active={route().current('kelas')} label='kelas' />
                <SidebarLink href={route('mata-pelajaran')} active={route().current('mata-pelajaran')} label='mata pelajaran' />

            </div>
        </div>
    )
}
