<?php
    $mutedTextColor = $theme === 'dark' ? 'text-gray-400' : 'text-gray-500';
?>
<aside id="sidebar"
       class="fixed top-0 left-0 z-30 h-full w-64 border-r
              transform -translate-x-full md:translate-x-0 transition-transform duration-300
              <?= e($bgColor) ?> <?= e($borderColor) ?>">

    <div class="flex items-center px-6 border-b h-[61px] <?= e($borderColor) ?>">
        <span class="font-semibold <?= e($brandTextColor) ?>"><?= e($brand) ?></span>
    </div>
    <nav class="px-4 py-4 space-y-1">
        <?php foreach ($navLinks as $link): ?>
            <?php
                $href          = htmlspecialchars($link['href'], ENT_QUOTES, 'UTF-8');
                $label         = htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8');
                $isActive      = is_active($link['href']) !== '';
                $currentClass  = $isActive ? e($activeColor) : e($inactiveColor);
            ?>
            <a data-ajax-link
            data-active-class="<?= e($activeColor) ?>"
            data-inactive-class="<?= e($inactiveColor) ?>"
            href="<?= $href ?>"
            class="<?= $currentClass ?>">
                <?= $label ?>
            </a>
        <?php endforeach; ?>
    </nav>


</aside>

<div id="sidebar-backdrop"
     data-action="close-sidebar"
     class="fixed inset-0 z-20 bg-black/40 hidden md:hidden"></div>