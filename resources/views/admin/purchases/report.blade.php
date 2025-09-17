<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Laporan Pembelian</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-8 lg:px-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-xl sm:rounded-lg">
                    <div class="flex justify-end m-4">
                        <button id="btnDownloadExcel"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition">Download
                            Excel</button>
                    </div>
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

        let lastData = [];
        async function loadData() {
            let res = await fetch(apiUrl);
            let data = await res.json();
            lastData = data;

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

        document.getElementById("btnDownloadExcel").addEventListener("click", function() {
            if (!lastData.length) return;
            // SheetJS (XLSX) export
            if (window.XLSX) {
                let ws_data = [
                    ['No', 'Tanggal', 'Nama Supplier', 'Alamat Supplier', 'Produk', 'Jumlah',
                        'Total Harga (Rp)']
                ];
                lastData.forEach((p, i) => {
                    ws_data.push([
                        i + 1,
                        formatDate(p.date),
                        p.supplier,
                        p.address,
                        p.product,
                        p.qty,
                        p.total_price_idr == 0 ? '' : formatNumber(p.total_price_idr)
                    ]);
                });
                let ws = XLSX.utils.aoa_to_sheet(ws_data);
                let wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Report");
                XLSX.writeFile(wb, "laporan_pembelian.xlsx");
            } else {
                // fallback CSV
                let csv = 'No,Tanggal,Nama Supplier,Alamat Supplier,Produk,Jumlah,Total Harga (Rp)\n';
                lastData.forEach((p, i) => {
                    csv +=
                        `${i+1},"${formatDate(p.date)}","${p.supplier}","${p.address}","${p.product}",${p.qty},${p.total_price_idr == 0 ? '' : formatNumber(p.total_price_idr)}\n`;
                });
                let blob = new Blob([csv], {
                    type: 'text/csv'
                });
                let url = URL.createObjectURL(blob);
                let a = document.createElement('a');
                a.href = url;
                a.download = 'laporan_pembelian.csv';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }
        });

        if (!window.XLSX) {
            var script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js';
            document.head.appendChild(script);
        }

        function formatDate(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            return d.toLocaleDateString('id-ID');
        }

        function formatNumber(num) {
            return Number(num).toLocaleString('id-ID', {
                minimumFractionDigits: 2
            });
        }
    </script>
</x-app-layout>
