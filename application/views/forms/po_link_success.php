<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="<?php echo $asset_url; ?>images/favicon.png">
<title><?php echo $title; ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background: #fff5f6; color: #1f2933; }
    .message-card {
        width: min(460px, calc(100vw - 28px));
        background: #fff;
        border: 1px solid #e4e7eb;
        border-radius: 8px;
        box-shadow: 0 12px 34px rgba(15, 23, 42, .08);
        padding: 34px;
        text-align: center;
    }
    .message-card img.logo { width: 120px; margin-bottom: 24px; }
    .message-card img.icon { width: 78px; margin-bottom: 20px; }
    .message-card h1 { font-size: 22px; font-weight: 700; margin-bottom: 12px; }
    .message-card p { color: #52606d; margin: 0; line-height: 1.55; }
</style>
</head>
<body>
<div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="message-card">
        <img class="logo" src="<?php echo $asset_url; ?>images/logo-new-no-background-2.png" alt="ChampionsDesk">
        <img class="icon" src="<?php echo $asset_url; ?>images/success-icon.png" alt="">
        <?php if ($status == 'accepted') { ?>
            <h1>Program Options Accepted</h1>
            <p>Thank you. Your acceptance has been recorded successfully.</p>
        <?php } else { ?>
            <h1>Program Options Rejected</h1>
            <p>Your response has been recorded successfully.</p>
        <?php } ?>
    </div>
</div>
</body>
</html>
