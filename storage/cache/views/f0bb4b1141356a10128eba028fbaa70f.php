<?php
    // $value ay pwedeng: 3  o  ['count' => 3, 'items' => [...]]
    $count = is_array($value) ? ($value['count'] ?? 0) : (int) $value;
    $items = is_array($value) ? ($value['items'] ?? []) : [];

    $iconColor  = $theme === 'dark' ? 'text-zinc-400 hover:text-zinc-100' : 'text-zinc-500 hover:text-zinc-900';
    $panelBg    = $theme === 'dark' ? 'bg-zinc-900 border-zinc-800' : 'bg-white border-zinc-200';
    $panelTitle = $theme === 'dark' ? 'text-zinc-100' : 'text-zinc-900';
    $panelText  = $theme === 'dark' ? 'text-zinc-400' : 'text-zinc-500';
    $itemBorder = $theme === 'dark' ? 'border-zinc-800' : 'border-zinc-100';
    $unreadBg   = $theme === 'dark' ? 'bg-zinc-800' : 'bg-zinc-50';
?>
<div class="relative">
    <button data-action="toggle-notif" class="relative <?= e($iconColor) ?> transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6.002 6.002 0 0 0-4-5.659V5a2 2 0 1 0-4 0v.341A6.002 6.002 0 0 0 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9"/>
        </svg>
        <?php if ($count > 0): ?>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs
                         rounded-full w-4 h-4 flex items-center justify-center">
                <?= $count ?>
            </span>
        <?php endif; ?>
    </button>

    <div id="notif-panel"
         class="hidden absolute right-0 mt-2 w-80 rounded-xl shadow-xl border z-50 <?= e($panelBg) ?>">

        <div class="px-4 py-3 border-b <?= e($itemBorder) ?>">
            <p class="text-sm font-semibold <?= e($panelTitle) ?>">Notifications</p>
        </div>

        <?php if (!empty($items)): ?>
            <?php foreach ($items as $notif): ?>
                <div class="px-4 py-3 border-b <?= e($itemBorder) ?> <?= !$notif['read'] ? e($unreadBg) : '' ?>">
                    <div class="flex items-start gap-2">
                        <?php if (!$notif['read']): ?>
                            <span class="mt-1.5 w-2 h-2 rounded-full bg-blue-500 shrink-0"></span>
                        <?php else: ?>
                            <span class="mt-1.5 w-2 h-2 shrink-0"></span>
                        <?php endif; ?>
                        <div>
                            <p class="text-sm <?= e($panelTitle) ?>"><?= e($notif['title']) ?></p>
                            <p class="text-xs <?= e($panelText) ?> mt-0.5"><?= e($notif['time']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="p-4">
                <p class="text-sm <?= e($panelText) ?>">No notifications yet.</p>
            </div>
        <?php endif; ?>

    </div>
</div>