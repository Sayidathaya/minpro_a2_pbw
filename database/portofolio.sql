-- ============================================================
-- DATABASE: portofolio_sayid
-- Project  : Website Portofolio Sayid Rafi A'thaya
-- ============================================================

CREATE DATABASE IF NOT EXISTS portofolio_sayid
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE portofolio_sayid;

-- -------------------------------------------------------
-- TABLE: users (admin auth)
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
  id        INT AUTO_INCREMENT PRIMARY KEY,
  username  VARCHAR(100) NOT NULL UNIQUE,
  password  VARCHAR(255) NOT NULL,
  role      ENUM('admin','user') DEFAULT 'user',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Default admin: password = admin123
INSERT INTO users (username, password, role) VALUES
('sayidrafi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uze/oSoze', 'admin');

-- -------------------------------------------------------
-- TABLE: about
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS about (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  name        VARCHAR(150) NOT NULL,
  title       VARCHAR(200) NOT NULL,
  description TEXT NOT NULL,
  email       VARCHAR(150),
  phone       VARCHAR(30),
  location    VARCHAR(150),
  photo       VARCHAR(255),
  hero_image  VARCHAR(255),
  updated_at  DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO about (name, title, description, email, phone, location, photo, hero_image) VALUES
(
  "Sayid Rafi A'thaya",
  'Frontend Developer & UI Designer',
  'Saya adalah seorang developer yang berfokus pada pengembangan website modern menggunakan HTML, CSS, Bootstrap, dan Vue JS. Saya menyukai desain yang elegan, responsif, dan berkelas.',
  'sayidrafi@email.com',
  '+62 812-3456-7890',
  'Samarinda, Kalimantan Timur',
  'assets/images/profile.jpg',
  'assets/images/hero.jpg'
);

-- -------------------------------------------------------
-- TABLE: skills
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS skills (
  id        INT AUTO_INCREMENT PRIMARY KEY,
  name      VARCHAR(100) NOT NULL,
  level     INT NOT NULL DEFAULT 0,
  category  VARCHAR(50) DEFAULT 'Technical',
  urutan    INT DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO skills (name, level, category, urutan) VALUES
('HTML & CSS', 95, 'Frontend', 1),
('Bootstrap', 90, 'Frontend', 2),
('Vue JS', 85, 'Frontend', 3),
('UI/UX Design', 80, 'Design', 4),
('PHP', 75, 'Backend', 5),
('MySQL', 70, 'Database', 6);

-- -------------------------------------------------------
-- TABLE: experience
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS experience (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  position    VARCHAR(150) NOT NULL,
  company     VARCHAR(150) NOT NULL,
  period      VARCHAR(100) NOT NULL,
  description TEXT,
  urutan      INT DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO experience (position, company, period, description, urutan) VALUES
('Freelance Web Developer', 'Self Employed', '2023 - Present', 'Membangun 20+ proyek website pribadi dan klien menggunakan teknologi modern.', 1),
('Data Engineer', 'Tech Company', '2022 - 2023', 'Mengolah dan menganalisis data skala besar untuk kebutuhan bisnis perusahaan.', 2);

-- -------------------------------------------------------
-- TABLE: education
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS education (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  institution VARCHAR(200) NOT NULL,
  degree      VARCHAR(150) NOT NULL,
  field       VARCHAR(150),
  year_start  YEAR,
  year_end    YEAR,
  description TEXT,
  urutan      INT DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO education (institution, degree, field, year_start, year_end, description, urutan) VALUES
('Universitas Mulawarman', 'S1 Teknik Informatika', 'Ilmu Komputer', 2022, 2026, 'Belajar pemrograman web, basis data, dan pengembangan software.', 1),
('SMK Negeri 7 Samarinda', 'Rekayasa Perangkat Lunak', NULL, 2019, 2022, 'Mempelajari dasar-dasar pemrograman dan pengembangan aplikasi.', 2);

-- -------------------------------------------------------
-- TABLE: projects
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS projects (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  title       VARCHAR(200) NOT NULL,
  description TEXT NOT NULL,
  tech_stack  VARCHAR(255),
  image       VARCHAR(255),
  demo_url    VARCHAR(255),
  github_url  VARCHAR(255),
  category    VARCHAR(100) DEFAULT 'Web',
  featured    TINYINT(1) DEFAULT 0,
  created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO projects (title, description, tech_stack, image, demo_url, github_url, category, featured) VALUES
('Portfolio Website', 'Website portofolio personal dengan desain modern dan responsif.', 'HTML, CSS, Bootstrap, Vue JS, PHP, MySQL', 'assets/images/project1.jpg', '#', 'https://github.com/sayidrafi', 'Web', 1),
('E-Commerce App', 'Aplikasi toko online dengan fitur keranjang belanja dan pembayaran.', 'PHP, MySQL, Bootstrap, jQuery', 'assets/images/project2.jpg', '#', 'https://github.com/sayidrafi', 'Web', 1),
('Data Dashboard', 'Dashboard analitik data dengan visualisasi grafik interaktif.', 'Vue JS, Chart.js, PHP, MySQL', 'assets/images/project3.jpg', '#', 'https://github.com/sayidrafi', 'Web', 0);

-- -------------------------------------------------------
-- TABLE: certificates
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS certificates (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  title       VARCHAR(200) NOT NULL,
  issuer      VARCHAR(150),
  description TEXT,
  image       VARCHAR(255),
  issued_date DATE,
  cert_url    VARCHAR(255),
  created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO certificates (title, issuer, description, image, issued_date, cert_url) VALUES
('Secretary & Treasurer', 'Organization Institute', 'Certified Secretary & Treasurer dalam kegiatan organisasi kampus.', 'assets/images/cert1.png', '2024-01-15', '#'),
('AI Upskilling Program', 'Digital Talent Scholarship', 'Advanced AI Training untuk pengembangan skill kecerdasan buatan.', 'assets/images/cert2.png', '2024-06-20', '#'),
('Moderator & Speaker', 'Tech Conference', 'Professional Public Speaker dan Moderator dalam acara teknologi.', 'assets/images/cert3.png', '2024-09-10', '#');

-- -------------------------------------------------------
-- TABLE: thankyou (pesan masuk dari pengunjung)
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS thankyou (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  name       VARCHAR(150) NOT NULL,
  email      VARCHAR(150),
  message    TEXT NOT NULL,
  is_read    TINYINT(1) DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
