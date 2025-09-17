
# Laravel Purchase

Sistem manajemen pembelian sederhana berbasis Laravel. Mendukung pengelolaan data supplier, produk, mata uang, kurs, dan transaksi pembelian, serta laporan pembelian dengan fitur ekspor ke Excel/CSV.

## Fitur
- CRUD Supplier, Produk, Mata Uang, Kurs, dan Pembelian
- Laporan pembelian dengan konversi kurs otomatis
- Ekspor laporan ke Excel/CSV
- UI modern berbasis Tailwind CSS

## Instalasi

1. **Clone repository**
	```bash
	git clone https://github.com/darfianardiansyah/laravel-purchase.git
	cd laravel-purchase
	```

2. **Install dependency PHP**
	```bash
	composer install
	```

3. **Install dependency frontend**
	```bash
	npm install
	```

4. **Copy file environment**
	```bash
	cp .env.example .env
	```

5. **Generate app key**
	```bash
	php artisan key:generate
	```

6. **Atur koneksi database**
	- Edit file `.env` dan sesuaikan DB_DATABASE, DB_USERNAME, DB_PASSWORD

7. **Migrasi dan seed database**
	```bash
	php artisan migrate --seed
	```

8. **Build asset frontend**
	```bash
	npm run build
	# atau untuk development: npm run dev
	```

9. **Jalankan server lokal**
	```bash
	php artisan serve
	```

10. **Akses aplikasi**
	 Buka browser ke [http://localhost:8000](http://localhost:8000)

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
