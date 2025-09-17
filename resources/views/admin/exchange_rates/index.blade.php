<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Daftar Kurs</h2>
    </x-slot>

    <div class="p-6">
        <x-primary-button id="btnAdd">Tambah Kurs</x-primary-button>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-8 lg:px-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-xl sm:rounded-lg">
                    <table id="tableProducts" class="w-full border text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-2 border">No</th>
                                <th class="px-2 py-2 border">Kode</th>
                                <th class="px-2 py-2 border">Tanggal</th>
                                <th class="px-2 py-2 border">Kurs</th>
                                <th class="px-2 py-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- Modal Form -->
                <div id="modalForm"
                    class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
                    <div class="bg-white p-6 rounded-lg shadow w-full max-w-md">
                        <h3 id="modalTitle" class="text-lg font-semibold mb-4">Tambah Kurs</h3>

                        <form id="formProduct" class="space-y-4">
                            <input type="hidden" id="product_id">

                            <div>
                                <x-input-label for="currency_id" :value="__('Kode')" />
                                <x-text-input id="currency_id" type="text" class="mt-1 block w-full" />
                            </div>

                            <div>
                                <x-input-label for="date" :value="__('Tanggal')" />
                                <x-text-input id="date" type="date" class="mt-1 block w-full" />
                            </div>

                            <div>
                                <x-input-label for="rate" :value="__('Kurs')" />
                                <x-text-input id="rate" type="text" class="mt-1 block w-full" />
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
        const apiUrl = "/api/exchange-rates";
        document.addEventListener("DOMContentLoaded", () => loadData());

        async function loadData() {
            let res = await fetch(apiUrl);
            let data = await res.json();

            let tbody = document.querySelector("#tableProducts tbody");
            tbody.innerHTML = "";
            data.forEach((p, i) => {
                tbody.innerHTML += `
                    <tr>
                        <td class="border px-2 text-center align-middle">${i+1}</td>
                        <td class="border px-2">${p.currency.code}</td>
                        <td class="border px-2">${p.date}</td>
                        <td class="border px-2">${p.rate}</td>
                        <td class="border px-2 text-center align-middle">
                            <button onclick="editData(${p.id})" class="text-indigo-600 border border-indigo-500 hover:bg-indigo-50 px-3 py-1 rounded">Edit</button>
                            <button onclick="deleteData(${p.id})" class="text-red-600 border border-red-500 hover:bg-red-50 px-3 py-1 rounded">Hapus</button>
                        </td>
                    </tr>`;
            });
        }

        document.getElementById("btnAdd").addEventListener("click", () => {
            document.getElementById("formProduct").reset();
            document.getElementById("product_id").value = "";
            document.getElementById("modalTitle").innerText = "Tambah Kurs";
            document.getElementById("modalForm").classList.remove("hidden");
        });

        function closeModal() {
            document.getElementById("modalForm").classList.add("hidden");
        }

        document.getElementById("formProduct").addEventListener("submit", async (e) => {
            e.preventDefault();
            let id = document.getElementById("product_id").value;
            let payload = {
                code: document.getElementById("code").value,
                name: document.getElementById("name").value,
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

            document.getElementById("product_id").value = p.id;
            document.getElementById("currency_id").value = p.currency_id;
            document.getElementById("date").value = p.date;
            document.getElementById("rate").value = p.rate;

            document.getElementById("modalTitle").innerText = "Edit Kurs";
            document.getElementById("modalForm").classList.remove("hidden");
        }

        async function deleteData(id) {
            if (!confirm("Yakin hapus Kurs?")) return;
            let res = await fetch(`${apiUrl}/${id}`, { method: "DELETE" });
            if (res.ok) loadData();
        }
    </script>
</x-app-layout>
