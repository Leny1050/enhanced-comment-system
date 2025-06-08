
<?php
require_once __DIR__.'/Database.php';
class Comment {
    public static function create($data) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('INSERT INTO comments (post_id, parent_id, user_id, guest_name, guest_email, content, status) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['post_id'],
            $data['parent_id'],
            $data['user_id'],
            $data['guest_name'],
            $data['guest_email'],
            $data['content'],
            $data['status']
        ]);
        return $pdo->lastInsertId();
    }

    public static function fetchApprovedByPost($post_id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM comments WHERE post_id = ? AND status = "approved" ORDER BY created_at ASC');
        $stmt->execute([$post_id]);
        return $stmt->fetchAll();
    }

    public static function updateStatus($id, $status) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('UPDATE comments SET status = ? WHERE id = ?');
        $stmt->execute([$status, $id]);
    }
}
