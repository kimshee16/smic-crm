<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="<?php echo $asset_url; ?>images/favicon.png">
<title><?php echo $title; ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background: #fff5f6;
        color: #1f2933;
        user-select: none;
    }

    @media print {
        body { display: none; }
    }

    .review-card {
        width: min(920px, calc(100vw - 28px));
        background: #fff;
        border: 1px solid #e4e7eb;
        border-radius: 8px;
        box-shadow: 0 12px 34px rgba(15, 23, 42, .08);
        padding: 34px 42px 38px;
    }

    .brand-logo {
        width: 128px;
        height: auto;
        display: block;
        margin: 0 auto 28px;
    }

    .review-title {
        font-size: 24px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 14px;
    }

    .review-copy {
        max-width: 720px;
        margin: 0 auto 26px;
        text-align: center;
        color: #52606d;
        line-height: 1.65;
    }

    .pdf-shell {
        border: 1px solid #d9e2ec;
        border-radius: 8px;
        overflow: hidden;
        background: #f5f7fa;
        margin-bottom: 24px;
    }

    .pdf-viewer {
        width: 100%;
        height: 680px;
        border: 0;
        display: block;
    }

    .review-actions {
        display: flex;
        justify-content: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .review-actions form {
        margin: 0;
    }

    .review-actions .btn {
        min-width: 180px;
        height: 44px;
        border-radius: 6px;
        font-weight: 600;
    }
</style>
</head>
<body oncontextmenu="return false">
<div class="container my-5 d-flex justify-content-center">
    <div class="review-card">
        <img src="<?php echo $asset_url; ?>images/logo-new-no-background-2.png" alt="ChampionsDesk" class="brand-logo">
        <div class="review-title">Program Options Review</div>
        <p class="review-copy">
            Please review the Program Options document below carefully. If the proposed option is suitable for your study plans, kindly confirm your acceptance by selecting the Accept button.
        </p>

        <div class="pdf-shell">
            <iframe class="pdf-viewer" src="<?php echo $preview_url; ?>#toolbar=0&navpanes=0&scrollbar=0"></iframe>
        </div>

        <div class="review-actions">
            <form action="<?php echo base_url(); ?>index.php/accept_po_link" method="POST">
                <input type="hidden" name="po_link_id" value="<?php echo (int) $po_link->id; ?>">
                <input type="hidden" name="student_google_drive_id" value="<?php echo (int) $file->id; ?>">
                <button type="submit" class="btn btn-primary">Accept</button>
            </form>
            <form action="<?php echo base_url(); ?>index.php/reject_po_link" method="POST">
                <input type="hidden" name="po_link_id" value="<?php echo (int) $po_link->id; ?>">
                <input type="hidden" name="student_google_drive_id" value="<?php echo (int) $file->id; ?>">
                <button type="submit" class="btn btn-outline-secondary">Reject</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("keydown", function(event) {
    var key = (event.key || "").toLowerCase();
    if (
        event.key === "F12" ||
        (event.ctrlKey && event.shiftKey && ["i", "j", "c"].indexOf(key) !== -1) ||
        (event.ctrlKey && ["u", "s", "p"].indexOf(key) !== -1)
    ) {
        event.preventDefault();
        event.stopPropagation();
        return false;
    }
});

document.addEventListener("dragstart", function(event) {
    event.preventDefault();
});
</script>
</body>
</html>
