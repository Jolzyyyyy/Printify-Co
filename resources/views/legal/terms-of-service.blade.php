<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terms of Service | Printify & Co.</title>
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
            <h1>Terms of Service</h1>
            <p class="meta">Last updated: June 2026</p>

            <p>These Terms of Service describe the basic rules for using the Printify & Co. website, customer account system, ordering features, payment flow, and support tools.</p>

            <h2>Use of the Website</h2>
            <p>You agree to use the website only for lawful printing, ordering, payment, and support purposes. You must not upload harmful files, abusive content, or materials that violate another person's rights.</p>

            <h2>Accounts and Security</h2>
            <ul>
                <li>You are responsible for keeping your account credentials private.</li>
                <li>OTP verification and role-based access controls are used to protect customer, staff, admin, and developer areas.</li>
                <li>Printify & Co. may restrict access when suspicious or unauthorized activity is detected.</li>
            </ul>

            <h2>Orders and Payments</h2>
            <p>Orders should be reviewed before checkout, including selected service, quantity, uploaded file, delivery or pickup option, and customer information. Payment processing may be handled by third-party providers such as PayMongo during capstone testing.</p>

            <h2>Pickup, Delivery, and Support</h2>
            <p>Store pickup and delivery details must be complete and accurate when required. If there is an issue with an order, customers may contact support for assistance.</p>

            <h2>Changes to These Terms</h2>
            <p>We may update these terms as the system improves. Continued use of the website means you accept the latest posted version.</p>

            <h2>Contact</h2>
            <p>For questions about these terms, visit our <a href="{{ route('landing.contactus') }}">Contact / Support page</a>.</p>
        </section>
    </main>
</body>
</html>
