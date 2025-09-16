<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Daftar Supplier</h2>
    </x-slot>

    <div class="p-6">
        <!-- Tombol Tambah -->
        <x-primary-button id="btnAdd">Tambah Supplier</x-primary-button>

    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-8 lg:px-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Table -->
                <div class="relative overflow-x-auto shadow-xl sm:rounded-lg">
                    <table id="tableSuppliers" class="w-full border text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-2 border">No</th>
                                <th class="px-2 py-2 border">Nama</th>
                                <th class="px-2 py-2 border">Alamat</th>
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
                        <h3 id="modalTitle" class="text-lg font-semibold mb-4">Tambah Supplier</h3>

                        <form id="formSupplier" class="space-y-4">
                            <input type="hidden" id="supplier_id">

                            <!-- Nama -->
                            <div>
                                <x-input-label for="nama" :value="__('Nama')" />
                                <x-text-input id="nama" type="text" class="mt-1 block w-full" />
                                <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                            </div>

                            <!-- Alamat -->
                            <div>
                                <x-input-label for="alamat" :value="__('Alamat')" />
                                <x-text-input id="alamat" type="text" class="mt-1 block w-full" />
                                <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                            </div>

                            <!-- Tombol -->
                            <div class="flex justify-end space-x-2">
                                <x-secondary-button type="button" onclick="closeModal()">
                                    {{ __('Batal') }}
                                </x-secondary-button>
                                <x-primary-button>
                                    {{ __('Simpan') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>




    <script>
        const apiUrl = "/api/suppliers";

        document.addEventListener("DOMContentLoaded", () => loadData());

        async function loadData() {
            let res = await fetch(apiUrl);
            let data = await res.json();

            let tbody = document.querySelector("#tableSuppliers tbody");
            tbody.innerHTML = "";
            data.forEach((s, i) => {
                tbody.innerHTML += `
                        <tr>
                            <td class="border px-2 text-center align-middle">${i+1}</td>
                            <td class="border px-2">${s.name}</td>
                            <td class="border px-2">${s.address}</td>
                            <td class="border px-2">
                                <button onclick="editData(${s.id})"
                                    class="text-indigo-600 border border-indigo-500 hover:bg-indigo-50 font-medium px-3 py-1 rounded transition">
                                    Edit
                                </button>
                                <button onclick="deleteData(${s.id})"
                                    class="text-red-600 border border-red-500 hover:bg-red-50 font-medium px-3 py-1 rounded transition">
                                    Hapus
                                </button>
                            </td>
                        </tr>`;
            });
        }

        // buka modal tambah
        document.getElementById("btnAdd").addEventListener("click", () => {
            document.getElementById("formSupplier").reset();
            document.getElementById("supplier_id").value = "";
            document.getElementById("modalTitle").innerText = "Tambah Supplier";
            document.getElementById("modalForm").classList.remove("hidden");
        });

        function closeModal() {
            document.getElementById("modalForm").classList.add("hidden");
        }

        // submit form
        document.getElementById("formSupplier").addEventListener("submit", async (e) => {
            e.preventDefault();
            let id = document.getElementById("supplier_id").value;
            let payload = {
                name: document.getElementById("nama").value,
                address: document.getElementById("alamat").value,
            };

            let res = await fetch(id ? `${apiUrl}/${id}` : apiUrl, {
                method: id ? "PUT" : "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify(payload),
            });

            if (res.ok) {
                closeModal();
                loadData();
            } else {
                alert("Gagal simpan data");
            }
        });

        // edit data
        async function editData(id) {
            let res = await fetch(`${apiUrl}/${id}`);
            let s = await res.json();

            document.getElementById("supplier_id").value = s.id;
            document.getElementById("nama").value = s.name;
            document.getElementById("alamat").value = s.address;

            document.getElementById("modalTitle").innerText = "Edit Supplier";
            document.getElementById("modalForm").classList.remove("hidden");
        }

        // hapus data
        async function deleteData(id) {
            if (!confirm("Yakin hapus supplier?")) return;
            let res = await fetch(`${apiUrl}/${id}`, {
                method: "DELETE"
            });
            if (res.ok) loadData();
        }
    </script>
</x-app-layout>
