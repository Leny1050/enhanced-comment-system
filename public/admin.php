
<?php
session_start();
require_once __DIR__.'/../src/Comment.php';
require_once __DIR__.'/../config/config.php';
$cfg = require __DIR__.'/../config/config.php';
if (!isset($_SESSION['admin']) && isset($_POST['password'])) {
    if (password_verify($_POST['password'], $cfg['admin']['password_hash'])) {
        $_SESSION['admin'] = true;
    } else {
        $error = 'Неверный пароль';
    }
}
if (isset($_GET['logout'])) {session_destroy();header('Location: admin.php');exit;}
if (isset($_SESSION['admin'])) {
    if (isset($_GET['approve'])) Comment::updateStatus($_GET['approve'],'approved');
    if (isset($_GET['spam']))    Comment::updateStatus($_GET['spam'],'spam');
    if (isset($_GET['delete']))  Comment::updateStatus($_GET['delete'],'spam');
}
?>
<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>Admin</title><link rel="stylesheet" href="assets/css/admin.css"></head><body>
<?php if(!isset($_SESSION['admin'])): ?>
  <main class="login-page">
    <form method="post" style="max-width:320px;margin:80px auto;background:#fff;padding:24px;border-radius:8px;">
      <h2 style="margin-top:0;">Admin Login</h2>
      <?php if(isset($error)){echo "<p style='color:red'>$error</p>";} ?>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" style="margin-top:12px;">Login</button>
    </form>
  </main>
<?php else: ?>
  <header><h1>Moderation</h1><a href="?logout=1">Logout</a></header>
  <main>
    <h2>Pending Comments</h2>
    <table><tr><th>ID</th><th>Author</th><th>Snippet</th><th>Date</th><th>Actions</th></tr>
    <?php
      $pending = Database::getConnection()->query('SELECT * FROM comments WHERE status="pending" ORDER BY created_at ASC')->fetchAll();
      foreach($pending as $c){
        echo "<tr>";
        echo "<td>{$c['id']}</td>";
        echo "<td>".htmlspecialchars($c['guest_name'])."</td>";
        echo "<td>".htmlspecialchars(mb_substr($c['content'],0,70))."</td>";
        echo "<td>{$c['created_at']}</td>";
        echo "<td><a href='?approve={$c['id']}'>Approve</a> |
                  <a href='?spam={$c['id']}'>Spam</a></td>";
        echo "</tr>";
      }
    ?>
    </table>
  </main>
<?php endif; ?>
</body></html>
