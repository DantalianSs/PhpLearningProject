<?php include __DIR__ . '/../header.php'; ?>
    <?php if (!empty($error)): ?>
            <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
    <?php endif; ?>
    <div style="text-align: center;">
        <h1>Активация вашего аккаунта прошла успешно!</h1>
    </div>
<?php include __DIR__ . '/../footer.php'; ?>