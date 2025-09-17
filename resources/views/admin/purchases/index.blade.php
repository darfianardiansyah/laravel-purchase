<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Daftar Pembelian</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-8 lg:px-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-xl sm:rounded-lg">
                    <div class="flex justify-end p-4">
                        <x-primary-button id="btnAdd">Tambah Pembelian</x-primary-button>
                    </div>
                    <table id="tablePurchases" class="w-full border text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-2 border text-center">No</th>
                                <th class="px-2 py-2 border">Tanggal</th>
                                <th class="px-2 py-2 border">Nama Supplier</th>
                                <th class="px-2 py-2 border">Alamat Supplier</th>
                                <th class="px-2 py-2 border">Mata Uang</th>
                                <th class="px-2 py-2 border">Produk</th>
                                <th class="px-2 py-2 border">Jumlah</th>
                                <th class="px-2 py-2 border">Total Harga</th>
                                <th class="px-2 py-2 border text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <!-- Modal Form -->
                <div id="modalForm" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white p-6 rounded-lg shadow w-full max-w-lg">
                        <h3 id="modalTitle" class="text-lg font-semibold mb-4">Tambah Pembelian</h3>
                        <form id="formPurchase" class="space-y-4">
                            <input type="hidden" id="purchase_id">
                            <div>
                                <x-input-label for="date" :value="__('Tanggal')" />
                                <x-text-input id="date" type="date" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="supplier_id" :value="__('Supplier')" />
                                <select id="supplier_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></select>
                            </div>
                            <div>
                                <x-input-label for="currency_id" :value="__('Mata Uang')" />
                                <select id="currency_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></select>
                            </div>
                            <div>
                                <x-input-label for="product_id" :value="__('Produk')" />
                                <select id="product_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></select>
                            </div>
                            <div>
                                <x-input-label for="qty" :value="__('Jumlah')" />
                                <x-text-input id="qty" type="number" min="1" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="total_price" :value="__('Total Harga')" />
                                <x-text-input id="total_price" type="number" min="0" step="0.01" class="mt-1 block w-full" />
                            </div>
                            <div class="flex justify-end space-x-2">
                                <x-secondary-button type="button" onclick="closeModal()">Batal</x-secondary-button>
                                <x-primary-button>Simpan</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const apiUrl = "/api/purchases";
        document.addEventListener("DOMContentLoaded", () => {
            loadData();
            loadSuppliers();
            loadCurrencies();
            loadProducts();
        });

        async function loadData() {
            let res = await fetch(apiUrl);
            let data = await res.json();

            let tbody = document.querySelector("#tablePurchases tbody");
            tbody.innerHTML = "";
            data.forEach((p, i) => {
                tbody.innerHTML += `
                    <tr>
                        <td class="border px-2 text-center align-middle">${i+1}</td>
                        <td class="border px-2">${formatDate(p.date)}</td>
                        <td class="border px-2">${p.supplier?.name ?? ''}</td>
                        <td class="border px-2">${p.supplier?.address ?? ''}</td>
                        <td class="border px-2">${p.currency?.code ?? ''}</td>
                        <td class="border px-2">${p.product?.name ?? ''}</td>
                        <td class="border px-2 text-right">${p.qty}</td>
                        <td class="border px-2 text-right">${formatNumber(p.total_price)}</td>
                        <td class="border px-2 text-center align-middle">
                            <button onclick="editData(${p.id})" class="text-indigo-600 border border-indigo-500 hover:bg-indigo-50 px-3 py-1 rounded">Edit</button>
                            <button onclick="deleteData(${p.id})" class="text-red-600 border border-red-500 hover:bg-red-50 px-3 py-1 rounded">Hapus</button>
                        </td>
                    </tr>`;
            });
        }

        async function loadSuppliers(selectedId = null) {
            let res = await fetch("/api/suppliers");
            let suppliers = await res.json();
            let select = document.getElementById("supplier_id");
            if (!select) return;
            select.innerHTML = '<option value="">-- Pilih Supplier --</option>';
            suppliers.forEach(s => {
                let opt = document.createElement("option");
                opt.value = s.id;
                opt.textContent = s.name;
                if (selectedId && selectedId == s.id) opt.selected = true;
                select.appendChild(opt);
            });
        }
        async function loadCurrencies(selectedId = null) {
            let res = await fetch("/api/currencies");
            let currencies = await res.json();
            let select = document.getElementById("currency_id");
            if (!select) return;
            select.innerHTML = '<option value="">-- Pilih Mata Uang --</option>';
            currencies.forEach(c => {
                let opt = document.createElement("option");
                opt.value = c.id;
                opt.textContent = c.code;
                if (selectedId && selectedId == c.id) opt.selected = true;
                select.appendChild(opt);
            });
        }
        async function loadProducts(selectedId = null) {
            let res = await fetch("/api/products");
            let products = await res.json();
            let select = document.getElementById("product_id");
            if (!select) return;
            select.innerHTML = '<option value="">-- Pilih Produk --</option>';
            products.forEach(p => {
                let opt = document.createElement("option");
                opt.value = p.id;
                opt.textContent = p.name;
                if (selectedId && selectedId == p.id) opt.selected = true;
                select.appendChild(opt);
            });
        }

        document.getElementById("btnAdd").addEventListener("click", () => {
            document.getElementById("formPurchase").reset();
            document.getElementById("purchase_id").value = "";
            document.getElementById("modalTitle").innerText = "Tambah Pembelian";
            loadSuppliers();
            loadCurrencies();
            loadProducts();
            document.getElementById("modalForm").classList.remove("hidden");
        });

        function closeModal() {
            document.getElementById("modalForm").classList.add("hidden");
        }

        document.getElementById("formPurchase").addEventListener("submit", async (e) => {
            e.preventDefault();
            let id = document.getElementById("purchase_id").value;
            let payload = {
                date: document.getElementById("date").value,
                supplier_id: document.getElementById("supplier_id").value,
                currency_id: document.getElementById("currency_id").value,
                product_id: document.getElementById("product_id").value,
                qty: document.getElementById("qty").value,
                total_price: document.getElementById("total_price").value,
            };

            let res = await fetch(id ? `${apiUrl}/${id}` : apiUrl, {
                method: id ? "PUT" : "POST",
                headers: { "Content-Type": "application/json", "Accept": "application/json" },
                body: JSON.stringify(payload),
            });

            if (res.ok) {
                closeModal();
                loadData();
            } else {
                alert("Gagal simpan data");
            }
        });

        async function editData(id) {
            let res = await fetch(`${apiUrl}/${id}`);
            let p = await res.json();

            document.getElementById("purchase_id").value = p.id;
            document.getElementById("date").value = p.date;
            await loadSuppliers(p.supplier_id);
            await loadCurrencies(p.currency_id);
            await loadProducts(p.product_id);
            document.getElementById("qty").value = p.qty;
            document.getElementById("total_price").value = p.total_price;

            document.getElementById("modalTitle").innerText = "Edit Pembelian";
            document.getElementById("modalForm").classList.remove("hidden");
        }

        async function deleteData(id) {
            if (!confirm("Yakin hapus pembelian?")) return;
            let res = await fetch(`${apiUrl}/${id}`, { method: "DELETE" });
            if (res.ok) loadData();
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
