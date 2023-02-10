export function hariTanggal(tanggal) {
    return new Date(tanggal).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
}
