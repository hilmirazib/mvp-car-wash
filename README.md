# 🚗 Car Wash On-Demand Platform – Database Design

## 📌 Overview

Database ini dirancang untuk mendukung **platform pemesanan cuci mobil on-demand** skala nasional (mirip konsep Gojek/Grab, tapi untuk car wash).
Fitur utama yang diakomodasi antara lain:

* Pemesanan jadwal cuci mobil
* Pembayaran online (e-wallet, bank, kartu, COD)
* Tracking teknisi
* Sistem langganan
* Loyalty points & promo
* Ulasan dan rating
* Notifikasi ke user & mitra
* Laporan mitra dan manajemen kota

## 🗄️ Struktur Database

### 1. **Users**

Menyimpan semua akun (customer, partner, admin).
Field utama:

* `role` → membedakan jenis akun
* `points_balance` → saldo poin loyalty

Relasi:

* `users` → `orders` (customer\_id)
* `users` → `partners` (owner\_user\_id)
* `users` → `payments` (pembayaran)

---

### 2. **Partners & Technicians**

* **partners** → profil bisnis mitra cuci mobil (alamat, radius, rating).
* **technicians** → opsional, jika mitra punya banyak teknisi/pekerja lapangan.

Relasi:

* 1 partner dimiliki 1 user (`owner_user_id`).
* 1 partner bisa punya banyak teknisi & banyak pesanan.

---

### 3. **Services & Partner Services**

* **services** → katalog layanan umum (cuci luar, cuci lengkap, detailing, dll).
* **partner\_services** → pivot table: daftar harga & durasi tiap mitra.

Relasi:

* 1 partner bisa menawarkan banyak service dengan harga berbeda.
* Digunakan untuk snapshot saat pesanan dibuat.

---

### 4. **Orders**

Tabel inti transaksi.
Field utama:

* `scheduled_at`, `placed_at` → jadwal & waktu pemesanan
* `status` → requested, accepted, in\_progress, completed, cancelled
* `payment_status` → pending, paid, failed
* `address_text`, `latitude`, `longitude` → lokasi pelanggan

Relasi:

* `customer_id` → users
* `partner_id` → partners
* `service_id` → services
* `technician_id` (opsional) → teknisi lapangan

---

### 5. **Payments**

Detail pembayaran untuk order atau subscription.
Field:

* `method` (qris, ewallet, transfer, kartu, COD)
* `status` (pending, paid, failed, refunded)
* `provider_ref` → reference dari payment gateway

Relasi:

* 1 order → 1 payment
* Bisa juga untuk subscription (paket langganan)

---

### 6. **Subscriptions**

Dua tabel utama:

* `subscription_plans` → paket langganan (misal 4x/bulan, unlimited, dll)
* `user_subscriptions` → langganan aktif tiap user
* `subscription_payments` → pembayaran per periode

Fungsi:

* Mendukung recurring revenue
* Menghitung sisa kuota cuci per periode

---

### 7. **Reviews**

Pelanggan memberi ulasan setelah order selesai.
Field:

* `rating` (1–5)
* `comment`
* `photo_url` (opsional, bukti foto hasil cuci)

Relasi:

* 1 order hanya bisa punya 1 review
* Terhubung ke customer & partner

---

### 8. **Loyalty & Promo**

* **points\_history** → log perolehan & penggunaan poin customer
* **promos** → kode promo (diskon, voucher)
* **order\_promos** → pivot: promo apa yang dipakai di order

Fungsi:

* Meningkatkan retensi pelanggan
* Memungkinkan sistem rewards

---

### 9. **Notifications**

Log notifikasi yang dikirim ke user atau mitra.
Field:

* `type` → order\_status, promo, dsb
* `sent_via` → push, SMS, email, WhatsApp
* Bisa dipakai untuk histori notifikasi & troubleshooting

---

## 🔗 Hubungan Utama (ERD)

* `users (role=customer)` → `orders (customer_id)`
* `users (role=partner)` → `partners (owner_user_id)`
* `partners` → `partner_services` → `services`
* `orders` → `payments`, `reviews`, `order_promos`
* `users` → `user_subscriptions` → `subscription_plans`
* `points_history` → melacak poin tiap user

---

## 🚀 Roadmap Implementasi

* **Tahap 1 (MVP)** → `users`, `partners`, `services`, `partner_services`, `orders`, `payments`, `reviews`
* **Tahap 2 (Growth)** → tambah `promos`, `points_history`, `notifications`
* **Tahap 3 (Retention)** → aktifkan `subscriptions` & loyalty system
* **Tahap 4 (Enterprise)** → laporan partner detail, auto payout, audit log

---

## 🛠️ Teknologi yang Digunakan

* **Database**: MySQL
* **ORM**: Eloquent (Laravel 12)

---

## 📖 Cara Membaca Diagram

Buka file DBML di [dbdiagram.io](https://dbdiagram.io), paste skema DBML lengkap, maka akan muncul visualisasi ERD.
Setiap entitas sudah memiliki relasi FK sesuai di schema.