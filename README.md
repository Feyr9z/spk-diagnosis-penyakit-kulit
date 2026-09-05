# SPK Diagnosis Penyakit Kulit — Ermust Clinic

Aplikasi web untuk membantu diagnosis penyakit kulit menggunakan metode **Simple Additive Weighting (SAW)**.

---

## Persyaratan Sebelum Memulai

Sebelum menjalankan aplikasi ini, kamu hanya perlu menginstall **2 software** berikut:

### 1. Git
Git digunakan untuk mengunduh kode aplikasi dari internet.

- **Windows / macOS**: Download di [git-scm.com](https://git-scm.com/downloads) → Install seperti software biasa.
- **Linux**: Buka Terminal, ketik perintah berikut:
  ```bash
  sudo apt install git      # Ubuntu/Debian
  sudo dnf install git      # Fedora
  ```

### 2. Docker Desktop
Docker adalah software yang menjalankan aplikasi ini secara otomatis tanpa perlu install PHP, MySQL, atau software lainnya secara manual.

- **Windows**: Download di [docs.docker.com/desktop/windows](https://docs.docker.com/desktop/windows/install/)
  > Saat install, pilih opsi **"Use WSL 2"** jika diminta.
- **macOS**: Download di [docs.docker.com/desktop/mac](https://docs.docker.com/desktop/mac/install/)
- **Linux**: Download di [docs.docker.com/desktop/linux](https://docs.docker.com/desktop/linux/install/)

Setelah Docker Desktop terinstall, **pastikan Docker Desktop sudah dibuka dan berjalan** sebelum melanjutkan ke langkah berikutnya.

---

## Cara Instalasi

Buka **Terminal** (Linux/macOS) atau **Git Bash / PowerShell** (Windows), lalu ikuti langkah-langkah berikut satu per satu:

### Langkah 1 — Unduh Aplikasi

```bash
git clone https://github.com/feyr9z/spk-diagnosis-penyakit-kulit.git
cd spk-diagnosis-penyakit-kulit
```

### Langkah 2 — Buat File Konfigurasi

**Linux / macOS:**
```bash
cp .env.example .env
```

**Windows (PowerShell):**
```powershell
copy .env.example .env
```

> File `.env` berisi pengaturan aplikasi seperti nama database dan password. Nilai bawaannya sudah langsung bisa dipakai untuk menjalankan aplikasi secara lokal.

### Langkah 3 — Jalankan Aplikasi

```bash
docker compose up -d --build
```

> Proses ini akan mengunduh semua komponen yang dibutuhkan secara otomatis. Pada pertama kali, membutuhkan waktu sekitar **3–10 menit** tergantung kecepatan internet.

### Langkah 4 — Siapkan Database & Aset

Jalankan perintah ini **satu per satu** secara berurutan:

```bash
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
docker compose exec app npm install
docker compose exec app npm run build
```

> Jika muncul error duplikasi data pada `migrate --seed`, itu normal karena data sudah pernah dibuat sebelumnya. Abaikan saja dan lanjutkan ke perintah berikutnya.

### Langkah 5 — Buka Aplikasi

Buka browser (Chrome, Firefox, dll.) dan ketik alamat berikut:

```
http://localhost:8000
```

---

## Login Pertama Kali

| Role | Username | Password |
|---|---|---|
| Super Admin | `superadmin` | `password` |
| Admin | `admin` | `password` |

> **Penting:** Segera ganti password setelah login pertama kali melalui menu **Profil → Ubah Password**.

---

## Cara Menyalakan & Mematikan Aplikasi

Setelah instalasi selesai, kamu tidak perlu mengulang semua langkah di atas. Cukup gunakan perintah berikut:

**Menyalakan aplikasi:**
```bash
docker compose up -d
```

**Mematikan aplikasi:**
```bash
docker compose stop
```

---

## Pemecahan Masalah Umum

| Masalah | Solusi |
|---|---|
| Port 8000 sudah dipakai | Ganti baris `"8000:80"` menjadi `"8080:80"` di `docker-compose.yml`, lalu akses `http://localhost:8080` |
| Port 3308 sudah dipakai | Ganti baris `"3308:3306"` menjadi `"3309:3306"` di `docker-compose.yml` |
| Aplikasi tidak muncul setelah `docker compose up` | Tunggu 30 detik, kemudian refresh browser |
| Lupa password login | Jalankan: `docker compose exec app php artisan db:seed --class=UserSeeder --force` |

---

## Lisensi

Aplikasi ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).
