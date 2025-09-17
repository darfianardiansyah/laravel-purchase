<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Laporan Pembelian</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-8 lg:px-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-xl sm:rounded-lg">
                    <table id="tableReport" class="w-full border text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-2 border text-center">No</th>
                                <th class="px-2 py-2 border">Tanggal</th>
                                <th class="px-2 py-2 border">Nama Supplier</th>
                                <th class="px-2 py-2 border">Alamat Supplier</th>
                                <th class="px-2 py-2 border">Produk</th>
                                <th class="px-2 py-2 border text-center">Jumlah</th>
                                <th class="px-2 py-2 border text-right">Total Harga (Rp)</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const apiUrl = "/api/purchases/report";
        document.addEventListener("DOMContentLoaded", () => loadData());

        async function loadData() {
            let res = await fetch(apiUrl);
            let data = await res.json();

            let tbody = document.querySelector("#tableReport tbody");
            tbody.innerHTML = "";
            data.forEach((p, i) => {
                tbody.innerHTML += `
                    <tr>
                        <td class="border px-2 text-center align-middle">${i+1}</td>
                        <td class="border px-2">${formatDate(p.date)}</td>
                        <td class="border px-2">${p.supplier}</td>
                        <td class="border px-2">${p.address}</td>
                        <td class="border px-2">${p.product}</td>
                        <td class="border px-2 text-center">${p.qty}</td>
                        <td class="border px-2 text-right">${p.total_price_idr == 0 ? '' : formatNumber(p.total_price_idr)}</td>
                    </tr>`;
            });
        }

        function formatDate(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            return d.toLocaleDateString('id-ID');
        }
        function formatNumber(num) {
            return Number(num).toLocaleString('id-ID', { minimumFractionDigits: 2 });
        }
    </script>
</x-app-layout>
