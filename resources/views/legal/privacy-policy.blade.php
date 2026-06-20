<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Privacy Policy | Printify & Co.</title>
    <style>
        body{margin:0;background:#f7f7f7;color:#151515;font-family:Inter,Arial,sans-serif;line-height:1.6}
        .legal-wrap{max-width:920px;margin:0 auto;padding:44px 22px 56px}
        .legal-card{background:#fff;border:1px solid #e7e7e7;border-radius:12px;padding:34px;box-shadow:0 16px 45px rgba(15,23,42,.06)}
        a{color:#ff6b00;text-decoration:none;font-weight:700}
        a:hover{text-decoration:underline}
        h1{margin:0 0 8px;font-size:34px;line-height:1.1}
        h2{margin:28px 0 10px;font-size:19px}
        p,li{font-size:14px;color:#333}
        ul{padding-left:20px}
        .meta{margin:0 0 26px;color:#6b7280;font-size:13px}
        .back{display:inline-flex;margin-bottom:18px}
    </style>
</head>
<body>
    <main class="legal-wrap">
        <a class="back" href="{{ route('home') }}">Back to Home</a>
        <section class="legal-card">
            <h1>Privacy Policy</h1>
            <p class="meta">Last updated: June 2026</p>

            <p>Printify & Co. respects your privacy. This page explains the basic personal information we collect, why we use it, and how we protect it while providing printing, ordering, payment, and support services.</p>

            <h2>Information We Collect</h2>
            <ul>
                <li>Account details such as name, email address, phone number, and password-protected login information.</li>
                <li>Order and checkout details such as selected services, uploaded files, delivery option, shipping address, and payment status.</li>
                <li>Support messages, contact form submissions, and system activity needed to secure customer accounts.</li>
            </ul>

            <h2>How We Use Information</h2>
            <ul>
                <li>To create and manage customer accounts.</li>
                <li>To process orders, payments, receipts, pickup, and delivery requests.</li>
                <li>To send OTP codes, password reset messages, service updates, and customer support replies.</li>
                <li>To protect the system from unauthorized access, abuse, or fraud.</li>
            </ul>

            <h2>Data Sharing</h2>
            <p>We only share information when needed to complete a transaction or support request, such as with payment providers, delivery partners, email services, or authorized Printify & Co. staff. We do not sell customer personal data.</p>

            <h2>Security</h2>
            <p>We use authentication controls, OTP verification, role-based access, server protections, and limited staff access to help keep customer information secure.</p>

            <h2>Your Choices</h2>
            <p>You may contact us to request help with account information, privacy concerns, or support questions.</p>

            <h2>Contact</h2>
            <p>For privacy questions, visit our <a href="{{ route('landing.contactus') }}">Contact / Support page</a>.</p>
        </section>
    </main>
</body>
</html>
