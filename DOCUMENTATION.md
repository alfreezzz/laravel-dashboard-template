# Dokumentasi Aplikasi Penjualan

Aplikasi ini adalah sistem manajemen penjualan dengan tiga modul utama:

## 📋 Modul-Modul

### 1. Master Kategori

**Lokasi:** `/categories`

**Fitur:**

- ✅ **Read** - Melihat daftar semua kategori
- ✅ **Create** - Menambah kategori baru
- ✅ **Update** - Mengedit kategori yang ada
- ✅ **Delete** - Menghapus kategori

**Database:** Tabel `categories`

- `id` - ID kategori
- `name` - Nama kategori
- `slug` - Slug otomatis dari nama
- `description` - Deskripsi kategori
- `timestamps` - Created/Updated at

---

### 2. Master Barang

**Lokasi:** `/items`

**Fitur:**

- ✅ **Read** - Melihat daftar semua barang
- ✅ **Create** - Menambah barang baru
- ✅ **Update** - Mengedit barang
- ✅ **Delete** - Menghapus barang

**Database:** Tabel `items`

- `id` - ID barang
- `code` - Kode barang (unique)
- `name` - Nama barang
- `category_id` - Foreign key ke kategori
- `buying_price` - Harga pembelian
- `selling_price` - Harga penjualan
- `unit` - Satuan barang (Pcs, Kg, Liter, dll)
- `timestamps` - Created/Updated at

---

### 3. Data Penjualan

**Lokasi:** `/transactions`

**Fitur:**

- ✅ **Read** - Melihat daftar penjualan
- ✅ **Create** - Mencatat penjualan baru
- ❌ **Update** - Tidak tersedia
- ❌ **Delete** - Tidak tersedia

**Database:** Tabel `transactions`

- `id` - ID transaksi
- `consumer_name` - Nama pembeli
- `item_code` - Foreign key ke kode barang
- `quantity` - Jumlah barang yang dijual
- `unit_price` - Harga per unit saat penjualan
- `total_price` - Total = quantity × unit_price
- `timestamps` - Created/Updated at

---

## 🗂️ Struktur File

```
app/Http/Controllers/
├── CategoryController.php      # Controller untuk kategori
├── ItemController.php          # Controller untuk barang
└── TransactionController.php   # Controller untuk penjualan

resources/views/
├── welcome.blade.php           # Dashboard utama
├── categories/
│   ├── index.blade.php         # Daftar kategori
│   ├── create.blade.php        # Form tambah kategori
│   └── edit.blade.php          # Form edit kategori
├── items/
│   ├── index.blade.php         # Daftar barang
│   ├── create.blade.php        # Form tambah barang
│   └── edit.blade.php          # Form edit barang
└── transactions/
    ├── index.blade.php         # Daftar penjualan
    └── create.blade.php        # Form input penjualan
```

---

## 🚀 Route

| Method | Endpoint                | Fungsi                |
| ------ | ----------------------- | --------------------- |
| GET    | `/`                     | Dashboard utama       |
| GET    | `/categories`           | Daftar kategori       |
| GET    | `/categories/create`    | Form tambah kategori  |
| POST   | `/categories`           | Simpan kategori baru  |
| GET    | `/categories/{id}/edit` | Form edit kategori    |
| PUT    | `/categories/{id}`      | Update kategori       |
| DELETE | `/categories/{id}`      | Hapus kategori        |
| GET    | `/items`                | Daftar barang         |
| GET    | `/items/create`         | Form tambah barang    |
| POST   | `/items`                | Simpan barang baru    |
| GET    | `/items/{id}/edit`      | Form edit barang      |
| PUT    | `/items/{id}`           | Update barang         |
| DELETE | `/items/{id}`           | Hapus barang          |
| GET    | `/transactions`         | Daftar penjualan      |
| GET    | `/transactions/create`  | Form input penjualan  |
| POST   | `/transactions`         | Simpan penjualan baru |

---

## 📦 Dependencies

- **Laravel 11** (atau versi sesuai project)
- **Bootstrap 5.3** (via CDN)
- **MySQL** (database)

---

## 🎨 UI/UX

Semua halaman menggunakan Bootstrap 5.3 dengan fitur:

- Responsive design
- Alert notifications
- Form validation
- Table dengan hover effects
- Clean dan user-friendly interface

---

## 💡 Catatan

- Kategori otomatis menghasilkan slug dari nama
- Harga barang menggunakan integer (dalam rupiah)
- Total penjualan otomatis dihitung saat insert
- Validasi dilakukan di server-side
- Support untuk soft delete pada kategori dan barang

---

**Dibuat pada:** 26 Januari 2026
**Versi:** 1.0.0
