<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->sections['title'] ?? '' ?></title>
    <style>
        body { opacity: 0; }
    </style>
    <?= $this->sections['styles'] ?? '' ?>
    <?= vite(['resources/css/app.css', 'resources/js/app.js']) ?>
</head>
<body>

    <?= $this->sections['content'] ?? '' ?>

  
</body>
</html>