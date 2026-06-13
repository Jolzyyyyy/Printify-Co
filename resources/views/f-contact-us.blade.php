<?php
$status = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $company = trim($_POST["company"] ?? "");
    $service = trim($_POST["service"] ?? "");
    $turnaround = trim($_POST["turnaround"] ?? "");
    $message = trim($_POST["message"] ?? "");

    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && $service && $message) {
        $record = [
            "name" => $name,
            "email" => $email,
            "phone" => $phone,
            "company" => $company,
            "service" => $service,
            "turnaround" => $turnaround,
            "message" => $message,
            "date_sent" => date("Y-m-d H:i:s")
        ];

        $file = __DIR__ . "/contact_inquiries.json";
        $data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
        if (!is_array($data)) $data = [];
        $data[] = $record;
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

        @mail("hello@printify.co", "New Inquiry from $name", $message, "From: $email");
        $status = "success";
    } else {
        $status = "error";
    }
}
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<section id="contact" class="contact-section">
    <div id="contactToast" class="contact-toast" role="status" aria-live="polite"></div>

    <div class="contact-container">
        <div class="contact-head">
            <span>GET IN TOUCH</span>
            <h2>Contact <b>Us</b></h2>
            <p>We're here to help! Send us your inquiry and our team will assist you as soon as possible.</p>
        </div>

        <?php if ($status === "success"): ?>
            <div class="alert success">Your message has been sent successfully.</div>
        <?php elseif ($status === "error"): ?>
            <div class="alert error">Please complete all required fields properly.</div>
        <?php endif; ?>

        <div class="contact-grid">
            <div class="contact-card main-box form-card">
                <div class="card-title">
                    <i class="fa-solid fa-paper-plane icon-orange"></i>
                    <div>
                        <h3>Send Us a Message</h3>
                        <p>Fill out the form below and we'll get back to you soon.</p>
                    </div>
                </div>

                <form method="POST" id="contactForm">
                    <div class="form-fields">
                        <div class="two-col">
                            <div class="form-row">
                            <span>Full Name:</span>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-user"></i>
                                    <input type="text" name="name" placeholder="Enter your full name" required>
                                </div>
                            </div>

                            <div class="form-row">
                            <span>Email Address:</span>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-envelope"></i>
                                    <input type="email" name="email" placeholder="Enter your email address" required>
                                </div>
                            </div>
                        </div>

                        <div class="two-col">
                            <div class="form-row">
                            <span>Phone Number:</span>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-phone"></i>
                                    <input type="tel" name="phone" placeholder="Enter your phone number">
                                </div>
                            </div>

                            <div class="form-row">
                            <span>Company Optional:</span>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-briefcase"></i>
                                    <input type="text" name="company" placeholder="Enter your company name">
                                </div>
                            </div>
                        </div>

                        <div class="two-col">
                            <div class="form-row">
                            <span>Service Interested In:</span>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-list-ul"></i>
                                    <select name="service" required>
                                        <option value="">Select a service</option>
                                        <option>Business Cards</option>
                                        <option>Tarpaulin Printing</option>
                                        <option>Stickers & Labels</option>
                                        <option>Invitation Printing</option>
                                        <option>Custom Design</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                            <span>Preferred Turnaround:</span>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-clock"></i>
                                    <select name="turnaround">
                                        <option value="">Select timeframe</option>
                                        <option>Rush Order</option>
                                        <option>1-2 Business Days</option>
                                        <option>3-5 Business Days</option>
                                        <option>Flexible</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-row message-row">
                        <span>Message:</span>
                            <div class="input-wrapper textarea-wrapper">
                                <i class="fa-solid fa-pencil"></i>
                                <textarea name="message" placeholder="Tell us about your project..." required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-bottom">
                        <small><i class="fa-solid fa-lock"></i> We respect your privacy.</small>
                        <button class="ui-btn orange-btn" type="submit">
                            <i class="fa-solid fa-paper-plane"></i>
                            Send Message
                        </button>
                    </div>
                </form>
            </div>

            <div class="middle-side">
                <div class="info-card no-box">
                    <div class="touch-box">
                        <h3><i class="fa-solid fa-headset icon-orange"></i> GET IN TOUCH</h3>

                        <p>
                            <i class="fa-solid fa-phone icon-green"></i>
                            <b>Call Us</b>
                            <span>+63 912 345 6789</span>
                            <small>Mon-Fri, 8:00 AM - 6:00 PM</small>
                        </p>

                        <p>
                            <i class="fa-solid fa-envelope icon-black"></i>
                            <b>Email Us</b>
                            <span>hello@printify.co</span>
                        </p>

                        <p>
                            <i class="fa-solid fa-message icon-black"></i>
                            <b>Live Chat</b>
                            <span>Available on website</span>
                            <small>Mon-Fri, 8:00 AM - 6:00 PM</small>
                        </p>

                        <p>
                            <i class="fa-solid fa-location-dot icon-red"></i>
                            <b>Visit Us</b>
                            <span>123 Printify Avenue, Makati City, Metro Manila</span>
                        </p>
                    </div>

                    <div class="hours-box">
                        <h3><i class="fa-regular fa-clock icon-orange"></i> OFFICE HOURS</h3>
                        <ul>
                            <li><span>Monday - Friday</span><b>8:00 AM - 6:00 PM</b></li>
                            <li><span>Saturday</span><b>9:00 AM - 3:00 PM</b></li>
                            <li><span>Sunday</span><b>Closed</b></li>
                            <li><span>Holidays</span><b>Closed</b></li>
                        </ul>

                        <h3><i class="fa-solid fa-share-nodes icon-blue"></i> FOLLOW US</h3>
                        <div class="socials">
                            <a href="https://facebook.com" target="_blank" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="https://instagram.com" target="_blank" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                            <a href="https://youtube.com" target="_blank" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                            <a href="https://linkedin.com" target="_blank" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>

                <div class="contact-card main-box branch-card">
                    <h3><i class="fa-solid fa-map-pin icon-orange"></i> OUR BRANCHES</h3>
                    <div class="branch-content">
                        <div class="branch-list">
                            <div class="branch-item">
                                <span>Makati Branch</span>
                                <span>123 Printify Avenue</span>
                                <small>Main Office</small>
                                <p><i class="fa-solid fa-clock"></i> Open Mon-Sat</p>
                                <p><i class="fa-solid fa-print"></i> Printing, design, pickup</p>
                            </div>

                            <div class="branch-item">
                                <span>Quezon City Branch</span>
                                <span>45 Timog Avenue</span>
                                <small>Branch Office</small>
                                <p><i class="fa-solid fa-clock"></i> Open Mon-Sat</p>
                                <p><i class="fa-solid fa-box"></i> Orders, pickup, inquiries</p>
                            </div>
                        </div>

                        <div class="branch-notes">
                            <div>
                                <p><i class="fa-regular fa-clock icon-blue"></i> Same-day assistance available for selected services.</p>
                                <p><i class="fa-solid fa-phone icon-purple"></i> Contact us before visiting for bulk and rush orders.</p>
                            </div>
                            <button class="ui-btn black-btn" type="button" onclick="openMap()">
                                Get Directions
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <aside class="contact-extra">
                <div class="quick-answer-card no-box">
                    <h3><i class="fa-solid fa-circle-question icon-orange"></i> QUICK ANSWERS</h3>

                    <button type="button" onclick="contactQuickAnswer('Turnaround Time')">
                        <span><i class="fa-solid fa-truck-fast icon-blue"></i></span>
                        <span>Turnaround Time</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                    <button type="button" onclick="contactQuickAnswer('Request a Quote')">
                        <span><i class="fa-solid fa-file-lines icon-green"></i></span>
                        <span>Request a Quote</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                    <button type="button" onclick="contactQuickAnswer('File Guide')">
                        <span><i class="fa-solid fa-cube icon-purple"></i></span>
                        <span>File & Design Guide</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>

                <div class="map-card no-box">
                    <div class="map-head">
                        <h3><i class="fa-solid fa-map-location-dot icon-orange"></i> GET DIRECTIONS</h3>
                        <p>Find us easily. Open in your favorite map app.</p>
                        <button class="ui-btn orange-btn" type="button" onclick="openMap()">
                            Open in Maps
                            <i class="fa-solid fa-up-right-from-square"></i>
                        </button>
                    </div>

                    <div class="map-frame">
                        <iframe title="Printify & Co. location map" src="https://www.google.com/maps?q=Makati%20City%20Metro%20Manila%20Philippines&output=embed" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

<footer class="printify-footer">
    <div class="footer-top-line"></div>

    <div class="footer-main">
        <div class="footer-col footer-brand">
            <h2 class="printify-wordmark">PRINTIFY &amp; CO.</h2>
            <h4>CRAFTING YOUR VISION INTO REALITY</h4>
            <p>
                <span>High-quality printing &amp; design solutions</span><br>
                <span>tailored to bring your ideas to life.</span>
            </p>
        </div>

        <div class="footer-col footer-quick">
            <h3>QUICK LINKS</h3>
            <span class="footer-title-line"></span>

            <div class="footer-links footer-links-row">
                <a href="#"><i class="fa-solid fa-chevron-right"></i> Home</a>
                <a href="#"><i class="fa-solid fa-chevron-right"></i> Services</a>
                <a href="#"><i class="fa-solid fa-chevron-right"></i> About Us</a>
                <a href="#contact"><i class="fa-solid fa-chevron-right"></i> Contact Us</a>
            </div>
        </div>

        <div class="footer-col footer-contact-info">
            <h3>CONTACT INFO</h3>
            <span class="footer-title-line"></span>

            <div class="footer-contact-list">
                <p><i class="fa-solid fa-phone"></i> <span>+63 912 345 6789</span></p>
                <p><i class="fa-solid fa-envelope"></i> <span>hello@printify.co</span></p>
                <p><i class="fa-regular fa-clock"></i> <span>Mon – Fri <b>|</b> 9:00 AM – 6:00 PM</span></p>
            </div>
        </div>

        <div class="footer-col footer-policy">
            <h3>POLICIES</h3>
            <span class="footer-title-line"></span>

            <div class="footer-links policy-grid">
                <a href="#"><i class="fa-solid fa-chevron-right"></i> Privacy Policy</a>
                <a href="#"><i class="fa-solid fa-chevron-right"></i> Sitemap</a>
                <a href="#"><i class="fa-solid fa-chevron-right"></i> Terms &amp; Conditions</a>
                <a href="#"><i class="fa-solid fa-chevron-right"></i> Refund Policy</a>
            </div>
        </div>

        <div class="footer-col footer-follow">
            <h3>FOLLOW US</h3>
            <span class="footer-title-line"></span>

            <div class="footer-socials">
                <a href="https://facebook.com" target="_blank" class="facebook" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="https://instagram.com" target="_blank" class="instagram" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="https://youtube.com" target="_blank" class="youtube" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                <a href="https://linkedin.com" target="_blank" class="linkedin" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>© 2026 <span class="printify-wordmark">Printify &amp; Co.</span> All rights reserved.</p>
    </div>
</footer>

<style>
:root {
    --orange: #ff6a00;
    --black: #111111;
    --text: #151515;
    --muted: #515761;
    --line: #e2e6ee;
}

* { box-sizing: border-box; }

.contact-section {
    width: 100%;
    background: #ffffff;
    color: var(--text);
    padding: 42px 18px 70px 100px;
    font-family: "Inter", Arial, sans-serif;
    font-weight: 400;
    letter-spacing: 0;
}

.contact-container {
    width: 100%;
    max-width: 1450px;
    margin: 0;
}

.contact-head { margin-bottom: 20px; }

.contact-head span {
    display: block;
    color: var(--orange);
    font-family: "Poppins", Arial, sans-serif;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 1.4px;
    text-transform: uppercase;
    margin-bottom: 7px;
}

.contact-head h2 {
    margin: 0 0 8px;
    color: #000;
    font-family: "Playfair Display", Georgia, serif;
    font-size: 48px;
    line-height: .96;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0;
}

.contact-head h2 b { color: var(--orange); font-weight: 700; }

.contact-head p,
.card-title p,
.map-head p,
.form-bottom small,
.branch-notes p,
.branch-item p,
.branch-list span,
.info-card p,
.info-card p small,
.info-card li {
    font-family: "Inter", Arial, sans-serif;
    font-weight: 400;
    letter-spacing: 0;
}

.contact-head p {
    margin: 0;
    color: #303743;
    font-size: 14px;
    line-height: 1.45;
}

.alert {
    width: fit-content;
    padding: 10px 14px;
    border-radius: 10px;
    margin: 0 0 18px;
    font-family: "Poppins", Arial, sans-serif;
    font-size: 12px;
    font-weight: 600;
}

.alert.success { background: #e9fff0; color: #157a3f; border: 1px solid #b8f3ca; }
.alert.error { background: #fff0f0; color: #b42318; border: 1px solid #ffd1d1; }

.contact-toast {
    position: fixed;
    top: 94px;
    left: 50%;
    transform: translate(-50%, -15px);
    z-index: 9999;
    min-width: 280px;
    max-width: 440px;
    padding: 13px 22px;
    border-radius: 18px;
    background: #111827;
    color: #ffffff;
    text-align: center;
    font-family: "Inter", Arial, sans-serif;
    font-size: 13px;
    line-height: 1.35;
    opacity: 0;
    pointer-events: none;
    box-shadow: 0 18px 40px rgba(0, 0, 0, .22);
    transition: opacity .2s ease, transform .2s ease;
}

.contact-toast.show { opacity: 1; transform: translate(-50%, 0); }

.contact-grid {
    display: grid;
    grid-template-columns: 420px 705px 360px;
    gap: 22px;
    align-items: stretch;
}

.contact-card,
.no-box {
    background: #ffffff;
    border-radius: 10px;
}

.main-box {
    border: 1px solid #000000;
    box-shadow: none;
}

.form-card,
.middle-side,
.contact-extra { min-height: 565px; }

.form-card {
    padding: 20px 15px 18px;
    display: flex;
    flex-direction: column;
}

.form-card form {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 0;
}

.card-title {
    display: flex;
    align-items: center;
    gap: 13px;
    margin-bottom: 22px;
}

.card-title > i {
    width: 44px;
    height: 44px;
    display: grid;
    place-items: center;
    font-size: 25px;
    flex: 0 0 auto;
}

.card-title h3,
.info-card h3,
.branch-card h3,
.quick-answer-card h3,
.map-card h3 {
    margin: 0;
    color: #151515;
    font-family: "Poppins", Arial, sans-serif;
    font-weight: 600;
    letter-spacing: 0;
}

.card-title h3 { font-size: 21px; margin-bottom: 5px; line-height: 1.05; }
.card-title p { margin: 0; color: #303743; font-size: 10.8px; line-height: 1.35; }

.form-fields { display: flex; flex-direction: column; gap: 18px; flex: 1; }
.two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.form-row { display: flex; flex-direction: column; }

.form-row label {
    font-family: "Poppins", Arial, sans-serif;
    font-size: 11px;
    color: #181818;
    font-weight: 600;
    margin-bottom: 8px;
    letter-spacing: 0;
}

.input-wrapper { position: relative; display: flex; align-items: center; }
.input-wrapper i { position: absolute; left: 13px; color: #1b1b1b; font-size: 13px; pointer-events: none; z-index: 2; }

.input-wrapper input,
.input-wrapper select,
.input-wrapper textarea {
    width: 100%;
    height: 43px;
    border: 1px solid #d9dee7;
    border-radius: 8px;
    background: #ffffff;
    color: #111827;
    font-family: "Inter", Arial, sans-serif;
    font-size: 11.5px;
    font-weight: 400;
    letter-spacing: 0;
    outline: none;
    padding: 10px 12px 10px 38px;
    transition: border-color .18s ease, box-shadow .18s ease;
}

.input-wrapper select { cursor: pointer; appearance: auto; }
.textarea-wrapper { align-items: flex-start; }
.textarea-wrapper i { top: 15px; font-size: 13px; }
.input-wrapper textarea { height: 130px; min-height: 130px; resize: none; line-height: 1.45; padding-top: 14px; }
.message-row { flex: 1; }

.input-wrapper input:focus,
.input-wrapper select:focus,
.input-wrapper textarea:focus {
    border-color: var(--orange);
    box-shadow: 0 0 0 3px rgba(255, 106, 0, .11);
}

.form-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    margin-top: 21px;
}

.form-bottom small { display: inline-flex; align-items: center; gap: 8px; color: #575b63; font-size: 12px; }
.form-bottom small i { color: #1a1a1a; }

.ui-btn {
    width: 160px;
    height: 40px;
    border: 0;
    border-radius: 8px;
    cursor: pointer;
    font-family: "Poppins", Arial, sans-serif;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    white-space: nowrap;
    transition: transform .18s ease, background .18s ease, color .18s ease;
}

.orange-btn { background: var(--orange); color: #000000; }
.black-btn { background: #111827; color: #ffffff; }
.ui-btn:hover { background: #111827; color: #ffffff; transform: translateY(-1px); }
.black-btn:hover { background: var(--orange); color: #000000; }

.middle-side { display: flex; flex-direction: column; gap: 20px; }

.info-card {
    height: 342px;
    padding: 16px 0;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.touch-box { padding: 0 17px 0 0; border-right: 1px solid var(--line); }
.hours-box { padding: 0 0 0 13px; }

.info-card h3 {
    font-size: 15px;
    line-height: 1.2;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.info-card h3 i { font-size: 22px; }

.info-card p {
    position: relative;
    margin: 0 0 14px;
    padding-left: 37px;
    font-size: 12px;
    color: #1f2937;
    line-height: 1.3;
}

.info-card p > i { position: absolute; left: 0; top: 2px; width: 24px; text-align: center; font-size: 19px; }
.info-card p b,
.info-card p span,
.info-card p small { display: block; }
.info-card p b { color: #121212; font-family: "Poppins", Arial, sans-serif; font-weight: 600; margin-bottom: 3px; }
.info-card p span { color: #1f2937; }
.info-card p small { color: #202020; font-size: 11px; }

.info-card ul { list-style: none; margin: 0 0 14px; padding: 0; }
.info-card li { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 12px 0; border-bottom: 1px solid var(--line); color: #1f2937; font-size: 11.5px; }
.info-card li:first-child { padding-top: 4px; }
.info-card li span { white-space: nowrap; }
.info-card li b { color: #111827; font-family: "Poppins", Arial, sans-serif; font-weight: 600; white-space: nowrap; }

.socials { display: flex; align-items: center; gap: 10px; }
.socials a { width: 36px; height: 36px; border-radius: 50%; display: grid; place-items: center; text-decoration: none; color: #fff; font-size: 17px; transition: transform .18s ease; }
.socials a:hover { transform: translateY(-2px); }
.socials a:nth-child(1) { background: #1877f2; }
.socials a:nth-child(2) { background: #e4405f; }
.socials a:nth-child(3) { background: #ff0000; }
.socials a:nth-child(4) { background: #0a66c2; }

.branch-card { flex: 1; min-height: 203px; padding: 18px 19px; }
.branch-card h3 { font-size: 18px; display: flex; align-items: center; gap: 10px; }
.branch-card h3 i { font-size: 26px; }
.branch-content { display: grid; grid-template-columns: 1fr 205px; gap: 28px; margin-top: 20px; }
.branch-list { display: grid; grid-template-columns: 1fr 1fr; gap: 26px; }
.branch-list b,
.branch-list span,
.branch-list small { display: block; }
.branch-list b { color: #111827; font-family: "Poppins", Arial, sans-serif; font-size: 12px; font-weight: 600; margin-bottom: 8px; }
.branch-list span { color: #303743; font-size: 11px; margin-bottom: 10px; line-height: 1.35; }
.branch-list small { width: fit-content; color: #0b73e8; font-family: "Poppins", Arial, sans-serif; font-size: 10px; font-weight: 600; margin-bottom: 12px; line-height: 1.3; }
.branch-item p { margin: 0 0 9px; color: #303743; font-size: 11px; line-height: 1.38; display: flex; align-items: flex-start; gap: 8px; }
.branch-item p i { color: var(--orange); width: 14px; text-align: center; flex: 0 0 auto; margin-top: 1px; }
.branch-notes { display: flex; flex-direction: column; justify-content: space-between; min-height: 148px; }
.branch-notes p { margin: 0 0 14px; color: #303743; font-size: 11.3px; line-height: 1.5; display: flex; align-items: flex-start; gap: 10px; }
.branch-notes p i { margin-top: 3px; width: 16px; text-align: center; flex: 0 0 auto; }
.branch-card button { align-self: flex-end; }

.contact-extra { display: flex; flex-direction: column; gap: 20px; }
.quick-answer-card { height: 213px; padding: 20px 0 16px; }
.quick-answer-card h3 { font-size: 16px; margin-bottom: 17px; display: flex; align-items: center; gap: 10px; }
.quick-answer-card h3 i { font-size: 24px; }

.quick-answer-card button {
    width: 100%;
    height: 53px;
    border: 0;
    border-bottom: 1px solid var(--line);
    background: transparent;
    display: grid;
    grid-template-columns: 34px 1fr 14px;
    align-items: center;
    gap: 11px;
    text-align: left;
    cursor: pointer;
    padding: 0 5px;
    color: #111827;
    border-radius: 0;
    transition: background .18s ease, color .18s ease;
}

.quick-answer-card button:last-child { border-bottom: 0; }
.quick-answer-card button span { width: 28px; height: 28px; display: grid; place-items: center; border-radius: 8px; }
.quick-answer-card button span i { font-size: 20px; }
.quick-answer-card button b { color: inherit; font-family: "Poppins", Arial, sans-serif; font-size: 12px; font-weight: 600; letter-spacing: 0; }
.quick-answer-card button > i { color: inherit; font-size: 13px; }
.quick-answer-card button:hover { background: #111827; color: #ffffff; border-bottom-color: #111827; }
.quick-answer-card button:hover i { color: #ffffff !important; }

.map-card { flex: 1; min-height: 332px; padding: 18px 0 0; display: flex; flex-direction: column; }
.map-head h3 { font-size: 18px; display: flex; align-items: center; gap: 10px; margin-bottom: 9px; }
.map-head h3 i { font-size: 27px; }
.map-head p { margin: 0 0 13px; color: var(--muted); font-size: 12px; line-height: 1.4; }
.map-card button { margin-bottom: 18px; }

.map-frame {
    width: 100%;
    flex: 1;
    min-height: 184px;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid #dde3ec;
    background: #edf2f7;
}

.map-frame iframe { width: 100%; height: 100%; border: 0; display: block; pointer-events: auto; touch-action: auto; }

.icon-orange { color: var(--orange) !important; }
.icon-black { color: #111111 !important; }
.icon-green { color: #22c55e !important; }
.icon-red { color: #ef233c !important; }
.icon-blue { color: #1888ff !important; }
.icon-purple { color: #7c3aed !important; }

@media (max-width: 1320px) {
    .contact-section { padding-left: 40px; padding-right: 30px; }
    .contact-grid { grid-template-columns: 400px 1fr 340px; gap: 18px; }
}

@media (max-width: 1180px) {
    .contact-section { padding: 32px 22px 55px; }
    .contact-container { max-width: 100%; margin: 0 auto; }
    .contact-grid { grid-template-columns: 1fr; }
    .form-card,
    .middle-side,
    .contact-extra { min-height: auto; }
    .info-card { height: auto; min-height: 320px; }
    .branch-card { min-height: auto; }
    .contact-extra { display: grid; grid-template-columns: 1fr 1fr; align-items: stretch; }
    .quick-answer-card,
    .map-card { height: auto; min-height: 260px; }
}

@media (max-width: 760px) {
    .contact-section { padding: 25px 14px 45px; }
    .contact-head h2 { font-size: 38px; }
    .contact-grid { gap: 18px; }
    .two-col,
    .info-card,
    .branch-content,
    .branch-list,
    .contact-extra { grid-template-columns: 1fr; }
    .info-card { display: grid; }
    .touch-box { padding-right: 0; border-right: 0; border-bottom: 1px solid var(--line); padding-bottom: 16px; }
    .hours-box { padding-left: 0; }
    .branch-card button { align-self: flex-start; }
    .form-bottom { align-items: flex-start; flex-direction: column; }
    .form-bottom button { align-self: flex-end; }
    .map-frame { min-height: 220px; }
}


/* FOOTER DESIGN - COMPACT & CLEAN */
.printify-footer {
    width: 100%;
    background: #080808;
    color: #ffffff;
    font-family: "Inter", Arial, sans-serif;
    overflow: hidden;
    box-shadow: 0 -14px 40px rgba(0, 0, 0, 0.16);
}

.footer-top-line {
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, #ff6a00 0%, #ff7a14 50%, #ff6a00 100%);
}

.footer-main {
    width: 100%;
    padding: 10px 70px 8px;
    display: grid;
    grid-template-columns: 1.14fr 1.55fr 1.44fr 1.62fr 1.30fr;
    align-items: flex-start;
    gap: 24px;
    background:
        radial-gradient(circle at 8% 0%, rgba(255, 106, 0, .08), transparent 28%),
        #080808;
}

.footer-col {
    min-height: 70px;
    padding-left: 24px;
    border-left: 1px solid rgba(255, 255, 255, 0.22);
}

.footer-brand {
    padding-left: 0;
    border-left: none;
}

.footer-brand h2 {
    margin: 0 0 8px;
    color: #ffffff;
    font-family: "Poppins", Arial, sans-serif;
    font-size: 24px;
    line-height: .92;
    font-weight: 800;
    letter-spacing: -1.4px;
    text-transform: uppercase;
}

.footer-brand h4 {
    margin: 0 0 8px;
    color: #ff6a00;
    font-family: "Poppins", Arial, sans-serif;
    font-size: 9px;
    line-height: 1;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.footer-brand h4 {
    white-space: nowrap;
}

.footer-brand p {
    margin: 0;
    max-width: none;
    color: #f2f2f2;
    font-size: 12.5px;
    line-height: 1.35;
    font-weight: 400;
}

.footer-brand p span {
    white-space: nowrap;
}

.footer-col h3 {
    margin: 0;
    color: #ffffff;
    font-family: "Poppins", Arial, sans-serif;
    font-size: 17px;
    line-height: 1;
    font-weight: 800;
    letter-spacing: 2.5px;
    text-transform: uppercase;
}

.footer-title-line {
    display: block;
    width: 40px;
    height: 3px;
    margin: 9px 0 11px;
    background: #ff6a00;
    border-radius: 20px;
    box-shadow: 0 0 12px rgba(255, 106, 0, .45);
}

.footer-links {
    display: flex;
    gap: 18px;
    align-items: center;
}

.footer-links a,
.footer-contact-list p {
    color: #f5f5f5;
    text-decoration: none;
    font-size: 13px;
    line-height: 1.15;
    font-weight: 400;
    display: flex;
    align-items: center;
    gap: 9px;
    white-space: nowrap;
    transition: color .2s ease, transform .2s ease;
}

.footer-links a i {
    color: #ff6a00;
    font-size: 12px;
}

.footer-links a:hover {
    color: #ff6a00;
    transform: translateX(3px);
}

.footer-contact-info .footer-title-line {
    margin: 7px 0 8px;
}

.footer-contact-list {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.footer-contact-list p {
    margin: 0;
}

.footer-contact-list i {
    width: 19px;
    min-width: 19px;
    height: 19px;
    color: #ff6a00;
    font-size: 15px;
    text-align: center;
    display: grid;
    place-items: center;
}

.footer-contact-list b {
    color: #ff6a00;
    padding: 0 5px;
    font-weight: 800;
}

.policy-grid {
    display: grid;
    grid-template-columns: max-content max-content;
    gap: 10px 18px;
}

.footer-policy {
    padding-left: 26px;
}

.footer-policy .footer-links a {
    font-size: 13px;
    gap: 8px;
    white-space: nowrap;
}

.footer-quick .footer-links-row {
    gap: 15px;
}

.footer-quick .footer-links-row a {
    gap: 10px;
}

.footer-socials {
    display: flex;
    align-items: center;
    gap: 9px;
    flex-wrap: nowrap;
    white-space: nowrap;
}

.footer-follow {
    min-width: 175px;
    padding-left: 18px;
}

.footer-follow h3 {
    white-space: nowrap;
}

.footer-socials a {
    width: 31px;
    height: 31px;
    border-radius: 50%;
    display: grid;
    place-items: center;
    color: #ffffff;
    text-decoration: none;
    font-size: 13px;
    box-shadow: 0 8px 18px rgba(0, 0, 0, .22);
    transition: transform .2s ease, opacity .2s ease, box-shadow .2s ease;
}

.footer-socials a:hover {
    transform: translateY(-3px);
    opacity: .95;
    box-shadow: 0 12px 22px rgba(0, 0, 0, .32);
}

.footer-socials .facebook { background: #1877f2; }
.footer-socials .instagram { background: #e4405f; }
.footer-socials .youtube { background: #ff0000; }
.footer-socials .linkedin { background: #0a66c2; }

.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.12);
    padding: 5px 70px;
    background: #080808;
}

.footer-bottom p {
    margin: 0;
    color: #f1f1f1;
    font-size: 12px;
    font-weight: 400;
}

.footer-bottom span {
    color: #ff6a00;
    font-weight: 800;
}

@media (max-width: 1500px) {
    .footer-main {
        padding: 10px 45px 8px;
        gap: 24px;
        grid-template-columns: 1.16fr 1.58fr 1.48fr 1.86fr 1.08fr;
    }

    .footer-col { padding-left: 20px; min-height: 70px; }
    .footer-brand h2 { font-size: 25px; }
    .footer-brand h4 { font-size: 8px; letter-spacing: 1px; white-space: nowrap; margin-bottom: 7px; }
    .footer-brand p { font-size: 12px; line-height: 1.32; }
    .footer-col h3 { font-size: 15px; letter-spacing: 2px; }
    .footer-title-line { margin: 8px 0 10px; }

    .footer-links a,
    .footer-contact-list p { font-size: 11.8px; }
    .footer-policy .footer-links a { font-size: 11.2px; gap: 6px; }
    .footer-quick .footer-links-row { gap: 10px; }
    .policy-grid { gap: 8px 12px; }

    .footer-socials a {
        width: 30px;
        height: 30px;
        font-size: 13px;
    }

    .footer-bottom { padding: 5px 45px; }
}

@media (max-width: 1180px) {
    .footer-main {
        grid-template-columns: 1fr 1fr;
        gap: 25px 22px;
    }

    .footer-col { min-height: auto; }
    .footer-follow { border-left: none; padding-left: 0; }
}

@media (max-width: 760px) {
    .footer-main {
        grid-template-columns: 1fr;
        padding: 30px 24px 25px;
        gap: 25px;
    }

    .footer-col {
        border-left: none;
        padding-left: 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.14);
        padding-bottom: 22px;
    }

    .footer-follow {
        border-bottom: none;
        padding-bottom: 0;
    }

    .footer-links {
        flex-direction: column;
        align-items: flex-start;
        gap: 14px;
    }

    .policy-grid { grid-template-columns: 1fr; }
    .footer-bottom { padding: 12px 24px; }
}



/* FINAL CONTACT + FOOTER CONSISTENCY PATCH */
:root{
    --ui-orange-start:#FE7B09;
    --ui-orange-end:#FFAB0A;
    --ui-orange:#ff8a00;
    --ui-black:#111827;
    --ui-hover-soft:rgba(17,24,39,.13);
    --ui-hover-blur:rgba(17,24,39,.07);
    --ui-line:#111827;
    --ui-muted:#6b7280;
}

/* buttons: same size/color/shape/hover as the other customer sections */
.contact-section .ui-btn,
.printify-footer .ui-btn,
.contact-section button.ui-btn,
.contact-section a.ui-btn{
    width:auto!important;
    min-width:104px!important;
    height:34px!important;
    padding:8px 16px!important;
    border:0!important;
    border-radius:999px!important;
    background:linear-gradient(90deg,var(--ui-orange-start),var(--ui-orange-end))!important;
    color:#111827!important;
    font-family:"Poppins",Arial,sans-serif!important;
    font-size:11px!important;
    font-weight:500!important;
    line-height:1!important;
    letter-spacing:0!important;
    text-transform:none!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:7px!important;
    white-space:nowrap!important;
    box-shadow:none!important;
    transform:none!important;
    transition:background .18s ease,color .18s ease,border-color .18s ease,box-shadow .18s ease!important;
}
.contact-section .ui-btn:hover,
.contact-section .ui-btn:focus,
.printify-footer .ui-btn:hover,
.printify-footer .ui-btn:focus{
    background:var(--ui-black)!important;
    color:#ffffff!important;
    border-color:var(--ui-black)!important;
    box-shadow:none!important;
    transform:none!important;
    outline:0!important;
}
.contact-section .ui-btn:hover i,
.contact-section .ui-btn:focus i{
    color:#ffffff!important;
}
.contact-section .form-bottom{
    align-items:center!important;
}
.contact-section .form-bottom .ui-btn{
    min-width:132px!important;
}
.contact-section .map-card .ui-btn,
.contact-section .branch-notes .ui-btn{
    min-width:124px!important;
    align-self:center!important;
}

/* consistent icon colors across sections */
.contact-section .icon-orange,
.printify-footer .footer-links a i,
.printify-footer .footer-contact-list i,
.printify-footer .footer-title-line{
    color:var(--ui-orange)!important;
}
.contact-section .icon-green{color:#16a34a!important}
.contact-section .icon-blue{color:#2563eb!important}
.contact-section .icon-purple{color:#7c3aed!important}
.contact-section .icon-red{color:#ef4444!important}
.contact-section .icon-black{color:#111827!important}

.contact-section .fa-phone,
.printify-footer .fa-phone{color:#16a34a!important}
.contact-section .fa-envelope,
.printify-footer .fa-envelope{color:#2563eb!important}
.contact-section .fa-clock,
.printify-footer .fa-clock{color:var(--ui-orange)!important}
.contact-section .fa-location-dot,
.contact-section .fa-map-pin,
.contact-section .fa-map-location-dot{color:#ef4444!important}
.contact-section .fa-headset,
.contact-section .fa-message,
.contact-section .fa-comment-dots{color:#111827!important}
.contact-section .fa-truck-fast,
.contact-section .fa-truck{color:#7c3aed!important}
.contact-section .fa-file-lines,
.contact-section .fa-list-ul{color:#16a34a!important}
.contact-section .fa-cube,
.contact-section .fa-share-nodes{color:#7c3aed!important}
.contact-section .fa-paper-plane,
.contact-section .fa-circle-question{color:var(--ui-orange)!important}

/* no unnecessary movement; same subtle hover language */
.contact-card,
.no-box,
.info-card,
.quick-answer-card,
.map-card,
.branch-card,
.branch-item,
.footer-links a,
.footer-socials a,
.quick-answer-card button{
    transform:none!important;
}
.contact-card:hover,
.info-card:hover,
.map-card:hover,
.quick-answer-card:hover{
    background:#ffffff!important;
    box-shadow:none!important;
}
.input-wrapper input:hover,
.input-wrapper select:hover,
.input-wrapper textarea:hover,
.quick-answer-card button:hover,
.branch-item:hover,
.footer-links a:hover,
.footer-contact-list p:hover{
    background:linear-gradient(180deg,rgba(17,24,39,.10),rgba(17,24,39,.06))!important;
    color:#111827!important;
    transform:none!important;
}
.quick-answer-card button:hover i{
    color:inherit!important;
}
.quick-answer-card button:hover b,
.quick-answer-card button:focus b{
    color:#111827!important;
}
.quick-answer-card button:focus{
    outline:0!important;
    background:linear-gradient(180deg,rgba(17,24,39,.10),rgba(17,24,39,.06))!important;
}

/* Our Branches: no visible main box, just cleaner spacing */
.branch-card,
.branch-card.main-box{
    border:0!important;
    box-shadow:none!important;
    background:transparent!important;
    padding:0!important;
    border-radius:0!important;
    min-height:auto!important;
}
.branch-card h3{
    margin-bottom:0!important;
}
.branch-content{
    margin-top:22px!important;
    gap:38px!important;
    align-items:start!important;
    grid-template-columns:minmax(0,1fr) 215px!important;
}
.branch-list{
    gap:34px!important;
}
.branch-item{
    padding:3px 0!important;
}
.branch-item + .branch-item{
    padding-left:20px!important;
    border-left:1px solid #eef1f5!important;
}
.branch-item b{
    margin-bottom:10px!important;
}
.branch-item span,
.branch-item small{
    margin-bottom:12px!important;
}
.branch-item p{
    margin-bottom:10px!important;
    line-height:1.42!important;
    align-items:flex-start!important;
}
.branch-notes{
    min-height:154px!important;
    gap:18px!important;
}
.branch-notes p{
    margin-bottom:16px!important;
    line-height:1.52!important;
}

/* quick answer rows: cleaner, consistent, no heavy black hover */
.quick-answer-card button{
    border-radius:8px!important;
    padding:0 8px!important;
    border-bottom:1px solid #eef1f5!important;
    transition:background .18s ease,color .18s ease,border-color .18s ease!important;
}
.quick-answer-card button span{
    background:transparent!important;
}
.quick-answer-card button b{
    font-weight:500!important;
}

/* footer: compact but not cramped, no redundant motion */
.printify-footer{
    box-shadow:none!important;
}
.footer-top-line{
    background:linear-gradient(90deg,var(--ui-orange-start),var(--ui-orange-end))!important;
}
.footer-main{
    gap:30px!important;
    padding:16px 70px 14px!important;
}
.footer-col{
    min-height:82px!important;
}
.footer-links{
    gap:16px 20px!important;
}
.footer-links a,
.footer-contact-list p{
    transition:color .18s ease,background .18s ease!important;
    border-radius:8px!important;
    padding:2px 0!important;
}
.footer-links a:hover,
.footer-contact-list p:hover{
    color:#ffffff!important;
    transform:none!important;
}
.footer-socials{
    gap:10px!important;
}
.footer-socials a{
    box-shadow:none!important;
    transition:background .18s ease,color .18s ease,border-color .18s ease!important;
}
.footer-socials a:hover{
    transform:none!important;
    filter:brightness(.92)!important;
}
.footer-bottom{
    padding-top:10px!important;
    padding-bottom:10px!important;
}

/* responsive spacing preservation */
@media (max-width:1180px){
    .branch-card,
    .branch-card.main-box{
        padding:0!important;
    }
    .branch-item + .branch-item{
        padding-left:0!important;
        border-left:0!important;
    }
    .branch-content{
        grid-template-columns:1fr!important;
    }
    .footer-main{
        padding:24px 30px!important;
        gap:26px!important;
    }
}


/* FINAL MAP RESTORE: original interactive Google map behavior */
.map-card,
.map-card.no-box{
    position:relative!important;
    display:flex!important;
    flex-direction:column!important;
    gap:16px!important;
    background:#ffffff!important;
    border:0!important;
    box-shadow:none!important;
    padding:0!important;
    overflow:visible!important;
}

.map-head{
    position:relative!important;
    z-index:1!important;
}

.map-frame{
    position:relative!important;
    z-index:1!important;
    width:100%!important;
    min-height:235px!important;
    height:235px!important;
    border:1px solid #dde3ec!important;
    border-radius:10px!important;
    overflow:hidden!important;
    background:#edf2f7!important;
    pointer-events:auto!important;
    touch-action:auto!important;
}

.map-frame iframe{
    width:100%!important;
    height:100%!important;
    min-height:235px!important;
    display:block!important;
    border:0!important;
    pointer-events:auto!important;
    touch-action:auto!important;
    user-select:auto!important;
}

/* make sure no decorative layer blocks map drag/zoom/click */
.map-frame::before,
.map-frame::after,
.map-card::before,
.map-card::after{
    content:none!important;
    display:none!important;
    pointer-events:none!important;
}

/* spacing polish for map + right contact column */
.contact-extra{
    display:flex!important;
    flex-direction:column!important;
    gap:24px!important;
}

.quick-answer-card{
    margin-bottom:2px!important;
}

.map-head p{
    margin-bottom:12px!important;
}

.map-card .ui-btn{
    margin-bottom:0!important;
}

</style>

<script>
const contactToast = document.getElementById("contactToast");
const contactForm = document.getElementById("contactForm");
let contactToastTimer;

function showContactFeedback(message) {
    if (!contactToast) return;
    contactToast.textContent = message;
    contactToast.classList.add("show");
    clearTimeout(contactToastTimer);
    contactToastTimer = setTimeout(() => contactToast.classList.remove("show"), 2600);
}

window.addEventListener("printify-front-feedback", event => {
    showContactFeedback(event.detail?.message || "Action completed.");
});

if (contactForm) {
    contactForm.addEventListener("submit", function(e) {
        const requiredFields = contactForm.querySelectorAll("[required]");
        let valid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.style.borderColor = "#d60000";
                valid = false;
            } else {
                field.style.borderColor = "#d9dee7";
            }
        });

        const email = contactForm.querySelector('input[name="email"]');
        if (email && !email.checkValidity()) {
            email.style.borderColor = "#d60000";
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
            showContactFeedback("Please complete the required contact fields.");
        } else {
            showContactFeedback("Sending your inquiry...");
        }
    });
}

const contactSubmitStatus = <?php echo json_encode($status); ?>;
if (contactSubmitStatus === "success") showContactFeedback("Your inquiry was sent successfully.");
if (contactSubmitStatus === "error") showContactFeedback("Please complete all required fields properly.");

function openMap() {
    showContactFeedback("Opening map directions...");
    window.open("https://www.google.com/maps/search/?api=1&query=Makati+City+Metro+Manila+Philippines", "_blank");
}

function contactQuickAnswer(topic) {
    const service = document.querySelector('select[name="service"]');
    const turnaround = document.querySelector('select[name="turnaround"]');
    const message = document.querySelector('textarea[name="message"]');

    if (topic === "Turnaround Time" && turnaround) turnaround.value = "Rush Order";
    if ((topic === "Request a Quote" || topic === "File Guide") && service) service.value = "Custom Design";

    if (message) {
        message.value = `Hi Printify, I need help with ${topic}.`;
        message.focus();
        message.scrollIntoView({ behavior: "smooth", block: "center" });
    }

    showContactFeedback(`${topic} selected.`);
}

function focusContactMessage() {
    const message = document.querySelector('textarea[name="message"]');
    if (message) {
        message.focus();
        message.scrollIntoView({ behavior: "smooth", block: "center" });
        showContactFeedback("Message box is ready.");
    }
}
</script>

<style>
/* FINAL CONTACT FORM ICON + SPACING CLEANUP */
.contact-section{
    padding-top:46px!important;
    padding-bottom:76px!important;
}
.contact-container{
    max-width:1450px!important;
}
.contact-head{
    margin-bottom:26px!important;
}
.contact-grid{
    gap:30px!important;
    align-items:start!important;
}
.contact-card,
.no-box,
.info-card,
.quick-answer-card,
.map-card,
.branch-card{
    box-shadow:none!important;
}

/* Send Us a Message: restore one icon color inside form fields */
.form-card .input-wrapper i,
.form-card .form-bottom small i{
    color:#111827!important;
    opacity:.88!important;
}
.form-card .input-wrapper:focus-within i{
    color:#111827!important;
    opacity:1!important;
}
.form-card .card-title > i{
    color:var(--ui-orange)!important;
}

/* Form spacing: less redundant, cleaner breathing room */
.form-card{
    padding:22px 18px 20px!important;
}
.card-title{
    margin-bottom:20px!important;
    gap:14px!important;
}
.card-title h3{
    font-size:21px!important;
    line-height:1.05!important;
}
.card-title p{
    font-size:10.8px!important;
    line-height:1.35!important;
}
.form-fields{
    gap:20px!important;
}
.two-col{
    gap:16px!important;
}
.form-row label{
    margin-bottom:9px!important;
}
.input-wrapper i{
    left:13px!important;
    font-size:13px!important;
}
.input-wrapper input,
.input-wrapper select{
    height:44px!important;
    font-size:11.5px!important;
    padding-left:38px!important;
}
.input-wrapper textarea{
    height:136px!important;
    min-height:136px!important;
    font-size:11.5px!important;
    padding-left:38px!important;
}
.textarea-wrapper i{
    top:15px!important;
}
.form-bottom{
    margin-top:24px!important;
    gap:18px!important;
}

/* Middle and side sections: add spacing without moving layout positions */
.middle-side,
.contact-extra{
    gap:28px!important;
}
.info-card{
    padding:18px 0!important;
    gap:18px!important;
}
.touch-box{
    padding-right:22px!important;
}
.hours-box{
    padding-left:18px!important;
}
.info-card h3,
.quick-answer-card h3,
.map-head h3,
.branch-card h3{
    margin-bottom:18px!important;
}
.info-card p{
    margin-bottom:17px!important;
    line-height:1.42!important;
}
.info-card li{
    padding:13px 0!important;
}
.socials{
    margin-top:4px!important;
}

/* Our Branches spacing: no visible main box, still same content placement */
.branch-card,
.branch-card.main-box{
    padding-top:2px!important;
}
.branch-content{
    margin-top:24px!important;
    gap:40px!important;
    grid-template-columns:minmax(0,1fr) 215px!important;
}
.branch-list{
    gap:36px!important;
}
.branch-item b{
    margin-bottom:10px!important;
}
.branch-item span,
.branch-item small{
    margin-bottom:12px!important;
}
.branch-item p{
    margin-bottom:10px!important;
    line-height:1.45!important;
    gap:9px!important;
}
.branch-notes{
    gap:18px!important;
}
.branch-notes p{
    line-height:1.52!important;
    margin-bottom:16px!important;
}

/* Quick answers and map: cleaner repeated rows */
.quick-answer-card{
    padding-top:22px!important;
}
.quick-answer-card button{
    height:58px!important;
    padding:0 10px!important;
}
.map-card{
    padding-top:20px!important;
}
.map-head p{
    margin-bottom:16px!important;
}
.map-card button{
    margin-bottom:20px!important;
}

/* Footer breathing room and consistency */
.footer-main{
    padding-top:20px!important;
    padding-bottom:18px!important;
    gap:34px!important;
}
.footer-col{
    min-height:90px!important;
}
.footer-title-line{
    margin-top:10px!important;
    margin-bottom:13px!important;
}
.footer-contact-list{
    gap:8px!important;
}
.policy-grid{
    gap:12px 20px!important;
}
.footer-socials{
    gap:12px!important;
}
.footer-bottom{
    padding-top:12px!important;
    padding-bottom:12px!important;
}

/* Keep hover steady and remove redundant movement */
.contact-section *:hover,
.printify-footer *:hover{
    transform:none!important;
}
.input-wrapper input:hover,
.input-wrapper select:hover,
.input-wrapper textarea:hover,
.quick-answer-card button:hover,
.branch-item:hover,
.footer-links a:hover,
.footer-contact-list p:hover{
    background:linear-gradient(180deg,rgba(17,24,39,.09),rgba(17,24,39,.045))!important;
}

@media(max-width:1320px){
    .contact-grid{gap:24px!important;}
    .middle-side,.contact-extra{gap:24px!important;}
    .branch-content{
        gap:30px!important;
        grid-template-columns:minmax(0,1fr) 200px!important;
    }
    .branch-list{
        gap:28px!important;
    }
}
@media(max-width:1180px){
    .branch-content{
        grid-template-columns:1fr!important;
    }
}
@media(max-width:760px){
    .contact-section{padding-top:30px!important;padding-bottom:52px!important;}
    .contact-grid{gap:22px!important;}
    .form-card{padding:20px 16px!important;}
    .form-bottom{gap:14px!important;}
    .branch-content{
        gap:22px!important;
    }
    .branch-list{
        gap:20px!important;
    }
}
</style>


<style>
/* CONTACT US FONT ONLY PATCH - keep all UI/design intact */

/* Body / normal text / buttons */
#contact,
#contact p,
#contact span,
#contact a,
#contact li,
#contact small,
#contact div,
#contact input,
#contact textarea,
#contact select,
#contact button,
#contact .btn,
#contact input[type="submit"],
.contact,
.contact p,
.contact span,
.contact a,
.contact li,
.contact small,
.contact div,
.contact input,
.contact textarea,
.contact select,
.contact button,
.contact .btn,
.contact input[type="submit"],
.contactus,
.contactus p,
.contactus span,
.contactus a,
.contactus li,
.contactus small,
.contactus div,
.contactus input,
.contactus textarea,
.contactus select,
.contactus button,
.contactus .btn,
.contactus input[type="submit"],
.contact-us,
.contact-us p,
.contact-us span,
.contact-us a,
.contact-us li,
.contact-us small,
.contact-us div,
.contact-us input,
.contact-us textarea,
.contact-us select,
.contact-us button,
.contact-us .btn,
.contact-us input[type="submit"],
.pfcontact,
.pfcontact p,
.pfcontact span,
.pfcontact a,
.pfcontact li,
.pfcontact small,
.pfcontact div,
.pfcontact input,
.pfcontact textarea,
.pfcontact select,
.pfcontact button,
.pfcontact .btn,
.pfcontact input[type="submit"],
.pf-contact,
.pf-contact p,
.pf-contact span,
.pf-contact a,
.pf-contact li,
.pf-contact small,
.pf-contact div,
.pf-contact input,
.pf-contact textarea,
.pf-contact select,
.pf-contact button,
.pf-contact .btn,
.pf-contact input[type="submit"]{
  font-family:'Inter Local',system-ui,sans-serif!important;
}

/* Header / titles / labels */
#contact h1,
#contact h2,
#contact h3,
#contact h4,
#contact h5,
#contact h6,
#contact label,
#contact strong,
#contact b,
#contact .section-title,
#contact .section-subtitle,
#contact .contact-title,
#contact .contact-subtitle,
#contact .card-title,
#contact .form-title,
#contact .contact-card-title,
#contact .quick-title,
#contact .branch-title,
#contact .kicker,
#contact .eyebrow,
.contact h1,
.contact h2,
.contact h3,
.contact h4,
.contact h5,
.contact h6,
.contact label,
.contact strong,
.contact b,
.contact .section-title,
.contact .section-subtitle,
.contact .contact-title,
.contact .contact-subtitle,
.contact .card-title,
.contact .form-title,
.contact .contact-card-title,
.contact .quick-title,
.contact .branch-title,
.contact .kicker,
.contact .eyebrow,
.contactus h1,
.contactus h2,
.contactus h3,
.contactus h4,
.contactus h5,
.contactus h6,
.contactus label,
.contactus strong,
.contactus b,
.contactus .section-title,
.contactus .section-subtitle,
.contactus .contact-title,
.contactus .contact-subtitle,
.contactus .card-title,
.contactus .form-title,
.contactus .contact-card-title,
.contactus .quick-title,
.contactus .branch-title,
.contactus .kicker,
.contactus .eyebrow,
.contact-us h1,
.contact-us h2,
.contact-us h3,
.contact-us h4,
.contact-us h5,
.contact-us h6,
.contact-us label,
.contact-us strong,
.contact-us b,
.contact-us .section-title,
.contact-us .section-subtitle,
.contact-us .contact-title,
.contact-us .contact-subtitle,
.contact-us .card-title,
.contact-us .form-title,
.contact-us .contact-card-title,
.contact-us .quick-title,
.contact-us .branch-title,
.contact-us .kicker,
.contact-us .eyebrow,
.pfcontact h1,
.pfcontact h2,
.pfcontact h3,
.pfcontact h4,
.pfcontact h5,
.pfcontact h6,
.pfcontact label,
.pfcontact strong,
.pfcontact b,
.pfcontact .section-title,
.pfcontact .section-subtitle,
.pfcontact .contact-title,
.pfcontact .contact-subtitle,
.pfcontact .card-title,
.pfcontact .form-title,
.pfcontact .contact-card-title,
.pfcontact .quick-title,
.pfcontact .branch-title,
.pfcontact .kicker,
.pfcontact .eyebrow,
.pf-contact h1,
.pf-contact h2,
.pf-contact h3,
.pf-contact h4,
.pf-contact h5,
.pf-contact h6,
.pf-contact label,
.pf-contact strong,
.pf-contact b,
.pf-contact .section-title,
.pf-contact .section-subtitle,
.pf-contact .contact-title,
.pf-contact .contact-subtitle,
.pf-contact .card-title,
.pf-contact .form-title,
.pf-contact .contact-card-title,
.pf-contact .quick-title,
.pf-contact .branch-title,
.pf-contact .kicker,
.pf-contact .eyebrow{
  font-family:'League Spartan',system-ui,sans-serif!important;
}

/* PRINTIFY & CO. brand word */
.brand-main-text,
.printify-brand,
.printify-logo{
  font-family:'Boxing',serif!important;
}
</style>


<style>
/* =========================================================
   CONTACT US: Normal body font size normalization
   Keep original UI, colors, positions; adjust only normal text size
   ========================================================= */

/* All normal text: paragraphs, spans, links, li, inputs, textarea, select, buttons */
#contact p,
#contact span,
#contact a,
#contact li,
#contact small,
#contact td,
#contact th,
#contact input,
#contact textarea,
#contact select,
#contact button,
#contact .btn,
#contact input[type="submit"],
.contact p,
.contact span,
.contact a,
.contact li,
.contact small,
.contact td,
.contact th,
.contact input,
.contact textarea,
.contact select,
.contact button,
.contact .btn,
.contact input[type="submit"],
.contactus p,
.contactus span,
.contactus a,
.contactus li,
.contactus small,
.contactus td,
.contactus th,
.contactus input,
.contactus textarea,
.contactus select,
.contactus button,
.contactus .btn,
.contactus input[type="submit"],
.contact-us p,
.contact-us span,
.contact-us a,
.contact-us li,
.contact-us small,
.contact-us td,
.contact-us th,
.contact-us input,
.contact-us textarea,
.contact-us select,
.contact-us button,
.contact-us .btn,
.contact-us input[type="submit"],
.pfcontact p,
.pfcontact span,
.pfcontact a,
.pfcontact li,
.pfcontact small,
.pfcontact td,
.pfcontact th,
.pfcontact input,
.pfcontact textarea,
.pfcontact select,
.pfcontact button,
.pfcontact .btn,
.pfcontact input[type="submit"],
.pf-contact p,
.pf-contact span,
.pf-contact a,
.pf-contact li,
.pf-contact small,
.pf-contact td,
.pf-contact th,
.pf-contact input,
.pf-contact textarea,
.pf-contact select,
.pf-contact button,
.pf-contact .btn,
.pf-contact input[type="submit"]{
  font-family:'Inter Local',system-ui,sans-serif!important;
  font-size:14px!important;
  line-height:1.5!important;
  letter-spacing:.18px!important;
}
</style>


<style>
/* =========================================================
   CONTACT US: BODY SEMI-BOLD PATCH
   UI / colors / positions stay the same.
   Body / normal text / buttons = Inter.ttc, semi-bold.
   ========================================================= */

#contact p,
#contact span,
#contact a,
#contact li,
#contact small,
#contact td,
#contact th,
#contact input,
#contact textarea,
#contact select,
#contact button,
#contact .btn,
#contact input[type="submit"],
.contact p,
.contact span,
.contact a,
.contact li,
.contact small,
.contact td,
.contact th,
.contact input,
.contact textarea,
.contact select,
.contact button,
.contact .btn,
.contact input[type="submit"],
.contactus p,
.contactus span,
.contactus a,
.contactus li,
.contactus small,
.contactus td,
.contactus th,
.contactus input,
.contactus textarea,
.contactus select,
.contactus button,
.contactus .btn,
.contactus input[type="submit"],
.contact-us p,
.contact-us span,
.contact-us a,
.contact-us li,
.contact-us small,
.contact-us td,
.contact-us th,
.contact-us input,
.contact-us textarea,
.contact-us select,
.contact-us button,
.contact-us .btn,
.contact-us input[type="submit"],
.pfcontact p,
.pfcontact span,
.pfcontact a,
.pfcontact li,
.pfcontact small,
.pfcontact td,
.pfcontact th,
.pfcontact input,
.pfcontact textarea,
.pfcontact select,
.pfcontact button,
.pfcontact .btn,
.pfcontact input[type="submit"],
.pf-contact p,
.pf-contact span,
.pf-contact a,
.pf-contact li,
.pf-contact small,
.pf-contact td,
.pf-contact th,
.pf-contact input,
.pf-contact textarea,
.pf-contact select,
.pf-contact button,
.pf-contact .btn,
.pf-contact input[type="submit"]{
  font-family:'Inter Local',system-ui,sans-serif!important;
  font-size:14px!important;
  font-weight:600!important;
  line-height:1.5!important;
  letter-spacing:.18px!important;
}

/* Keep icons spacing/color from original UI */
#contact i,
.contact i,
.contactus i,
.contact-us i,
.pfcontact i,
.pf-contact i{
  letter-spacing:0!important;
}
</style>

<style id="printify-final-font-fix">
/* =========================================================
   FINAL FONT FIX - PRINTIFY & CO.
   Keep UI/colors/sizes/positions intact.
   PRINTIFY & CO. = Boxing-Regular.otf
   Header / titles / labels = LeagueSpartan-SemiBold.otf
   Body / normal text / buttons = Inter.ttc semi-bold
   ========================================================= */
@font-face{
    font-family:'BoxingFinal';
    src:url('/Fonts/Boxing-Regular.otf') format('opentype');
    font-weight:400;
    font-style:normal;
    font-display:swap;
}
@font-face{
    font-family:'LeagueSpartanFinal';
    src:url('/Fonts/LeagueSpartan-SemiBold.otf') format('opentype');
    font-weight:600;
    font-style:normal;
    font-display:swap;
}
@font-face{
    font-family:'InterFinal';
    src:url('/Fonts/Inter.ttc') format('truetype-collection');
    font-weight:600;
    font-style:normal;
    font-display:swap;
}

/* default normal text */
#contact,
#contact :where(p,span,a,li,small,td,th,input,textarea,select,option,button,div),
.contact-section,
.contact-section :where(p,span,a,li,small,td,th,input,textarea,select,option,button,div),
.printify-footer,
.printify-footer :where(p,span,a,li,small,td,th,button,div){
    font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
    font-weight:600!important;
}

/* headings, card titles, subtitles, labels */
#contact :where(h1,h2,h3,h4,h5,h6,label,strong,b,.card-title,.card-title *, .contact-head > span,.section-title,.section-subtitle,.contact-title,.contact-subtitle,.form-title,.contact-card-title,.quick-title,.branch-title,.kicker,.eyebrow),
.contact-section :where(h1,h2,h3,h4,h5,h6,label,strong,b,.card-title,.card-title *, .contact-head > span,.section-title,.section-subtitle,.contact-title,.contact-subtitle,.form-title,.contact-card-title,.quick-title,.branch-title,.kicker,.eyebrow),
.printify-footer :where(h1,h2,h3,h4,h5,h6,label,strong,b,.footer-col h3,.footer-col h4,.footer-title,.footer-heading){
    font-family:'LeagueSpartanFinal','League Spartan',Arial,sans-serif!important;
    font-weight:600!important;
}

/* buttons are body font per instruction */
#contact :where(button,.ui-btn,.btn,input[type="submit"],a.ui-btn),
.contact-section :where(button,.ui-btn,.btn,input[type="submit"],a.ui-btn),
.printify-footer :where(button,.ui-btn,.btn,input[type="submit"],a.ui-btn){
    font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
    font-weight:600!important;
}

/* PRINTIFY & CO. wordmark / any branded text inside contact/footer */
.printify-wordmark,
.printify-logo,
.printify-brand,
.brand-main-text,
.footer-brand h2,
.footer-bottom .printify-wordmark,
[aria-label*="Printify"],
[title*="Printify"]{
    font-family:'BoxingFinal','Boxing',serif!important;
    font-weight:400!important;
    letter-spacing:.5px!important;
}

/* Footer explicit font application */
.printify-footer .footer-brand h2,
.printify-footer .footer-bottom span.printify-wordmark{
    font-family:'BoxingFinal','Boxing',serif!important;
    font-weight:400!important;
}
.printify-footer .footer-brand h4,
.printify-footer .footer-col h3{
    font-family:'LeagueSpartanFinal','League Spartan',Arial,sans-serif!important;
    font-weight:600!important;
}
.printify-footer .footer-brand p,
.printify-footer .footer-brand p span,
.printify-footer .footer-links a,
.printify-footer .footer-contact-list p,
.printify-footer .footer-contact-list p span,
.printify-footer .footer-bottom p{
    font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
    font-weight:600!important;
}

/* Icons must not inherit decorative font */
#contact i,
.contact-section i,
.printify-footer i{
    font-family:"Font Awesome 6 Free","Font Awesome 6 Brands"!important;
}
</style>

<style id="contact-request-final-adjustments">
/* =========================================================
   FINAL REQUEST ADJUSTMENTS
   - Lakihan konti Send Us a Message
   - Bawasan font ng Fill out the form below...
   - Text & icons sa fields saktuhan
   - Our Branches mas maluwag ang spacing/salansan
   - UI / positions / fonts same lang
   ========================================================= */

#contact .form-card .card-title h3,
.contact-section .form-card .card-title h3{
    font-size:21.5px!important;
    line-height:1.05!important;
    margin-bottom:5px!important;
}

#contact .form-card .card-title p,
.contact-section .form-card .card-title p{
    font-size:10.5px!important;
    line-height:1.35!important;
    margin:0!important;
}

#contact .form-card .input-wrapper i,
.contact-section .form-card .input-wrapper i{
    left:13px!important;
    font-size:13px!important;
    width:14px!important;
    text-align:center!important;
}

#contact .form-card .textarea-wrapper i,
.contact-section .form-card .textarea-wrapper i{
    top:15px!important;
}

#contact .form-card .input-wrapper input,
#contact .form-card .input-wrapper select,
#contact .form-card .input-wrapper textarea,
.contact-section .form-card .input-wrapper input,
.contact-section .form-card .input-wrapper select,
.contact-section .form-card .input-wrapper textarea{
    font-size:11.5px!important;
    padding-left:38px!important;
}

#contact .form-card .input-wrapper input,
#contact .form-card .input-wrapper select,
.contact-section .form-card .input-wrapper input,
.contact-section .form-card .input-wrapper select{
    height:44px!important;
}

#contact .form-card .input-wrapper textarea,
.contact-section .form-card .input-wrapper textarea{
    height:136px!important;
    min-height:136px!important;
    line-height:1.45!important;
}

#contact .branch-content,
.contact-section .branch-content{
    margin-top:24px!important;
    gap:42px!important;
    grid-template-columns:minmax(0,1fr) 220px!important;
}

#contact .branch-list,
.contact-section .branch-list{
    gap:38px!important;
}

#contact .branch-item + .branch-item,
.contact-section .branch-item + .branch-item{
    padding-left:22px!important;
}

#contact .branch-item b,
.contact-section .branch-item b{
    margin-bottom:10px!important;
}

#contact .branch-item span,
#contact .branch-item small,
.contact-section .branch-item span,
.contact-section .branch-item small{
    margin-bottom:13px!important;
}

#contact .branch-item p,
.contact-section .branch-item p{
    margin-bottom:11px!important;
    line-height:1.45!important;
    gap:9px!important;
    align-items:flex-start!important;
}

#contact .branch-item p i,
.contact-section .branch-item p i{
    margin-top:2px!important;
    flex:0 0 auto!important;
}

#contact .branch-notes,
.contact-section .branch-notes{
    min-height:158px!important;
    gap:18px!important;
}

#contact .branch-notes p,
.contact-section .branch-notes p{
    margin-bottom:16px!important;
    line-height:1.55!important;
    gap:10px!important;
}

@media(max-width:1320px){
    #contact .branch-content,
    .contact-section .branch-content{
        gap:32px!important;
        grid-template-columns:minmax(0,1fr) 205px!important;
    }

    #contact .branch-list,
    .contact-section .branch-list{
        gap:30px!important;
    }
}

@media(max-width:1180px){
    #contact .branch-content,
    .contact-section .branch-content{
        grid-template-columns:1fr!important;
    }

    #contact .branch-item + .branch-item,
    .contact-section .branch-item + .branch-item{
        padding-left:0!important;
    }
}

@media(max-width:760px){
    #contact .branch-list,
    .contact-section .branch-list{
        gap:22px!important;
    }

    #contact .branch-content,
    .contact-section .branch-content{
        gap:24px!important;
    }
}
</style>

<style id="contact-user-request-final-file-patch">
/* =========================================================
   USER REQUEST FINAL FILE PATCH
   UI / design / sizes / spacing stay intact.
   1) Contact subheaders/titles uppercase.
   2) Branch names and quick answer labels use the exact body font
      style used by "Same-day assistance available for selected services."
   3) Send Message paper-plane icon visible immediately, not hover-only.
   ========================================================= */

#contact .contact-head > span,
.contact-section .contact-head > span,
#contact .touch-box > h3,
.contact-section .touch-box > h3,
#contact .hours-box > h3,
.contact-section .hours-box > h3,
#contact .branch-card > h3,
.contact-section .branch-card > h3,
#contact .quick-answer-card > h3,
.contact-section .quick-answer-card > h3,
#contact .map-head > h3,
.contact-section .map-head > h3{
    text-transform:uppercase!important;
}

#contact .branch-item > b,
.contact-section .branch-item > b,
#contact .quick-answer-card button > b,
.contact-section .quick-answer-card button > b{
    font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
    font-weight:600!important;
    letter-spacing:.18px!important;
}

#contact .form-bottom .ui-btn i.fa-paper-plane,
.contact-section .form-bottom .ui-btn i.fa-paper-plane,
#contact button[type="submit"] i.fa-paper-plane,
.contact-section button[type="submit"] i.fa-paper-plane{
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    opacity:1!important;
    visibility:visible!important;
    color:#111827!important;
    font-family:"Font Awesome 6 Free"!important;
    font-weight:900!important;
}

#contact .form-bottom .ui-btn:hover i.fa-paper-plane,
#contact .form-bottom .ui-btn:focus i.fa-paper-plane,
.contact-section .form-bottom .ui-btn:hover i.fa-paper-plane,
.contact-section .form-bottom .ui-btn:focus i.fa-paper-plane,
#contact button[type="submit"]:hover i.fa-paper-plane,
#contact button[type="submit"]:focus i.fa-paper-plane,
.contact-section button[type="submit"]:hover i.fa-paper-plane,
.contact-section button[type="submit"]:focus i.fa-paper-plane{
    color:#ffffff!important;
    opacity:1!important;
    visibility:visible!important;
}
</style>

<style id="contact-latest-user-request-fix">
/* =========================================================
   LATEST CONTACT FONT FIX
   - Subheader/title labels: uppercase + bold
   - Branch names and quick answer labels: body font, same as notes
   - Send Message icon: visible immediately, not hover-only
   - No layout / spacing / color structure changed
   ========================================================= */

#contact .contact-head > span,
.contact-section .contact-head > span,
#contact .touch-box > h3,
.contact-section .touch-box > h3,
#contact .hours-box > h3,
.contact-section .hours-box > h3,
#contact .quick-answer-card > h3,
.contact-section .quick-answer-card > h3,
#contact .branch-card > h3,
.contact-section .branch-card > h3,
#contact .map-head > h3,
.contact-section .map-head > h3{
    text-transform:uppercase!important;
    font-family:'LeagueSpartanFinal','League Spartan',Arial,sans-serif!important;
    font-weight:800!important;
}

#contact .branch-item > b,
.contact-section .branch-item > b,
#contact .quick-answer-card button > b,
.contact-section .quick-answer-card button > b{
    font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
    font-size:14px!important;
    font-weight:600!important;
    line-height:1.5!important;
    letter-spacing:.18px!important;
}

#contact .form-bottom .ui-btn .fa-paper-plane,
.contact-section .form-bottom .ui-btn .fa-paper-plane{
    display:inline-flex!important;
    visibility:visible!important;
    opacity:1!important;
    color:#111827!important;
}

#contact .form-bottom .ui-btn:hover .fa-paper-plane,
#contact .form-bottom .ui-btn:focus .fa-paper-plane,
.contact-section .form-bottom .ui-btn:hover .fa-paper-plane,
.contact-section .form-bottom .ui-btn:focus .fa-paper-plane{
    color:#ffffff!important;
}
</style>
