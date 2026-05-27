<?php
$title = 'Список статей';
include __DIR__ . '/../header.php';
?>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
    <h2 style="margin:0;">Статьи</h2>
    <a href="/coursework/articles/add" class="btn-primary">+ Новая статья</a>
</div>

<?php foreach ($articles as $article): ?>
    <article class="article-preview">
        <h2>
            <a href="/coursework/articles/<?= $article->getId() ?>">
                <?= htmlspecialchars($article->getName(), ENT_QUOTES, 'UTF-8') ?>
            </a>
        </h2>
        <p><?= nl2br(htmlspecialchars($article->getText(), ENT_QUOTES, 'UTF-8')) ?></p>
        <div style="display:flex;gap:12px;margin-top:8px;">
            <a href="/coursework/article/<?= $article->getId() ?>/edit" class="edit-link">Редактировать</a>
            <form method="post" action="/coursework/articles/<?= $article->getId() ?>/delete"
                  onsubmit="return confirm('Удалить статью?')" style="margin:0;">
                <button type="submit" class="btn-danger">Удалить</button>
            </form>
        </div>
    </article>
<?php endforeach; ?>

<section class="tours-section">
    <h2 class="tours-title">Туры</h2>

    <?php if (!empty($tags)): ?>
        <div class="tours-tabs" role="tablist">
            <button class="tours-tab active" role="tab" data-tag="all" aria-selected="true">Все</button>
            <?php foreach ($tags as $tag): ?>
                <button class="tours-tab" role="tab"
                    data-tag="<?= htmlspecialchars($tag->getName(), ENT_QUOTES, 'UTF-8') ?>"
                    aria-selected="false">
                    <?= htmlspecialchars($tag->getLabel(), ENT_QUOTES, 'UTF-8') ?>
                </button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="tours-grid">
        <?php foreach ($tours as $tour): ?>
            <div class="tour-card"
                data-tag="<?= htmlspecialchars($tour->getTagName(), ENT_QUOTES, 'UTF-8') ?>">
                <div class="tour-card__tag">
                    <?= htmlspecialchars($tour->getTagLabel(), ENT_QUOTES, 'UTF-8') ?>
                </div>
                <h3 class="tour-card__name">
                    <?= htmlspecialchars($tour->getName(), ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="tour-card__desc">
                    <?= htmlspecialchars($tour->getDescription(), ENT_QUOTES, 'UTF-8') ?>
                </p>
                <div class="tour-card__meta">
                    <span class="tour-card__duration">
                        <?= (int)$tour->getDurationDays() ?> дн.
                    </span>
                    <span class="tour-card__price">
                        <?= number_format((int)$tour->getPrice(), 0, '.', ' ') ?> ₽
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<script>
    (function() {
        var tabs = document.querySelectorAll('.tours-tab');
        var cards = document.querySelectorAll('.tour-card');

        tabs.forEach(function(tab) {
            tab.addEventListener('click', function() {
                tabs.forEach(function(t) {
                    t.classList.remove('active');
                    t.setAttribute('aria-selected', 'false');
                });
                tab.classList.add('active');
                tab.setAttribute('aria-selected', 'true');

                var selected = tab.getAttribute('data-tag');
                cards.forEach(function(card) {
                    if (selected === 'all' || card.getAttribute('data-tag') === selected) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    })();
</script>

<?php include __DIR__ . '/../footer.php'; ?>