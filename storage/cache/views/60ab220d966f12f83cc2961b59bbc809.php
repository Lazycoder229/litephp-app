<?php
$isDark = ($theme ?? 'light') === 'dark';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->sections['title'] ?? '' ?></title>
    <style>body { opacity: 0; }</style>
    <?= $this->sections['styles'] ?? '' ?>
    <?= vite(['resources/css/app.css', 'resources/js/app.js']) ?>
</head>
<body class="<?= $isDark ? 'bg-zinc-950 text-zinc-100' : 'bg-zinc-50 text-zinc-900' ?>">

    <main>
        <?= $this->sections['content'] ?? '' ?>
    </main>

    <?= $this->sections['scripts'] ?? '' ?>
</body>
</html>