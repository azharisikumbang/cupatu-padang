@php
    $listBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
@endphp
<x-manager-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Laporan Pendapatan Bulanan - Tahun ') . ($_GET['tahun'] ?? date('Y')) }}
        </h2>
    </x-slot>

    <div class="p-8  bg-white shadow sm:rounded-lg">
        <div class="mb-4 flex justify-end">
            <form method="get" class="flex gap-2 items-center" id="filter">
                <select onchange="filterByYear(this)" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm text-gray-600 cursor-pointer">
                <?php for ($tahun = date('Y'); $tahun >= 2023; $tahun--): ?>
                    <option value="{{ $tahun }}" {{ isset($_GET['tahun']) ? ($_GET['tahun'] == $tahun ? 'selected' : '') : '' }}>Tahun {{ $tahun }}</option>
                <?php endfor; ?>
                </select>
            </form>
        </div>

        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-12 text-center border">No</th>
                        <th scope="col" class="px-6 py-3 text-center w-96 border">Bulan</th>
                        <th scope="col" class="px-6 py-3 text-center border">Total Pendapatan*</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp

                    @forelse($data as $report)
                        @php
                            $total += $report->pemasukan;
                        @endphp
                        <tr class="border-b">
                            <td class="text-center px-6 py-3 border">{{ $loop->iteration }}</td>
                            <td class="text-center px-6 py-3 border">{{ $listBulan[$report->bulan - 1] }}</td>
                            <td class="text-center px-6 py-3 border">Rp {{ number_format($report->pemasukan, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 px-6 border">Tidak ada data.</td>
                        </tr>
                    @endforelse                    
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-center px-6 py-3 border bg-gray-100 font-bold">Total {{ count($data) }} bulan</td>
                        <td class="text-center px-6 py-3 border">Rp {{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-4 text-sm italic text-gray-400">
            <strong>Catatan: *Pendapatan adalah dihitung dari total pemesanan yang telah berhasil diselesaikan.</strong>
        </div>
        
    </div>
</x-manager-layout>

<script>
    function filterByYear(event) {
        const parser = new URL(window.location);
        parser.searchParams.set('tahun', event.value);
        window.location = parser.href;
    }
</script>

