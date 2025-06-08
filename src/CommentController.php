
<?php
require_once __DIR__.'/Comment.php';

class CommentController {

    public static function list($post_id) {
        $comments = Comment::fetchApprovedByPost($post_id);
        header('Content-Type: application/json');
        echo json_encode($comments);
    }

    public static function store() {
        $cfg = require __DIR__.'/../config/config.php';
        // Basic validation
        $data = [
            'post_id'     => $_POST['post_id'] ?? '',
            'parent_id'   => $_POST['parent_id'] ?? null,
            'guest_name'  => $_POST['name'] ?? '',
            'guest_email' => $_POST['email'] ?? '',
            'content'     => $_POST['content'] ?? '',
            'user_id'     => null,
            'status'      => $cfg['moderation']['require_approval'] ? 'pending' : 'approved'
        ];
        Comment::create($data);
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'status' => $data['status']]);
    }
}

// Router (very simple)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['post'])) {
    CommentController::list($_GET['post']);
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CommentController::store();
    exit;
}
