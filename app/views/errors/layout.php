<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Error' ?></title>
    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
        html { line-height: 1.15; -webkit-text-size-adjust: 100%; }
        body { margin: 0; }
        body { font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif; antialiased; background-color: #f3f4f6; color: #374151; height: 100vh; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .container { display: flex; align-items: center; }
        .code { border-right: 2px solid #e5e7eb; padding-right: 1.5rem; font-size: 2.25rem; font-weight: 300; letter-spacing: -0.05em; }
        .message { padding-left: 1.5rem; font-size: 1.125rem; font-weight: 300; text-transform: uppercase; letter-spacing: 0.05em; }
        .logo-container { position: absolute; top: 2rem; left: 50%; transform: translateX(-50%); }
        .logo-container img { height: 40px; opacity: 0.8; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.05)); }
        a { text-decoration: none; color: inherit; }
    </style>
</head>
<body>
    <div class="logo-container">
        <a href="<?= defined('BASEURL') ? BASEURL : '/' ?>">
            <img src="<?= defined('BASEURL') ? BASEURL : '' ?>/public/img/ICLabs-logo.webp" alt="ICLabs Logo">
        </a>
    </div>
    <div class="container">
        <div class="code">
            <?= $code ?? '500' ?>
        </div>
        <div class="message">
            <?= $message ?? 'Server Error' ?>
        </div>
    </div>
</body>
</html>
