# Portfolio_Part2 – Sayid Rafi A’thaya

## 📌 Deskripsi Project

<img width="1919" height="968" alt="Image" src="https://github.com/user-attachments/assets/717d8126-3e4c-4e4f-9745-2a33efd7692c" />

<img width="1919" height="968" alt="Image" src="https://github.com/user-attachments/assets/882e50c0-1e82-45ff-b5bf-f62a58651430" />

<img width="1919" height="967" alt="Image" src="https://github.com/user-attachments/assets/4dfce3b0-d176-4967-97e5-a5d35eddf83b" />

Portfolio adalah website portfolio pribadi yang dibuat untuk menampilkan profil, kemampuan, pengalaman, dan sertifikat secara profesional dan modern. Website ini dirancang responsif, dinamis, serta mudah dikembangkan menggunakan pendekatan frontend modern.

Project ini menampilkan integrasi antara struktur HTML, styling CSS, framework Bootstrap 5, serta reactive data binding menggunakan Vue JS.

Website: https://sayidathaya.github.io/minpro_a1_pbw/

---

# 🛠 Teknologi yang Digunakan

Project ini dibangun menggunakan teknologi berikut:

* **HTML5** → Struktur utama halaman website
* **CSS3** → Styling dan tampilan visual
* **Bootstrap 5.3.2** → Framework CSS untuk layout responsif dan komponen siap pakai
* **Vue JS 3 (CDN)** → Reactive data binding dan dynamic rendering
* **JavaScript (ES6)** → Logika interaktif

---

# 📂 Struktur Halaman

Website ini terdiri dari beberapa bagian utama:

1. Navbar
2. Hero Section
3. About Me Section
4. Certificates Section
5. Footer
6. Vue JS Data System
7. Styling (style.css)

---

# TAMPILAN

<img width="1919" height="1014" alt="Image" src="https://github.com/user-attachments/assets/ab3e31b3-215d-4859-b1e3-08c441bcb25c" />

<img width="1891" height="913" alt="Image" src="https://github.com/user-attachments/assets/e818f0c5-4411-43a8-9bb8-a60f59b48c1a" />

<img width="1918" height="910" alt="Image" src="https://github.com/user-attachments/assets/46097304-067f-427a-89e4-353945775e46" />

---

# 🔎 Penjelasan Code Setiap Section / Fitur

---

## 1️⃣ Navbar

### Fungsi:

Navigasi utama untuk berpindah antar section (Home, About Me, Certificates).

### Teknologi:

* Bootstrap Navbar Component
* Responsive collapse menu
* Fixed-top positioning

### Penjelasan:

```html
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
```

* `navbar-expand-lg` → Navbar responsive (collapse di layar kecil)
* `navbar-dark bg-dark` → Warna gelap
* `fixed-top` → Selalu berada di atas
* `shadow` → Efek bayangan

Fitur collapse bekerja menggunakan:

```html
data-bs-toggle="collapse"
data-bs-target="#navbarNav"
```

yang diaktifkan oleh Bootstrap JS.

---

## 2️⃣ Hero Section

### Fungsi:

Bagian pembuka website yang menampilkan foto, nama, title, dan tombol CTA.

### Teknologi:

* Bootstrap Flex Utility
* Vue JS Data Binding
* CSS Gradient Background

### Penjelasan:

```html
<h1 class="display-4 fw-bold">{{ name }}</h1>
<p class="lead">{{ title }}</p>
```

* `{{ name }}` dan `{{ title }}` adalah Vue interpolation
* Data diambil dari Vue `data()`

CSS:

```css
.hero-section {
  height: 100vh;
  background: linear-gradient(135deg, #001f3f, #ff0000);
}
```

* `100vh` → Tinggi layar penuh
* Gradient → Tampilan elegan modern

---

## 3️⃣ About Me Section

### Fungsi:

Menampilkan deskripsi diri, skills dengan progress bar, serta pengalaman.

### Teknologi:

* Bootstrap Grid System
* Vue v-for Loop
* Dynamic Style Binding

---

### 🔹 A. Deskripsi

```html
<p class="fs-5">{{ about }}</p>
```

Mengambil data dari:

```javascript
about: "Saya adalah seorang developer..."
```

---

### 🔹 B. Skills (Dynamic Progress Bar)

```html
<div v-for="skill in skills">
```

Vue melakukan looping array:

```javascript
skills: [
  { name: "HTML & CSS", level: 95 },
  { name: "Bootstrap", level: 90 }
]
```

Progress bar dinamis:

```html
:style="{ width: skill.level + '%' }"
```

Artinya lebar progress bar otomatis mengikuti nilai level.

---

### 🔹 C. Experience (List Rendering)

```html
<li v-for="exp in experience">{{ exp }}</li>
```

Vue akan merender array experience menjadi daftar otomatis.

---

## 4️⃣ Certificates Section

### Fungsi:

Menampilkan daftar sertifikat dalam bentuk card.

### Teknologi:

* Bootstrap Card Component
* Vue v-for Loop
* Dynamic Image Binding

---

```html
<div class="col-md-4 mb-4" v-for="cert in certificates">
```

Data berasal dari:

```javascript
certificates: [
  {
    title: "Secretary & Treasurer",
    desc: "Certified Secretary & Treasurer",
    image: "assets/images/cert1.png"
  }
]
```

Dynamic image binding:

```html
<img :src="cert.image">
```

Hover animation dari CSS:

```css
#certificates .card:hover {
  transform: translateY(-10px);
}
```

Memberikan efek naik saat hover.

---

## 5️⃣ Footer

### Fungsi:

Penutup website dengan copyright.

```html
© 2026 {{ name }} | Portfolio
```

Menggunakan Vue interpolation agar nama otomatis mengikuti data.

---

## 6️⃣ Vue JS Reactive System

Vue digunakan untuk membuat website lebih dinamis tanpa reload.

Inisialisasi:

```javascript
const { createApp } = Vue

createApp({
  data() {
    return {
      name: "Sayid Rafi A'thaya",
      title: "Frontend Developer & UI Designer"
    }
  }
}).mount('#app')
```

Penjelasan:

* `createApp()` → Membuat instance Vue
* `data()` → Menyimpan seluruh data website
* `mount('#app')` → Menghubungkan Vue dengan div id="app"

Semua data dapat diubah dari satu tempat.

---

## 7️⃣ Styling (style.css)

### A. Global Styling

```css
body {
  font-family: 'Segoe UI', sans-serif;
  scroll-behavior: smooth;
}
```

* Mengatur font
* Smooth scrolling antar section

---

### B. Profile Image

```css
.profile-img {
  border: 5px solid #ffc107;
}
```

Memberikan border kuning elegan.

---

### C. Hover Effect Certificates

```css
transition: transform 0.3s ease;
```

Animasi halus saat hover.

---

# 🎯 Fitur Utama Website

* Responsive Design
* Dynamic Data Rendering (Vue JS)
* Smooth Scroll Navigation
* Interactive Progress Bars
* Hover Animation Cards
* Modern Gradient Hero
* Reusable Data Structure

---

# 📱 Responsive Behavior

Menggunakan Bootstrap Grid:

* `col-md-6`
* `col-md-4`
* `container`
* `row`

Website otomatis menyesuaikan layar:

* Desktop
* Tablet
* Mobile

---

# 🚀 Cara Menjalankan Project

1. Download atau clone project
2. Pastikan struktur folder benar:

   ```
   assets/
     └── images/
   index.html
   style.css
   ```
3. Buka `index.html` di browser

Tidak memerlukan backend atau server.
