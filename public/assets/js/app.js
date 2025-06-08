/* -------------------------------------------------------------
 | Enhanced Comment System – frontend widget
 | – Light/Dark переключатель
 | – Загрузка комментариев
 | – Отправка формы через fetch + FormData
 ------------------------------------------------------------- */
document.addEventListener('DOMContentLoaded', () => {
  const widget      = document.querySelector('.comment-widget');
  if (!widget) return;                                      // если виджет не найден – выходим

  const postId      = widget.dataset.post;                  // уникальный ID страницы/поста
  const list        = document.getElementById('comment-list');
  const form        = document.getElementById('comment-form');
  const themeToggle = document.getElementById('theme-toggle');

  /* ---------- Переключатель темы ---------- */
  if (themeToggle) {
    themeToggle.addEventListener('click', () => {
      const current = document.documentElement.getAttribute('data-theme') || 'light';
      const next    = current === 'light' ? 'dark' : 'light';
      document.documentElement.setAttribute('data-theme', next);
    });
  }

  /* ---------- Запрашиваем список комментариев ---------- */
  fetchComments();

  /* ---------- Отправляем новую запись ---------- */
  form.addEventListener('submit', e => {
    e.preventDefault();
    const fd = new FormData(form);
    fd.append('post_id', postId);

    fetch('/CommentController.php', { method: 'POST', body: fd })
      .then(r => r.json())
      .then(resp => {
        alert(resp.status === 'approved'
          ? 'Комментарий опубликован!'
          : 'Отправлено на модерацию');
        form.reset();
        if (resp.status === 'approved') fetchComments();    // сразу подгрузить, если без модерации
      })
      .catch(() => alert('Ошибка отправки. Попробуйте позже.'));
  });

  /* ---------- Функции ---------- */
  function fetchComments() {
    fetch(`/CommentController.php?post=${encodeURIComponent(postId)}`)
      .then(r => r.ok ? r.json() : [])                      // если 404/500 – вернём пустой массив
      .then(renderAll)
      .catch(() => renderAll([]));                          // при ошибке тоже рисуем пусто
  }

  function renderAll(arr = []) {
    list.innerHTML = '';
    arr.forEach(c => list.appendChild(renderItem(c)));
  }

  function renderItem(c) {
    const li = document.createElement('li');
    li.className = 'comment-item';
    li.innerHTML = `
      <div>
        <span class="comment-author">${escapeHTML(c.guest_name || 'Anon')}</span>
        <span class="comment-date">${c.created_at}</span>
      </div>
      <div>${escapeHTML(c.content)}</div>`;
    return li;
  }

  /* ---------- XSS-safe вывод ---------- */
  function escapeHTML(str) {
    return str.replace(/[&<>"']/g, m => ({
      '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'
    }[m]));
  }
});
