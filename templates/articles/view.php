<?php include __DIR__ . '/../header.php'; ?>
    <?php include __DIR__ . '/../header.php'; ?>
    <h1><?= $article->getName() ?></h1>
    <p><?= $article->getParsedText() ?></p>
    <p>Автор: <?= $article->getAuthor()->getNickname() ?></p>
    <?php if ($user->getRole() === 'admin'): ?>
        <p><a href = "<?= $article->getId() ?>/edit">Редактировать</a></p>
    <?php endif; ?>
<?php include __DIR__ . '/../footer.php'; ?>