<?php
/**
 * ============================================================
 * BLOOD DONATION SYSTEM
 * Public Homepage
 * File: index.php
 * ============================================================
 */

/*
|--------------------------------------------------------------------------
| Bootstrap
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/config/session.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/app.php';


/*
|--------------------------------------------------------------------------
| Helper Functions
|--------------------------------------------------------------------------
*/

function e($value): string
{
    return htmlspecialchars(
        (string) ($value ?? ''),
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
}

function page_url(string $path = ''): string
{
    return app_url($path);
}


/*
|--------------------------------------------------------------------------
| Language Configuration
|--------------------------------------------------------------------------
*/

$supportedLanguages = defined('APP_SUPPORTED_LANGUAGES')
    && is_array(APP_SUPPORTED_LANGUAGES)
    ? APP_SUPPORTED_LANGUAGES
    : ['en', 'bn'];

$defaultLanguage = defined('APP_DEFAULT_LANGUAGE')
    ? APP_DEFAULT_LANGUAGE
    : 'en';


/*
|--------------------------------------------------------------------------
| Language Switch
|--------------------------------------------------------------------------
|
| Language change is handled before any HTML output.
|
*/

if (
    isset($_GET['lang'])
    && in_array($_GET['lang'], $supportedLanguages, true)
) {
    $_SESSION['language'] = $_GET['lang'];

    $currentPath = parse_url(
        $_SERVER['REQUEST_URI'] ?? '/',
        PHP_URL_PATH
    );

    if (!$currentPath) {
        $currentPath = '/';
    }

    header(
        'Location: ' . $currentPath,
        true,
        302
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| Current Language
|--------------------------------------------------------------------------
*/

$currentLanguage = $_SESSION['language'] ?? $defaultLanguage;

if (!in_array(
    $currentLanguage,
    $supportedLanguages,
    true
)) {
    $currentLanguage = $defaultLanguage;
}


/*
|--------------------------------------------------------------------------
| Translation
|--------------------------------------------------------------------------
*/

$translations = [

    'en' => [

        'site_name' => 'Blood Donation System',

        'home' => 'Home',
        'find_donor' => 'Find Donor',
        'blood_requests' => 'Blood Requests',
        'about' => 'About',
        'contact' => 'Contact',
        'faq' => 'FAQ',

        'login' => 'Login',
        'register' => 'Become a Donor',
        'dashboard' => 'Dashboard',

        'hero_badge' => 'Together We Can Save Lives',

        'hero_title' =>
            'Your Blood Can Be Someone’s <span>Second Chance</span>',

        'hero_text' =>
            'Connect with verified blood donors and help patients find the blood they need when every second matters.',

        'find_donor_btn' => 'Find a Donor',
        'request_blood_btn' => 'Request Blood',

        'stats_donors' => 'Verified Donors',
        'stats_requests' => 'Blood Requests',
        'stats_donations' => 'Successful Donations',
        'stats_lives' => 'Lives Supported',

        'how_title' => 'How It Works',

        'step1_title' => 'Find a Donor',
        'step1_text' =>
            'Search available donors by blood group and location.',

        'step2_title' => 'Create a Request',
        'step2_text' =>
            'Submit a blood request with the required information.',

        'step3_title' => 'Connect & Donate',
        'step3_text' =>
            'Connect with the donor and help save a life.',

        'requests_title' => 'Urgent Blood Requests',

        'view_all' => 'View All Requests',

        'view_details' => 'View Details',

        'no_requests' =>
            'There are currently no approved blood requests.',

        'cta_title' =>
            'Become a Blood Donor Today',

        'cta_text' =>
            'A single blood donation can make a meaningful difference in someone’s life.',

        'cta_button' =>
            'Register as a Donor',

        'footer_text' =>
            'Connecting blood donors with people who need them.',

        'footer_links' => 'Quick Links',
        'donor_links' => 'Blood Donation',
        'account_links' => 'Account',

        'all_rights' => 'All rights reserved.',

        'emergency' => 'Emergency',
        'urgent' => 'Urgent',
        'normal' => 'Normal',

        'quantity' => 'Required',
        'hospital' => 'Hospital',
        'location' => 'Location',

        'open_menu' => 'Open navigation menu',
        'close_menu' => 'Close navigation menu'

    ],

    'bn' => [

        'site_name' => 'ব্লাড ডোনেশন সিস্টেম',

        'home' => 'হোম',
        'find_donor' => 'রক্তদাতা খুঁজুন',
        'blood_requests' => 'রক্তের অনুরোধ',
        'about' => 'আমাদের সম্পর্কে',
        'contact' => 'যোগাযোগ',
        'faq' => 'সাধারণ প্রশ্ন',

        'login' => 'লগইন',
        'register' => 'রক্তদাতা হিসেবে নিবন্ধন',
        'dashboard' => 'ড্যাশবোর্ড',

        'hero_badge' => 'একসাথে আমরা জীবন বাঁচাতে পারি',

        'hero_title' =>
            'আপনার রক্ত হতে পারে কারো <span>নতুন জীবনের সুযোগ</span>',

        'hero_text' =>
            'যাচাইকৃত রক্তদাতাদের সাথে যুক্ত হন এবং প্রয়োজনের সময়ে রোগীর জন্য প্রয়োজনীয় রক্ত খুঁজে পেতে সহায়তা করুন।',

        'find_donor_btn' => 'রক্তদাতা খুঁজুন',
        'request_blood_btn' => 'রক্তের অনুরোধ করুন',

        'stats_donors' => 'যাচাইকৃত রক্তদাতা',
        'stats_requests' => 'রক্তের অনুরোধ',
        'stats_donations' => 'সফল রক্তদান',
        'stats_lives' => 'সহায়তা পাওয়া জীবন',

        'how_title' => 'কীভাবে কাজ করে',

        'step1_title' => 'রক্তদাতা খুঁজুন',
        'step1_text' =>
            'রক্তের গ্রুপ ও অবস্থান অনুযায়ী উপযুক্ত রক্তদাতা খুঁজুন।',

        'step2_title' => 'অনুরোধ তৈরি করুন',
        'step2_text' =>
            'প্রয়োজনীয় তথ্য দিয়ে রক্তের অনুরোধ জমা দিন।',

        'step3_title' => 'যোগাযোগ ও রক্তদান',
        'step3_text' =>
            'রক্তদাতার সাথে যোগাযোগ করে জীবন বাঁচাতে সহায়তা করুন।',

        'requests_title' => 'জরুরি রক্তের অনুরোধ',

        'view_all' => 'সব অনুরোধ দেখুন',

        'view_details' => 'বিস্তারিত দেখুন',

        'no_requests' =>
            'এই মুহূর্তে কোনো অনুমোদিত রক্তের অনুরোধ নেই।',

        'cta_title' =>
            'আজই রক্তদাতা হিসেবে নিবন্ধন করুন',

        'cta_text' =>
            'আপনার একটি রক্তদান কারো জীবনে গুরুত্বপূর্ণ পরিবর্তন আনতে পারে।',

        'cta_button' =>
            'রক্তদাতা হিসেবে নিবন্ধন করুন',

        'footer_text' =>
            'রক্তদাতাদের সাথে রক্তের প্রয়োজন থাকা মানুষদের সংযুক্ত করছি।',

        'footer_links' => 'দ্রুত লিংক',
        'donor_links' => 'রক্তদান',
        'account_links' => 'অ্যাকাউন্ট',

        'all_rights' => 'সর্বস্বত্ব সংরক্ষিত।',

        'emergency' => 'জরুরি',
        'urgent' => 'অতি জরুরি',
        'normal' => 'সাধারণ',

        'quantity' => 'প্রয়োজন',
        'hospital' => 'হাসপাতাল',
        'location' => 'অবস্থান',

        'open_menu' => 'নেভিগেশন মেনু খুলুন',
        'close_menu' => 'নেভিগেশন মেনু বন্ধ করুন'

    ]
];


function t(string $key): string
{
    global $translations, $currentLanguage;

    return $translations[$currentLanguage][$key]
        ?? $translations['en'][$key]
        ?? $key;
}


/*
|--------------------------------------------------------------------------
| Database Data
|--------------------------------------------------------------------------
*/

$bloodRequests = [];

$totalDonors = 0;
$totalRequests = 0;
$totalDonations = 0;


/*
|--------------------------------------------------------------------------
| Approved Blood Requests
|--------------------------------------------------------------------------
*/

try {

    $stmt = $pdo->prepare("
        SELECT
            id,
            request_id,
            patient_name,
            blood_group,
            required_quantity,
            hospital_name,
            location,
            required_date,
            required_time,
            emergency_level,
            contact_phone,
            created_at
        FROM blood_requests
        WHERE request_status = 'approved'
        ORDER BY
            CASE emergency_level
                WHEN 'emergency' THEN 1
                WHEN 'urgent' THEN 2
                ELSE 3
            END,
            created_at DESC
        LIMIT 6
    ");

    $stmt->execute();

    $bloodRequests = $stmt->fetchAll(
        PDO::FETCH_ASSOC
    );

} catch (PDOException $e) {

    $bloodRequests = [];
}


/*
|--------------------------------------------------------------------------
| Homepage Statistics
|--------------------------------------------------------------------------
*/

try {

    /*
    |--------------------------------------------------------------------------
    | Verified Donors
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->query("
        SELECT COUNT(*)
        FROM users
        WHERE donor_status = 'approved'
        AND account_status = 'active'
    ");

    $totalDonors = (int) $stmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Approved Requests
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->query("
        SELECT COUNT(*)
        FROM blood_requests
        WHERE request_status = 'approved'
    ");

    $totalRequests = (int) $stmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Successful Donations
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->query("
        SELECT COUNT(*)
        FROM donations
        WHERE donation_status = 'approved'
    ");

    $totalDonations = (int) $stmt->fetchColumn();

} catch (PDOException $e) {

    $totalDonors = 0;
    $totalRequests = 0;
    $totalDonations = 0;
}


/*
|--------------------------------------------------------------------------
| Supported URL Helpers
|--------------------------------------------------------------------------
*/

$homeUrl = page_url('index.php');
$findDonorUrl = page_url('find-donor.php');
$requestsUrl = page_url('blood-requests.php');
$aboutUrl = page_url('about.php');
$contactUrl = page_url('contact.php');
$faqUrl = page_url('faq.php');
$loginUrl = page_url('login.php');
$registerUrl = page_url('register.php');
$dashboardUrl = page_url('user/dashboard.php');

?>
<!DOCTYPE html>

<html
    lang="<?= e($currentLanguage) ?>"
    dir="ltr"
>

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="<?= e(t('site_name')) ?> - Find blood donors and create blood requests."
    >

    <meta
        name="theme-color"
        content="#e63946"
    >

    <meta
        name="color-scheme"
        content="light"
    >

    <title>
        <?= e(t('site_name')) ?>
    </title>

    <link
        rel="icon"
        href="<?= e(asset_url('images/favicon.png')) ?>"
    >

    <style>

        /*
        |--------------------------------------------------------------------------
        | Root
        |--------------------------------------------------------------------------
        */

        :root {

            --primary: #e63946;
            --primary-dark: #c1121f;

            --secondary: #ff6b6b;
            --accent: #ff8fa3;

            --dark: #18202b;
            --text: #4b5563;
            --muted: #7a8493;

            --light: #f8fafc;
            --white: #ffffff;

            --success: #16a34a;
            --warning: #f59e0b;

            --border: #f1e4e6;

            --gradient-main:
                linear-gradient(
                    135deg,
                    #e63946 0%,
                    #ff6b6b 52%,
                    #ff8fa3 100%
                );

            --gradient-soft:
                linear-gradient(
                    135deg,
                    #fff1f2 0%,
                    #ffffff 100%
                );

            --shadow:
                0 20px 55px
                rgba(230, 57, 70, .12);

            --shadow-card:
                0 12px 38px
                rgba(16, 24, 40, .06);

            --radius: 22px;

            --transition:
                .22s ease;
        }


        /*
        |--------------------------------------------------------------------------
        | Reset
        |--------------------------------------------------------------------------
        */

        *,
        *::before,
        *::after {

            box-sizing: border-box;

            margin: 0;
            padding: 0;
        }


        html {

            scroll-behavior: smooth;

            -webkit-text-size-adjust: 100%;
        }


        body {

            font-family:
                Inter,
                "Noto Sans Bengali",
                "Segoe UI",
                Arial,
                sans-serif;

            color: var(--text);

            background:
                linear-gradient(
                    180deg,
                    #ffffff 0%,
                    #fff8f9 100%
                );

            line-height: 1.6;

            overflow-x: hidden;
        }


        img {

            max-width: 100%;

            display: block;
        }


        a {

            text-decoration: none;

            color: inherit;
        }


        button,
        input,
        select,
        textarea {

            font: inherit;
        }


        button {

            border: 0;
        }


        .container {

            width:
                min(
                    1180px,
                    calc(100% - 32px)
                );

            margin-inline: auto;
        }


        /*
        |--------------------------------------------------------------------------
        | Header
        |--------------------------------------------------------------------------
        */

        .header {

            position: sticky;

            top: 0;

            z-index: 1000;

            background:
                rgba(255,255,255,.92);

            backdrop-filter:
                blur(18px);

            -webkit-backdrop-filter:
                blur(18px);

            border-bottom:
                1px solid
                rgba(230,57,70,.08);
        }


        .nav {

            min-height: 76px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;
        }


        .brand {

            display: inline-flex;

            align-items: center;

            gap: 11px;

            color: var(--dark);

            font-size: 19px;

            font-weight: 850;

            white-space: nowrap;
        }


        .brand-icon {

            width: 43px;
            height: 43px;

            flex: 0 0 43px;

            display: grid;

            place-items: center;

            border-radius: 14px;

            color: white;

            background:
                var(--gradient-main);

            box-shadow:
                0 10px 26px
                rgba(230,57,70,.25);
        }


        .nav-links {

            display: flex;

            align-items: center;

            gap: 24px;

            font-size: 14px;

            font-weight: 650;
        }


        .nav-links a {

            position: relative;

            color: #4b5563;

            transition:
                color var(--transition);
        }


        .nav-links a::after {

            content: "";

            position: absolute;

            left: 0;
            right: 0;

            bottom: -8px;

            height: 2px;

            border-radius: 10px;

            background: var(--primary);

            transform:
                scaleX(0);

            transform-origin: center;

            transition:
                transform var(--transition);
        }


        .nav-links a:hover {

            color: var(--primary);
        }


        .nav-links a:hover::after {

            transform:
                scaleX(1);
        }


        .nav-actions {

            display: flex;

            align-items: center;

            gap: 9px;
        }


        .language-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            min-height: 40px;

            padding:
                0 12px;

            border:
                1px solid #f1c3c8;

            border-radius: 11px;

            color: var(--primary);

            background: white;

            font-size: 13px;

            font-weight: 750;

            transition:
                var(--transition);
        }


        .language-btn:hover {

            background:
                #fff3f4;

            border-color:
                #eba1a9;
        }


        /*
        |--------------------------------------------------------------------------
        | Buttons
        |--------------------------------------------------------------------------
        */

        .btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            min-height: 46px;

            padding:
                0 20px;

            border-radius: 13px;

            font-size: 14px;

            font-weight: 750;

            cursor: pointer;

            transition:
                transform var(--transition),
                box-shadow var(--transition),
                background var(--transition);
        }


        .btn:hover {

            transform:
                translateY(-2px);
        }


        .btn-primary {

            color: white;

            background:
                var(--gradient-main);

            box-shadow:
                0 10px 25px
                rgba(230,57,70,.22);
        }


        .btn-primary:hover {

            box-shadow:
                0 15px 32px
                rgba(230,57,70,.28);
        }


        .btn-outline {

            color: var(--primary);

            background: white;

            border:
                1px solid #f3b6bd;
        }


        .btn-outline:hover {

            background:
                #fff5f6;

            border-color:
                #e78d97;
        }


        /*
        |--------------------------------------------------------------------------
        | Mobile Menu Button
        |--------------------------------------------------------------------------
        */

        .menu-toggle {

            display: none;

            width: 42px;
            height: 42px;

            align-items: center;

            justify-content: center;

            border:
                1px solid #f1c3c8;

            border-radius: 11px;

            color: var(--primary);

            background: white;

            cursor: pointer;

            font-size: 20px;
        }


        /*
        |--------------------------------------------------------------------------
        | Hero
        |--------------------------------------------------------------------------
        */

        .hero {

            position: relative;

            overflow: hidden;

            padding:
                95px 0 90px;

            background:
                radial-gradient(
                    circle at 86% 18%,
                    rgba(255,107,107,.18),
                    transparent 34%
                ),
                radial-gradient(
                    circle at 8% 80%,
                    rgba(255,143,163,.14),
                    transparent 34%
                );
        }


        .hero-grid {

            display: grid;

            grid-template-columns:
                1.05fr .95fr;

            align-items: center;

            gap: 60px;
        }


        .hero-badge {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            padding:
                8px 14px;

            border-radius: 999px;

            color: var(--primary);

            background: #fff0f2;

            font-size: 13px;

            font-weight: 800;

            margin-bottom: 20px;
        }


        .hero h1 {

            color: var(--dark);

            font-size:
                clamp(42px, 5vw, 68px);

            line-height: 1.08;

            letter-spacing: -2.4px;

            margin-bottom: 22px;
        }


        .hero h1 span {

            color: var(--primary);
        }


        .hero-text {

            max-width: 650px;

            color: #667085;

            font-size: 17px;

            line-height: 1.75;

            margin-bottom: 30px;
        }


        .hero-actions {

            display: flex;

            flex-wrap: wrap;

            gap: 12px;
        }


        /*
        |--------------------------------------------------------------------------
        | Hero Card
        |--------------------------------------------------------------------------
        */

        .hero-card {

            position: relative;

            min-height: 430px;

            display: flex;

            flex-direction: column;

            justify-content: center;

            border-radius: 32px;

            padding: 30px;

            color: white;

            background:
                var(--gradient-main);

            box-shadow:
                0 30px 70px
                rgba(230,57,70,.25);

            overflow: hidden;
        }


        .hero-card::before {

            content: "";

            position: absolute;

            width: 280px;
            height: 280px;

            border-radius: 50%;

            background:
                rgba(255,255,255,.11);

            top: -100px;

            right: -70px;
        }


        .hero-card::after {

            content: "";

            position: absolute;

            width: 210px;
            height: 210px;

            border-radius: 50%;

            background:
                rgba(255,255,255,.08);

            bottom: -80px;

            left: -45px;
        }


        .blood-drop {

            position: relative;

            z-index: 2;

            width: 170px;

            height: 205px;

            display: grid;

            place-items: center;

            margin:
                0 auto 20px;

            font-size: 78px;

            filter:
                drop-shadow(
                    0 20px 25px
                    rgba(0,0,0,.15)
                );

            animation:
                floatingDrop 4s ease-in-out infinite;
        }


        @keyframes floatingDrop {

            0%,
            100% {

                transform:
                    translateY(0);
            }

            50% {

                transform:
                    translateY(-10px);
            }
        }


        .hero-card-content {

            position: relative;

            z-index: 3;

            text-align: center;
        }


        .hero-card-content h3 {

            font-size: 25px;

            margin-bottom: 7px;
        }


        .hero-card-content p {

            color:
                rgba(255,255,255,.88);

            font-size: 14px;
        }


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        .stats {

            position: relative;

            margin-top: -35px;

            z-index: 10;
        }


        .stats-grid {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            background: white;

            border-radius: 22px;

            box-shadow: var(--shadow);

            overflow: hidden;
        }


        .stat {

            padding:
                28px 20px;

            text-align: center;

            border-right:
                1px solid #f1f1f1;
        }


        .stat:last-child {

            border-right: 0;
        }


        .stat-number {

            display: block;

            color: var(--primary);

            font-size: 30px;

            font-weight: 900;

            letter-spacing: -.5px;
        }


        .stat-label {

            display: block;

            margin-top: 5px;

            color: #667085;

            font-size: 13px;
        }


        /*
        |--------------------------------------------------------------------------
        | Sections
        |--------------------------------------------------------------------------
        */

        .section {

            padding:
                95px 0;
        }


        .section-heading {

            max-width: 680px;

            margin:
                0 auto 45px;

            text-align: center;
        }


        .section-heading h2 {

            color: var(--dark);

            font-size:
                clamp(30px, 4vw, 43px);

            line-height: 1.15;

            margin-bottom: 10px;
        }


        .section-heading p {

            color: var(--muted);
        }


        /*
        |--------------------------------------------------------------------------
        | How It Works
        |--------------------------------------------------------------------------
        */

        .steps-grid {

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 22px;
        }


        .step {

            position: relative;

            padding: 32px;

            border-radius:
                var(--radius);

            background: white;

            border:
                1px solid #f5e7e9;

            box-shadow:
                var(--shadow-card);

            transition:
                transform var(--transition),
                box-shadow var(--transition);
        }


        .step:hover {

            transform:
                translateY(-6px);

            box-shadow:
                0 20px 45px
                rgba(16,24,40,.09);
        }


        .step-icon {

            width: 58px;
            height: 58px;

            display: grid;

            place-items: center;

            border-radius: 17px;

            color: var(--primary);

            background: #fff0f2;

            font-size: 25px;

            margin-bottom: 20px;
        }


        .step h3 {

            color: var(--dark);

            margin-bottom: 8px;

            font-size: 19px;
        }


        .step p {

            color: #77808f;

            font-size: 14px;
        }


        /*
        |--------------------------------------------------------------------------
        | Requests
        |--------------------------------------------------------------------------
        */

        .requests-section {

            background:
                linear-gradient(
                    180deg,
                    #fff7f8,
                    #ffffff
                );
        }


        .requests-header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            margin-bottom: 30px;
        }


        .requests-header h2 {

            color: var(--dark);

            font-size: 32px;

            line-height: 1.2;
        }


        .request-grid {

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 20px;
        }


        .request-card {

            padding: 23px;

            border-radius: 20px;

            background: white;

            border:
                1px solid #f4e4e6;

            box-shadow:
                0 12px 35px
                rgba(16,24,40,.05);

            transition:
                transform var(--transition),
                box-shadow var(--transition);
        }


        .request-card:hover {

            transform:
                translateY(-5px);

            box-shadow:
                0 20px 42px
                rgba(16,24,40,.09);
        }


        .request-top {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 12px;

            margin-bottom: 18px;
        }


        .blood-group {

            width: 52px;
            height: 52px;

            flex: 0 0 52px;

            display: grid;

            place-items: center;

            border-radius: 15px;

            color: white;

            background:
                var(--gradient-main);

            font-size: 17px;

            font-weight: 900;

            box-shadow:
                0 9px 20px
                rgba(230,57,70,.17);
        }


        .urgency {

            padding:
                6px 10px;

            border-radius: 999px;

            font-size: 11px;

            font-weight: 800;

            white-space: nowrap;
        }


        .urgency-emergency {

            color: #b42318;

            background: #fee4e2;
        }


        .urgency-urgent {

            color: #b54708;

            background: #fef0c7;
        }


        .urgency-normal {

            color: #027a48;

            background: #d1fadf;
        }


        .request-card h3 {

            color: var(--dark);

            font-size: 18px;

            margin-bottom: 9px;
        }


        .request-info {

            display: flex;

            align-items: flex-start;

            gap: 7px;

            color: #737d8c;

            font-size: 13px;

            margin: 6px 0;
        }


        .request-info strong {

            color: #4b5563;

            min-width: 18px;
        }


        .request-bottom {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 10px;

            padding-top: 18px;

            margin-top: 18px;

            border-top:
                1px solid #f1f1f1;
        }


        .request-id {

            color: #98a2b3;

            font-size: 11px;
        }


        .empty-state {

            grid-column: 1 / -1;

            padding: 55px 30px;

            text-align: center;

            color: #7a8493;

            background: white;

            border:
                1px solid #f4e4e6;

            border-radius: 20px;

            box-shadow:
                var(--shadow-card);

            font-size: 14px;
        }


        .empty-icon {

            display: block;

            font-size: 42px;

            margin-bottom: 10px;
        }


        /*
        |--------------------------------------------------------------------------
        | CTA
        |--------------------------------------------------------------------------
        */

        .cta {

            padding:
                90px 0;
        }


        .cta-card {

            position: relative;

            overflow: hidden;

            padding:
                65px 45px;

            border-radius: 30px;

            text-align: center;

            color: white;

            background:
                var(--gradient-main);

            box-shadow:
                0 30px 70px
                rgba(230,57,70,.2);
        }


        .cta-card::before {

            content: "";

            position: absolute;

            width: 250px;
            height: 250px;

            border-radius: 50%;

            background:
                rgba(255,255,255,.08);

            top: -120px;

            right: -70px;
        }


        .cta-card h2,
        .cta-card p,
        .cta-card a {

            position: relative;

            z-index: 2;
        }


        .cta-card h2 {

            font-size:
                clamp(30px, 4vw, 45px);

            line-height: 1.15;

            margin-bottom: 12px;
        }


        .cta-card p {

            max-width: 650px;

            margin:
                0 auto 25px;

            color:
                rgba(255,255,255,.88);
        }


        .cta-card .btn {

            color: var(--primary);

            background: white;

            box-shadow:
                0 12px 25px
                rgba(0,0,0,.10);
        }


        /*
        |--------------------------------------------------------------------------
        | Footer
        |--------------------------------------------------------------------------
        */

        .footer {

            padding:
                55px 0 25px;

            color: #b9c0ca;

            background: #141b24;
        }


        .footer-grid {

            display: grid;

            grid-template-columns:
                1.5fr 1fr 1fr 1fr;

            gap: 40px;

            padding-bottom: 40px;
        }


        .footer-brand {

            color: white;

            margin-bottom: 12px;
        }


        .footer p {

            max-width: 360px;

            font-size: 13px;

            color: #9ba4b1;
        }


        .footer h4 {

            color: white;

            margin-bottom: 15px;

            font-size: 14px;
        }


        .footer-links {

            display: grid;

            gap: 9px;

            font-size: 13px;
        }


        .footer-links a {

            color: #9ba4b1;

            transition:
                color var(--transition);
        }


        .footer-links a:hover {

            color: white;
        }


        .copyright {

            padding-top: 22px;

            border-top:
                1px solid
                rgba(255,255,255,.08);

            text-align: center;

            font-size: 12px;

            color: #7f8997;
        }


        /*
        |--------------------------------------------------------------------------
        | Mobile Navigation
        |--------------------------------------------------------------------------
        */

        .mobile-menu {

            display: none;

            padding:
                0 0 18px;
        }


        .mobile-menu-inner {

            display: grid;

            gap: 5px;

            padding: 12px;

            border-radius: 18px;

            background: white;

            border:
                1px solid #f1e4e6;

            box-shadow:
                0 15px 35px
                rgba(16,24,40,.08);
        }


        .mobile-menu a {

            padding:
                12px 14px;

            border-radius: 10px;

            color: #4b5563;

            font-size: 14px;

            font-weight: 650;
        }


        .mobile-menu a:hover {

            color: var(--primary);

            background:
                #fff4f5;
        }


        /*
        |--------------------------------------------------------------------------
        | Tablet
        |--------------------------------------------------------------------------
        */

        @media (max-width: 1050px) {

            .nav-links {

                gap: 15px;

                font-size: 13px;
            }

            .hero-grid {

                gap: 35px;
            }

            .footer-grid {

                grid-template-columns:
                    1.4fr 1fr 1fr;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Mobile
        |--------------------------------------------------------------------------
        */

        @media (max-width: 900px) {

            .nav-links {

                display: none;
            }


            .menu-toggle {

                display: inline-flex;
            }


            .hero-grid {

                grid-template-columns: 1fr;
            }


            .hero {

                padding-top: 65px;
            }


            .hero-card {

                max-width: 650px;

                width: 100%;

                margin-inline: auto;
            }


            .stats-grid {

                grid-template-columns:
                    repeat(2, 1fr);
            }


            .stat:nth-child(2) {

                border-right: 0;
            }


            .stat:nth-child(-n+2) {

                border-bottom:
                    1px solid #f1f1f1;
            }


            .steps-grid,
            .request-grid {

                grid-template-columns:
                    repeat(2, 1fr);
            }


            .footer-grid {

                grid-template-columns:
                    1fr 1fr;
            }
        }


        @media (max-width: 680px) {

            .container {

                width:
                    calc(100% - 24px);
            }


            .nav {

                min-height: 68px;
            }


            .brand {

                font-size: 15px;
            }


            .brand-icon {

                width: 38px;
                height: 38px;

                flex-basis: 38px;

                border-radius: 12px;
            }


            .nav-actions .btn {

                display: none;
            }


            .hero {

                padding:
                    55px 0 65px;
            }


            .hero h1 {

                font-size: 39px;

                letter-spacing: -1.2px;
            }


            .hero-text {

                font-size: 15px;
            }


            .hero-card {

                min-height: 360px;

                border-radius: 26px;
            }


            .stats {

                margin-top: -20px;
            }


            .stat {

                padding:
                    20px 10px;
            }


            .stat-number {

                font-size: 25px;
            }


            .section {

                padding:
                    65px 0;
            }


            .steps-grid,
            .request-grid {

                grid-template-columns: 1fr;
            }


            .requests-header {

                align-items: flex-start;

                flex-direction: column;
            }


            .requests-header h2 {

                font-size: 28px;
            }


            .footer-grid {

                grid-template-columns: 1fr;

                gap: 28px;
            }


            .cta {

                padding:
                    65px 0;
            }


            .cta-card {

                padding:
                    50px 22px;

                border-radius: 25px;
            }
        }


        @media (max-width: 420px) {

            .hero h1 {

                font-size: 34px;
            }


            .hero-actions {

                flex-direction: column;
            }


            .hero-actions .btn {

                width: 100%;
            }


            .language-btn {

                padding:
                    0 9px;
            }


            .stats-grid {

                border-radius: 18px;
            }


            .stat-label {

                font-size: 11px;
            }


            .request-bottom {

                align-items: flex-start;

                flex-direction: column;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Reduced Motion
        |--------------------------------------------------------------------------
        */

        @media (prefers-reduced-motion: reduce) {

            html {

                scroll-behavior: auto;
            }


            *,
            *::before,
            *::after {

                animation-duration: .01ms !important;

                animation-iteration-count: 1 !important;

                transition-duration: .01ms !important;
            }
        }

    </style>

</head>


<body>


<!-- ==========================================================
     HEADER
=========================================================== -->

<header class="header">

    <div class="container">

        <div class="nav">

            <a
                href="<?= e($homeUrl) ?>"
                class="brand"
                aria-label="<?= e(t('site_name')) ?>"
            >

                <span
                    class="brand-icon"
                    aria-hidden="true"
                >
                    🩸
                </span>

                <span>
                    <?= e(t('site_name')) ?>
                </span>

            </a>


            <nav
                class="nav-links"
                aria-label="Primary navigation"
            >

                <a href="<?= e($homeUrl) ?>">
                    <?= e(t('home')) ?>
                </a>

                <a href="<?= e($findDonorUrl) ?>">
                    <?= e(t('find_donor')) ?>
                </a>

                <a href="<?= e($requestsUrl) ?>">
                    <?= e(t('blood_requests')) ?>
                </a>

                <a href="<?= e($aboutUrl) ?>">
                    <?= e(t('about')) ?>
                </a>

                <a href="<?= e($contactUrl) ?>">
                    <?= e(t('contact')) ?>
                </a>

                <a href="<?= e($faqUrl) ?>">
                    <?= e(t('faq')) ?>
                </a>

            </nav>


            <div class="nav-actions">

                <?php if ($currentLanguage === 'en'): ?>

                    <a
                        href="?lang=bn"
                        class="language-btn"
                        title="Switch to Bangla"
                    >
                        বাংলা
                    </a>

                <?php else: ?>

                    <a
                        href="?lang=en"
                        class="language-btn"
                        title="Switch to English"
                    >
                        English
                    </a>

                <?php endif; ?>


                <?php if (is_logged_in()): ?>

                    <a
                        href="<?= e($dashboardUrl) ?>"
                        class="btn btn-primary"
                    >
                        <?= e(t('dashboard')) ?>
                    </a>

                <?php else: ?>

                    <a
                        href="<?= e($loginUrl) ?>"
                        class="btn btn-outline"
                    >
                        <?= e(t('login')) ?>
                    </a>

                    <a
                        href="<?= e($registerUrl) ?>"
                        class="btn btn-primary"
                    >
                        <?= e(t('register')) ?>
                    </a>

                <?php endif; ?>


                <button
                    type="button"
                    class="menu-toggle"
                    id="menuToggle"
                    aria-label="<?= e(t('open_menu')) ?>"
                    aria-expanded="false"
                    aria-controls="mobileMenu"
                >
                    ☰
                </button>

            </div>

        </div>


        <!-- Mobile Menu -->

        <div
            class="mobile-menu"
            id="mobileMenu"
            aria-hidden="true"
        >

            <div class="mobile-menu-inner">

                <a href="<?= e($homeUrl) ?>">
                    🏠 <?= e(t('home')) ?>
                </a>

                <a href="<?= e($findDonorUrl) ?>">
                    🩸 <?= e(t('find_donor')) ?>
                </a>

                <a href="<?= e($requestsUrl) ?>">
                    🚨 <?= e(t('blood_requests')) ?>
                </a>

                <a href="<?= e($aboutUrl) ?>">
                    ℹ️ <?= e(t('about')) ?>
                </a>

                <a href="<?= e($contactUrl) ?>">
                    📞 <?= e(t('contact')) ?>
                </a>

                <a href="<?= e($faqUrl) ?>">
                    ❓ <?= e(t('faq')) ?>
                </a>

                <?php if (is_logged_in()): ?>

                    <a href="<?= e($dashboardUrl) ?>">
                        👤 <?= e(t('dashboard')) ?>
                    </a>

                <?php else: ?>

                    <a href="<?= e($loginUrl) ?>">
                        🔐 <?= e(t('login')) ?>
                    </a>

                    <a href="<?= e($registerUrl) ?>">
                        ❤️ <?= e(t('register')) ?>
                    </a>

                <?php endif; ?>

            </div>

        </div>

    </div>

</header>


<!-- ==========================================================
     MAIN
=========================================================== -->

<main>


<!-- ==========================================================
     HERO
=========================================================== -->

<section class="hero">

    <div class="container hero-grid">

        <div>

            <div class="hero-badge">

                <span aria-hidden="true">
                    🩸
                </span>

                <?= e(t('hero_badge')) ?>

            </div>


            <h1>
                <?= t('hero_title') ?>
            </h1>


            <p class="hero-text">
                <?= e(t('hero_text')) ?>
            </p>


            <div class="hero-actions">

                <a
                    href="<?= e($findDonorUrl) ?>"
                    class="btn btn-primary"
                >
                    🩸
                    <?= e(t('find_donor_btn')) ?>
                </a>


                <a
                    href="<?= e($requestsUrl) ?>"
                    class="btn btn-outline"
                >
                    🚨
                    <?= e(t('request_blood_btn')) ?>
                </a>

            </div>

        </div>


        <div class="hero-card">

            <div
                class="blood-drop"
                aria-hidden="true"
            >
                🩸
            </div>


            <div class="hero-card-content">

                <h3>
                    <?= e(t('site_name')) ?>
                </h3>

                <p>
                    <?= e(t('footer_text')) ?>
                </p>

            </div>

        </div>

    </div>

</section>


<!-- ==========================================================
     STATISTICS
=========================================================== -->

<section
    class="stats"
    aria-label="Statistics"
>

    <div class="container">

        <div class="stats-grid">

            <div class="stat">

                <span
                    class="stat-number"
                    data-count="<?= (int) $totalDonors ?>"
                >
                    0
                </span>

                <span class="stat-label">
                    <?= e(t('stats_donors')) ?>
                </span>

            </div>


            <div class="stat">

                <span
                    class="stat-number"
                    data-count="<?= (int) $totalRequests ?>"
                >
                    0
                </span>

                <span class="stat-label">
                    <?= e(t('stats_requests')) ?>
                </span>

            </div>


            <div class="stat">

                <span
                    class="stat-number"
                    data-count="<?= (int) $totalDonations ?>"
                >
                    0
                </span>

                <span class="stat-label">
                    <?= e(t('stats_donations')) ?>
                </span>

            </div>


            <div class="stat">

                <span
                    class="stat-number"
                    data-count="<?= (int) $totalDonations ?>"
                >
                    0
                </span>

                <span class="stat-label">
                    <?= e(t('stats_lives')) ?>
                </span>

            </div>

        </div>

    </div>

</section>


<!-- ==========================================================
     HOW IT WORKS
=========================================================== -->

<section class="section">

    <div class="container">

        <div class="section-heading">

            <h2>
                <?= e(t('how_title')) ?>
            </h2>

            <p>
                <?= e(t('hero_text')) ?>
            </p>

        </div>


        <div class="steps-grid">

            <article class="step">

                <div
                    class="step-icon"
                    aria-hidden="true"
                >
                    🔎
                </div>

                <h3>
                    <?= e(t('step1_title')) ?>
                </h3>

                <p>
                    <?= e(t('step1_text')) ?>
                </p>

            </article>


            <article class="step">

                <div
                    class="step-icon"
                    aria-hidden="true"
                >
                    📝
                </div>

                <h3>
                    <?= e(t('step2_title')) ?>
                </h3>

                <p>
                    <?= e(t('step2_text')) ?>
                </p>

            </article>


            <article class="step">

                <div
                    class="step-icon"
                    aria-hidden="true"
                >
                    ❤️
                </div>

                <h3>
                    <?= e(t('step3_title')) ?>
                </h3>

                <p>
                    <?= e(t('step3_text')) ?>
                </p>

            </article>

        </div>

    </div>

</section>


<!-- ==========================================================
     APPROVED BLOOD REQUESTS
=========================================================== -->

<section class="section requests-section">

    <div class="container">

        <div class="requests-header">

            <h2>
                <?= e(t('requests_title')) ?>
            </h2>


            <a
                href="<?= e($requestsUrl) ?>"
                class="btn btn-outline"
            >
                <?= e(t('view_all')) ?>
            </a>

        </div>


        <div class="request-grid">

            <?php if (!empty($bloodRequests)): ?>

                <?php foreach ($bloodRequests as $request): ?>

                    <?php

                    $emergencyLevel =
                        strtolower(
                            trim(
                                (string) (
                                    $request['emergency_level']
                                    ?? 'normal'
                                )
                            )
                        );


                    if ($emergencyLevel === 'emergency') {

                        $urgencyClass =
                            'urgency-emergency';

                        $urgencyText =
                            t('emergency');

                    } elseif ($emergencyLevel === 'urgent') {

                        $urgencyClass =
                            'urgency-urgent';

                        $urgencyText =
                            t('urgent');

                    } else {

                        $urgencyClass =
                            'urgency-normal';

                        $urgencyText =
                            t('normal');
                    }


                    $requestId =
                        isset($request['id'])
                            ? (int) $request['id']
                            : 0;

                    ?>

                    <article class="request-card">

                        <div class="request-top">

                            <div
                                class="blood-group"
                                aria-label="Blood group"
                            >
                                <?= e(
                                    $request['blood_group']
                                    ?? '—'
                                ) ?>
                            </div>


                            <span
                                class="urgency <?= e($urgencyClass) ?>"
                            >
                                <?= e($urgencyText) ?>
                            </span>

                        </div>


                        <h3>
                            <?= e(
                                $request['patient_name']
                                ?? 'Blood Request'
                            ) ?>
                        </h3>


                        <p class="request-info">

                            <strong>
                                🏥
                            </strong>

                            <span>
                                <?= e(
                                    $request['hospital_name']
                                    ?? '—'
                                ) ?>
                            </span>

                        </p>


                        <p class="request-info">

                            <strong>
                                📍
                            </strong>

                            <span>
                                <?= e(
                                    $request['location']
                                    ?? '—'
                                ) ?>
                            </span>

                        </p>


                        <?php if (
                            !empty(
                                $request['required_quantity']
                                ?? ''
                            )
                        ): ?>

                            <p class="request-info">

                                <strong>
                                    🩸
                                </strong>

                                <span>
                                    <?= e(t('quantity')) ?>:
                                    <?= e(
                                        $request[
                                            'required_quantity'
                                        ]
                                    ) ?>
                                </span>

                            </p>

                        <?php endif; ?>


                        <div class="request-bottom">

                            <span class="request-id">

                                ID:
                                <?= e(
                                    $request['request_id']
                                    ?? 'N/A'
                                ) ?>

                            </span>


                            <a
                                href="<?= e(
                                    page_url(
                                        'blood-request/view.php'
                                    )
                                ) ?>?id=<?= $requestId ?>"
                                class="btn btn-primary"
                                style="
                                    min-height:38px;
                                    padding:0 14px;
                                    font-size:12px;
                                "
                            >
                                <?= e(
                                    t('view_details')
                                ) ?>
                            </a>

                        </div>

                    </article>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="empty-state">

                    <span
                        class="empty-icon"
                        aria-hidden="true"
                    >
                        🩸
                    </span>

                    <?= e(t('no_requests')) ?>

                </div>

            <?php endif; ?>

        </div>

    </div>

</section>


<!-- ==========================================================
     CTA
=========================================================== -->

<section class="cta">

    <div class="container">

        <div class="cta-card">

            <h2>
                <?= e(t('cta_title')) ?>
            </h2>


            <p>
                <?= e(t('cta_text')) ?>
            </p>


            <a
                href="<?= e($registerUrl) ?>"
                class="btn"
            >
                ❤️
                <?= e(t('cta_button')) ?>
            </a>

        </div>

    </div>

</section>


</main>


<!-- ==========================================================
     FOOTER
=========================================================== -->

<footer class="footer">

    <div class="container">

        <div class="footer-grid">


            <!-- Brand -->

            <div>

                <div class="brand footer-brand">

                    <span class="brand-icon">
                        🩸
                    </span>

                    <?= e(t('site_name')) ?>

                </div>


                <p>
                    <?= e(t('footer_text')) ?>
                </p>

            </div>


            <!-- Quick Links -->

            <div>

                <h4>
                    <?= e(t('footer_links')) ?>
                </h4>


                <div class="footer-links">

                    <a href="<?= e($homeUrl) ?>">
                        <?= e(t('home')) ?>
                    </a>

                    <a href="<?= e($aboutUrl) ?>">
                        <?= e(t('about')) ?>
                    </a>

                    <a href="<?= e($contactUrl) ?>">
                        <?= e(t('contact')) ?>
                    </a>

                    <a href="<?= e($faqUrl) ?>">
                        <?= e(t('faq')) ?>
                    </a>

                </div>

            </div>


            <!-- Donation -->

            <div>

                <h4>
                    <?= e(t('donor_links')) ?>
                </h4>


                <div class="footer-links">

                    <a href="<?= e($findDonorUrl) ?>">
                        <?= e(t('find_donor')) ?>
                    </a>

                    <a href="<?= e($requestsUrl) ?>">
                        <?= e(t('blood_requests')) ?>
                    </a>

                    <a href="<?= e($registerUrl) ?>">
                        <?= e(t('register')) ?>
                    </a>

                </div>

            </div>


            <!-- Account -->

            <div>

                <h4>
                    <?= e(t('account_links')) ?>
                </h4>


                <div class="footer-links">

                    <?php if (is_logged_in()): ?>

                        <a href="<?= e($dashboardUrl) ?>">
                            <?= e(t('dashboard')) ?>
                        </a>

                    <?php else: ?>

                        <a href="<?= e($loginUrl) ?>">
                            <?= e(t('login')) ?>
                        </a>

                        <a href="<?= e($registerUrl) ?>">
                            <?= e(t('register')) ?>
                        </a>

                    <?php endif; ?>

                </div>

            </div>


        </div>


        <div class="copyright">

            ©
            <?= date('Y') ?>

            <?= e(t('site_name')) ?>.

            <?= e(t('all_rights')) ?>

        </div>

    </div>

</footer>


<script>

/*
|--------------------------------------------------------------------------
| Homepage JavaScript
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /*
        |--------------------------------------------------------------------------
        | Counter Animation
        |--------------------------------------------------------------------------
        */

        const counters =
            document.querySelectorAll(
                '.stat-number'
            );


        const formatNumber =
            function (number) {

                return new Intl.NumberFormat(
                    'en-US'
                ).format(number);

            };


        counters.forEach(
            function (counter) {

                const target =
                    Math.max(
                        0,
                        parseInt(
                            counter.dataset.count || '0',
                            10
                        )
                    );


                if (target === 0) {

                    counter.textContent =
                        '0';

                    return;
                }


                const duration = 1100;

                const startTime =
                    performance.now();


                const animate =
                    function (currentTime) {

                        const elapsed =
                            currentTime - startTime;


                        const progress =
                            Math.min(
                                elapsed / duration,
                                1
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | Ease Out
                        |--------------------------------------------------------------------------
                        */

                        const eased =
                            1 -
                            Math.pow(
                                1 - progress,
                                3
                            );


                        const current =
                            Math.floor(
                                target * eased
                            );


                        counter.textContent =
                            formatNumber(current);


                        if (progress < 1) {

                            requestAnimationFrame(
                                animate
                            );

                        } else {

                            counter.textContent =
                                formatNumber(target);
                        }

                    };


                requestAnimationFrame(
                    animate
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Mobile Menu
        |--------------------------------------------------------------------------
        */

        const menuToggle =
            document.getElementById(
                'menuToggle'
            );

        const mobileMenu =
            document.getElementById(
                'mobileMenu'
            );


        if (
            menuToggle &&
            mobileMenu
        ) {

            menuToggle.addEventListener(
                'click',
                function () {

                    const isOpen =
                        menuToggle.getAttribute(
                            'aria-expanded'
                        ) === 'true';


                    const nextState =
                        !isOpen;


                    menuToggle.setAttribute(
                        'aria-expanded',
                        String(nextState)
                    );


                    mobileMenu.setAttribute(
                        'aria-hidden',
                        String(!nextState)
                    );


                    mobileMenu.style.display =
                        nextState
                            ? 'block'
                            : 'none';


                    menuToggle.textContent =
                        nextState
                            ? '✕'
                            : '☰';


                    menuToggle.setAttribute(
                        'aria-label',
                        nextState
                            ? <?= json_encode(
                                t('close_menu'),
                                JSON_UNESCAPED_UNICODE
                            ) ?>
                            : <?= json_encode(
                                t('open_menu'),
                                JSON_UNESCAPED_UNICODE
                            ) ?>
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Close Mobile Menu After Navigation
            |--------------------------------------------------------------------------
            */

            mobileMenu
                .querySelectorAll('a')
                .forEach(
                    function (link) {

                        link.addEventListener(
                            'click',
                            function () {

                                mobileMenu.style.display =
                                    'none';

                                mobileMenu.setAttribute(
                                    'aria-hidden',
                                    'true'
                                );

                                menuToggle.setAttribute(
                                    'aria-expanded',
                                    'false'
                                );

                                menuToggle.textContent =
                                    '☰';

                            }
                        );

                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Reset Menu On Resize
            |--------------------------------------------------------------------------
            */

            window.addEventListener(
                'resize',
                function () {

                    if (
                        window.innerWidth > 900
                    ) {

                        mobileMenu.style.display =
                            'none';

                        mobileMenu.setAttribute(
                            'aria-hidden',
                            'true'
                        );

                        menuToggle.setAttribute(
                            'aria-expanded',
                            'false'
                        );

                        menuToggle.textContent =
                            '☰';
                    }

                }
            );

        }

    }
);

</script>


</body>

</html>
