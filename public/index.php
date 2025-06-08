
<?php $postId = 'demo-post'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comment System Demo</title>
  <link rel="icon" href="assets/img/logo.png">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div style="text-align:center;margin-top:20px;">
    <img src="assets/img/logo.png" alt="logo" style="width:64px;">
  </div>
  <div class="comment-widget" data-post="<?= htmlspecialchars($postId) ?>">
    <h2>Комментарии</h2>
    <button id="theme-toggle" style="float:right;">🌗</button>
    <form id="comment-form">
        <input type="text" name="name" placeholder="Имя" required>
        <input type="email" name="email" placeholder="Email" required>
        <textarea name="content" placeholder="Комментарий" rows="4" required></textarea>
        <button type="submit">Отправить</button>
    </form>
    <ul id="comment-list"></ul>
  </div>
  <script src="assets/js/app.js" defer></script>
</body>
</html>
