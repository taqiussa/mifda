export function tanggal(tanggal) {
    return new Date(tanggal).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' })
}
