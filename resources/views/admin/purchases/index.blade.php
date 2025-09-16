<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Daftar Supplier</h2>
    </x-slot>

    <div class="p-6">
        <!-- Tombol Tambah -->
        <button id="btnAdd" class="px-4 py-2 bg-blue-600 text-white rounded">Tambah Supplier</button>

        <!-- Table -->
        <table id="tableSuppliers" class="w-full mt-4 border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-2 py-1 border">No</th>
                    <th class="px-2 py-1 border">Nama</th>
                    <th class="px-2 py-1 border">Alamat</th>
                    <th class="px-2 py-1 border">Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Modal Form -->
    <div id="modalForm" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded w-1/3">
            <h3 id="modalTitle" class="text-lg font-bold mb-3">Tambah Supplier</h3>
            <form id="formSupplier">
                <input type="hidden" id="supplier_id">
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" id="nama" class="border w-full px-2 py-1">
                </div>
                <div class="mb-3">
                    <label>Alamat</label>
                    <input type="text" id="alamat" class="border w-full px-2 py-1">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-500 text-white">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white">Simpan</button>
                </div>
            </form>
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
                        <td class="border px-2">${i+1}</td>
                        <td class="border px-2">${s.nama}</td>
                        <td class="border px-2">${s.alamat}</td>
                        <td class="border px-2 space-x-1">
                            <button onclick="editData(${s.id})" class="bg-yellow-500 text-white px-2">Edit</button>
                            <button onclick="deleteData(${s.id})" class="bg-red-500 text-white px-2">Hapus</button>
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
                nama: document.getElementById("nama").value,
                alamat: document.getElementById("alamat").value,
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

        // edit data
        async function editData(id) {
            let res = await fetch(`${apiUrl}/${id}`);
            let s = await res.json();

            document.getElementById("supplier_id").value = s.id;
            document.getElementById("nama").value = s.nama;
            document.getElementById("alamat").value = s.alamat;

            document.getElementById("modalTitle").innerText = "Edit Supplier";
            document.getElementById("modalForm").classList.remove("hidden");
        }

        // hapus data
        async function deleteData(id) {
            if (!confirm("Yakin hapus supplier?")) return;
            let res = await fetch(`${apiUrl}/${id}`, { method: "DELETE" });
            if (res.ok) loadData();
        }
    </script>
</x-app-layout>
