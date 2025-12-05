@extends('layouts.app')

@section('content')

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f5f5f5;
        color: #333;
    }

    /* Banner */
    .top-banner {
        background: #4C1D95;
        padding: 60px 0;
        text-align: center;
        color: white;
    }

    .top-banner h1 {
        font-size: 40px;
        font-weight: 800;
        letter-spacing: 1px;
    }

    /* Section wrapper */
    .section {
        width: 85%;
        margin: 50px auto;
    }

    /* Section Title */
    .subtitle {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 25px;
        color: #4C1D95;
    }

    /* Card */
    .card {
        background: white;
        padding: 30px;
        font-size: 18px;
        line-height: 1.8;
        border-radius: 15px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.1);
        margin-bottom: 40px;
    }

    /* Protect images */
    .protect-container {
        display: flex;
        justify-content: space-between;
        gap: 25px;
        flex-wrap: wrap;
    }

    .protect-item {
        width: 32%;
        text-align: center;
        font-size: 18px;
        font-weight: 600;
    }

    .protect-item img {
        width: 100%;
        border-radius: 15px;
        margin-bottom: 12px;
    }

    /* Did you know */
    .didyouknow {
        display: flex;
        gap: 20px;
        align-items: stretch;
    }

    .didyou-card {
        background: #4C1D95;
        color: white;
        padding: 30px;
        border-radius: 15px;
        flex: 1;
        font-size: 18px;
        line-height: 1.6;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .didyou-card h3 {
        font-size: 26px;
        font-weight: 800;
        margin-bottom: 10px;
    }

    /* Article Box */
    .article-box {
        width: 40%;
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: 0.25s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .article-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }

    .article-box img {
        width: 100%;
        border-radius: 15px;
        margin-bottom: 15px;
    }

    .article-box p {
        font-size: 20px;
        font-weight: 700;
        color: #333;
        margin-top: auto;
    }

    @media screen and (max-width: 900px) {
        .protect-item {
            width: 100%;
        }
        .didyouknow {
            flex-direction: column;
        }
        .article-box {
            width: 100%;
        }
    }
</style>

<div class="top-banner">
    <h1>Awareness Page – Stay One Step Ahead</h1>
</div>

<div class="section">
    <div class="subtitle">What Is Social Engineering?</div>
    <div class="card">
        <p>
            Social engineering is a psychological manipulation technique used by attackers to trick individuals
            into revealing sensitive information. These scams often appear harmless — coming in the form of
            texts, calls, emails, or social media messages — making them one of the most effective cyberattack
            methods today.
        </p>
    </div>
</div>

<div class="section">
    <div class="subtitle">How To Protect Yourself</div>

    <div class="protect-container">

        <div class="protect-item">
            <img src="https://i.imgur.com/8N2iHnb.jpeg">
            <p>Never share passwords or OTPs</p>
        </div>

        <div class="protect-item">
            <img src="https://i.imgur.com/o1VKVvY.jpeg">
            <p>Always verify unexpected messages</p>
        </div>

        <div class="protect-item">
            <img src="https://i.imgur.com/6LgJrF5.jpeg">
            <p>Check links carefully</p>
        </div>

    </div>
</div>

<div class="section">
    <div class="subtitle">Did You Know?</div>

    <div class="didyouknow">

        <div class="didyou-card">
            <h3>💡 90% of cyber attacks begin with social engineering</h3>
            <p>Building awareness is the simplest and most effective first line of defense.</p>
        </div>

        <!-- CLICKABLE ARTICLE BOX -->
        <a href="https://www.thestar.com.my/news/nation/2025/12/04/silence-is-golden-in-new-call-scam"
           target="_blank"
           style="text-decoration: none; color: inherit;">

            <div class="article-box">
                <img src="{{ asset('images/article.png') }}" alt="article thumbnail">
                <p>Silence Is Golden in New Call Scam</p>
            </div>

        </a>

    </div>
</div>

@endsection
