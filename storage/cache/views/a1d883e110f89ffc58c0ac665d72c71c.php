<?php
    $iconColor = $theme === 'dark'
        ? 'text-zinc-400 hover:text-zinc-100'
        : 'text-zinc-500 hover:text-zinc-900';

    $activeColor = $theme === 'dark'
        ? 'text-zinc-100'
        : 'text-zinc-900';

    $isActive = is_active('/cart') !== '';
    $color    = $isActive ? $activeColor : $iconColor;
?>
<a data-ajax-link href="/cart" class="relative <?= e($color) ?> transition-colors">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h11M10 19a1 1 0 1 0 2 0M17 19a1 1 0 1 0 2 0"/>
    </svg>
    <?php if (!empty($value)): ?>
        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs
                     rounded-full w-4 h-4 flex items-center justify-center">
            <?= (int) $value ?>
        </span>
    <?php endif; ?>
</a>