@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }

    /* --- 1. Top Hero Section (Purple) --- */
    .hero-section {
        background-color: #4A0080; /* Deep Purple */
        color: white;
        padding: 60px 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 50px;
    }

    .hero-content {
        max-width: 600px;
    }

    .hero-title {
        font-size: 2.5rem; /* Big Title */
        font-weight: 800;
        margin-bottom: 20px;
    }

    .hero-box {
        background: rgba(255, 255, 255, 0.1); /* Semi-transparent box */
        padding: 30px;
        border-radius: 20px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* --- 2. Protection Section (White) --- */
    .protect-section {
        background: white;
        padding: 60px 20px;
        text-align: center;
    }

    .section-title {
        color: #333;
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 50px;
        display: inline-block;
    }

    /* Adds the little shield icon before the title */
    .section-title::before {
        content: '\f3ed'; /* FontAwesome Shield Icon code */
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        margin-right: 10px;
        color: #4A0080;
    }

    .protect-grid {
        display: flex;
        justify-content: center;
        gap: 50px;
        flex-wrap: wrap;
    }

    .protect-card {
        width: 250px;
        text-align: center;
    }

    /* The Round Icon Circles */
    .icon-circle {
        width: 100px;
        height: 100px;
        margin: 0 auto 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .protect-card:hover .icon-circle {
        transform: scale(1.1); /* Pop effect on hover */
    }

    /* Specific Colors for each icon */
    .bg-blue { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .bg-yellow { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .bg-cyan { background: linear-gradient(135deg, #06b6d4, #0891b2); }

    .protect-text {
        font-weight: 600;
        color: #4b5563;
        font-size: 1.1rem;
    }

    /* --- 3. Did You Know Footer (Purple) --- */
    .footer-section {
        background-color: #4A0080;
        color: white;
        padding: 60px 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 60px;
        flex-wrap: wrap;
    }

    .fact-box {
        max-width: 500px;
    }

    /* The News Article Card */
    .news-card {
        background: white;
        width: 350px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        transition: transform 0.3s ease;
        text-decoration: none; /* Remove underline from link */
        display: block;
    }

    .news-card:hover {
        transform: translateY(-10px); /* Float up on hover */
    }

    .news-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .news-content {
        padding: 20px;
    }

    .news-title {
        color: #1f2937;
        font-weight: 700;
        font-size: 1.2rem;
        line-height: 1.4;
        margin-bottom: 10px;
    }

    .news-meta {
        color: #6b7280;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }

</style>

<div class="hero-section">
    <div class="hidden md:block">
        <i class="fas fa-user-shield" style="font-size: 180px; opacity: 0.8;"></i>
    </div>

    <div class="hero-content">
        <h1 class="hero-title">Awareness Page – Stay One Step Ahead</h1>

        <div class="hero-box">
            <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 15px;">What Is Social Engineering?</h3>
            <p style="font-size: 1.1rem; line-height: 1.6; opacity: 0.9;">
                Social engineering is a manipulation technique that tricks people into revealing confidential information.
                It’s one of the most common methods used by attackers today — often disguised as normal messages or requests.
            </p>
        </div>
    </div>
</div>

<div class="protect-section">
    <h2 class="section-title">How To Protect Yourself</h2>

    <div class="protect-grid">
        <div class="protect-card">
            <div class="icon-circle bg-blue">
                <i class="fas fa-lock"></i>
            </div>
            <p class="protect-text">Never share passwords or OTPs</p>
        </div>

        <div class="protect-card">
            <div class="icon-circle bg-yellow">
                <i class="fas fa-search-dollar"></i>
            </div>
            <p class="protect-text">Always verify unexpected emails or messages</p>
        </div>

        <div class="protect-card">
            <div class="icon-circle bg-cyan">
                <i class="fas fa-mouse-pointer"></i>
            </div>
            <p class="protect-text">Check links before clicking – hover to see the URL</p>
        </div>
    </div>
</div>

<div class="footer-section">

    <div class="fact-box">
        <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 20px;">
            <i class="far fa-lightbulb text-yellow-300"></i> Did You Know?
        </h2>
        <p style="font-size: 1.25rem; line-height: 1.6;">
            90% of cyber attacks start with a social engineering trick. <br><br>
            Awareness is your first line of defense. Stay updated on the latest scams happening in Malaysia.
        </p>
    </div>

    <a href="https://www.thestar.com.my/news/nation/2025/12/04/silence-is-golden-in-new-call-scam" target="_blank" class="news-card">
        <img src="{{ asset('images/article.png') }}" alt="News Thumbnail" class="news-image">

        <div class="news-content">
            <div class="news-meta">
                <i class="far fa-newspaper"></i> The Star • News
            </div>
            <h3 class="news-title">Johor police dismantle AI-driven job scam syndicate targeting Russian</h3>
            <span style="color: #4A0080; font-weight: 600; font-size: 0.9rem;">Read Article →</span>
        </div>
    </a>

</div>

@endsection

