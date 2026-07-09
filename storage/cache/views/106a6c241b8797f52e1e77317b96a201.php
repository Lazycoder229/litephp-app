<?php $this->layout = 'layout.app'; ?>

<?php $this->currentSection = 'title'; ob_start(); ?>
    Welcome — LitePHP
<?php $this->sections[$this->currentSection] = ob_get_clean(); $this->currentSection = null; ?>

<?php $this->currentSection = 'content'; ob_start(); ?>
    <div class="min-h-screen flex flex-col items-center justify-center text-center">
        <h1 class="text-5xl font-bold tracking-tight text-gray-900">
            Welcome to <span class="text-transparent bg-clip-text bg-gradient-to-r from-gray-400 to-gray-900">LitePHP</span>
        </h1>
       
    </div>
<?php $this->sections[$this->currentSection] = ob_get_clean(); $this->currentSection = null; ?>