<?php
    $textColor = $theme === 'dark'
        ? 'text-gray-400 hover:text-white'
        : 'text-gray-500 hover:text-gray-900';
?>
<a href="/logout" class="text-sm <?= e($textColor) ?> transition-colors">
    Logout
</a>