
document.addEventListener('DOMContentLoaded', () => {
  const widget = document.querySelector('.comment-widget');
  const postId = widget.dataset.post;
  const list = document.getElementById('comment-list');
  const themeToggle = document.getElementById('theme-toggle');

  if (themeToggle) {
    themeToggle.addEventListener('click', () => {
      const current = document.documentElement.getAttribute('data-theme') || 'light';
      const next = current === 'light' ? 'dark' : 'light';
      document.documentElement.setAttribute('data-theme', next);
    });
  }

  // Fetch comments
  fetch(`../src/CommentController.php?post=${encodeURIComponent(postId)}`)
    .then(r => r.json()).then(renderAll);

  // Submit
  document.getElementById('comment-form').addEventListener('submit', e => {
    e.preventDefault();
    const fd = new FormData(e.target);
    fd.append('post_id', postId);
    fetch('../src/CommentController.php', {method:'POST', body:fd})
      .then(r=>r.json()).then(resp=>{
        alert(resp.status==='approved'?'Комментарий опубликован!':'Отправлено на модерацию');
        e.target.reset();
      });
  });

  function renderAll(arr){
    list.innerHTML='';
    arr.forEach(c=>{list.appendChild(renderItem(c));});
  }
  function renderItem(c){
    const li=document.createElement('li');
    li.className='comment-item';
    li.innerHTML=`<div><span class="comment-author">${c.guest_name||'Anon'}</span><span class="comment-date">${c.created_at}</span></div><div>${c.content}</div>`;
    return li;
  }
});
