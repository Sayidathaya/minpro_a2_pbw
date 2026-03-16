<?php
// ============================================================
// FILE   : app/models/SkillModel.php
// ============================================================

class SkillModel {
    private PDO $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    public function getAll(): array {
        return $this->pdo->query("SELECT * FROM skills ORDER BY urutan ASC")->fetchAll();
    }
    public function getById(int $id): array|false {
        $s = $this->pdo->prepare("SELECT * FROM skills WHERE id=?");
        $s->execute([$id]); return $s->fetch();
    }
    public function create(array $d): bool {
        $s = $this->pdo->prepare("INSERT INTO skills (name,level,category,urutan) VALUES (?,?,?,?)");
        return $s->execute([$d['name'],$d['level'],$d['category'],$d['urutan']]);
    }
    public function update(array $d, int $id): bool {
        $s = $this->pdo->prepare("UPDATE skills SET name=?,level=?,category=?,urutan=? WHERE id=?");
        return $s->execute([$d['name'],$d['level'],$d['category'],$d['urutan'],$id]);
    }
    public function delete(int $id): bool {
        $s = $this->pdo->prepare("DELETE FROM skills WHERE id=?");
        return $s->execute([$id]);
    }
}

// ============================================================
// FILE   : app/models/ExperienceModel.php
// ============================================================

class ExperienceModel {
    private PDO $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    public function getAll(): array {
        return $this->pdo->query("SELECT * FROM experience ORDER BY urutan ASC")->fetchAll();
    }
    public function getById(int $id): array|false {
        $s = $this->pdo->prepare("SELECT * FROM experience WHERE id=?");
        $s->execute([$id]); return $s->fetch();
    }
    public function create(array $d): bool {
        $s = $this->pdo->prepare("INSERT INTO experience (position,company,period,description,urutan) VALUES (?,?,?,?,?)");
        return $s->execute([$d['position'],$d['company'],$d['period'],$d['description'],$d['urutan']]);
    }
    public function update(array $d, int $id): bool {
        $s = $this->pdo->prepare("UPDATE experience SET position=?,company=?,period=?,description=?,urutan=? WHERE id=?");
        return $s->execute([$d['position'],$d['company'],$d['period'],$d['description'],$d['urutan'],$id]);
    }
    public function delete(int $id): bool {
        $s = $this->pdo->prepare("DELETE FROM experience WHERE id=?");
        return $s->execute([$id]);
    }
}

// ============================================================
// FILE   : app/models/EducationModel.php
// ============================================================

class EducationModel {
    private PDO $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    public function getAll(): array {
        return $this->pdo->query("SELECT * FROM education ORDER BY urutan ASC")->fetchAll();
    }
    public function getById(int $id): array|false {
        $s = $this->pdo->prepare("SELECT * FROM education WHERE id=?");
        $s->execute([$id]); return $s->fetch();
    }
    public function create(array $d): bool {
        $s = $this->pdo->prepare("INSERT INTO education (institution,degree,field,year_start,year_end,description,urutan) VALUES (?,?,?,?,?,?,?)");
        return $s->execute([$d['institution'],$d['degree'],$d['field'],$d['year_start'],$d['year_end'],$d['description'],$d['urutan']]);
    }
    public function update(array $d, int $id): bool {
        $s = $this->pdo->prepare("UPDATE education SET institution=?,degree=?,field=?,year_start=?,year_end=?,description=?,urutan=? WHERE id=?");
        return $s->execute([$d['institution'],$d['degree'],$d['field'],$d['year_start'],$d['year_end'],$d['description'],$d['urutan'],$id]);
    }
    public function delete(int $id): bool {
        $s = $this->pdo->prepare("DELETE FROM education WHERE id=?");
        return $s->execute([$id]);
    }
}

// ============================================================
// FILE   : app/models/ProjectModel.php
// ============================================================

class ProjectModel {
    private PDO $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    public function getAll(): array {
        return $this->pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll();
    }
    public function getFeatured(): array {
        return $this->pdo->query("SELECT * FROM projects WHERE featured=1 ORDER BY created_at DESC")->fetchAll();
    }
    public function getById(int $id): array|false {
        $s = $this->pdo->prepare("SELECT * FROM projects WHERE id=?");
        $s->execute([$id]); return $s->fetch();
    }
    public function create(array $d): bool {
        $s = $this->pdo->prepare("INSERT INTO projects (title,description,tech_stack,image,demo_url,github_url,category,featured) VALUES (?,?,?,?,?,?,?,?)");
        return $s->execute([$d['title'],$d['description'],$d['tech_stack'],$d['image'],$d['demo_url'],$d['github_url'],$d['category'],$d['featured']]);
    }
    public function update(array $d, int $id): bool {
        $s = $this->pdo->prepare("UPDATE projects SET title=?,description=?,tech_stack=?,demo_url=?,github_url=?,category=?,featured=? WHERE id=?");
        return $s->execute([$d['title'],$d['description'],$d['tech_stack'],$d['demo_url'],$d['github_url'],$d['category'],$d['featured'],$id]);
    }
    public function updateImage(string $path, int $id): bool {
        $s = $this->pdo->prepare("UPDATE projects SET image=? WHERE id=?");
        return $s->execute([$path,$id]);
    }
    public function delete(int $id): bool {
        $s = $this->pdo->prepare("DELETE FROM projects WHERE id=?");
        return $s->execute([$id]);
    }
}

// ============================================================
// FILE   : app/models/CertificateModel.php
// ============================================================

class CertificateModel {
    private PDO $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    public function getAll(): array {
        return $this->pdo->query("SELECT * FROM certificates ORDER BY issued_date DESC")->fetchAll();
    }
    public function getById(int $id): array|false {
        $s = $this->pdo->prepare("SELECT * FROM certificates WHERE id=?");
        $s->execute([$id]); return $s->fetch();
    }
    public function create(array $d): bool {
        $s = $this->pdo->prepare("INSERT INTO certificates (title,issuer,description,image,issued_date,cert_url) VALUES (?,?,?,?,?,?)");
        return $s->execute([$d['title'],$d['issuer'],$d['description'],$d['image'],$d['issued_date'],$d['cert_url']]);
    }
    public function update(array $d, int $id): bool {
        $s = $this->pdo->prepare("UPDATE certificates SET title=?,issuer=?,description=?,issued_date=?,cert_url=? WHERE id=?");
        return $s->execute([$d['title'],$d['issuer'],$d['description'],$d['issued_date'],$d['cert_url'],$id]);
    }
    public function updateImage(string $path, int $id): bool {
        $s = $this->pdo->prepare("UPDATE certificates SET image=? WHERE id=?");
        return $s->execute([$path,$id]);
    }
    public function delete(int $id): bool {
        $s = $this->pdo->prepare("DELETE FROM certificates WHERE id=?");
        return $s->execute([$id]);
    }
}

// ============================================================
// FILE   : app/models/ThankyouModel.php
// ============================================================

class ThankyouModel {
    private PDO $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    public function getAll(): array {
        return $this->pdo->query("SELECT * FROM thankyou ORDER BY created_at DESC")->fetchAll();
    }
    public function getUnread(): int {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM thankyou WHERE is_read=0")->fetchColumn();
    }
    public function create(array $d): bool {
        $s = $this->pdo->prepare("INSERT INTO thankyou (name,email,message) VALUES (?,?,?)");
        return $s->execute([$d['name'],$d['email'],$d['message']]);
    }
    public function markRead(int $id): bool {
        $s = $this->pdo->prepare("UPDATE thankyou SET is_read=1 WHERE id=?");
        return $s->execute([$id]);
    }
    public function delete(int $id): bool {
        $s = $this->pdo->prepare("DELETE FROM thankyou WHERE id=?");
        return $s->execute([$id]);
    }
}
