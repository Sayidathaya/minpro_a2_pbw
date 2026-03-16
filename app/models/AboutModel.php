<?php
// ============================================================
// FILE   : app/models/AboutModel.php
// ============================================================

class AboutModel {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function get(): array|false {
        return $this->pdo->query("SELECT * FROM about LIMIT 1")->fetch();
    }

    public function update(array $data, int $id): bool {
        $sql = "UPDATE about SET name=:name, title=:title, description=:description,
                email=:email, phone=:phone, location=:location WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name'        => $data['name'],
            ':title'       => $data['title'],
            ':description' => $data['description'],
            ':email'       => $data['email'],
            ':phone'       => $data['phone'],
            ':location'    => $data['location'],
            ':id'          => $id,
        ]);
    }

    public function updatePhoto(string $field, string $path, int $id): bool {
        $stmt = $this->pdo->prepare("UPDATE about SET $field=:path WHERE id=:id");
        return $stmt->execute([':path' => $path, ':id' => $id]);
    }
}
