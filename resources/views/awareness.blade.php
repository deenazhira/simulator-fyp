@extends('layouts.app')

@section('content')

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f5f5f5;
    }

    .top-banner {
        background: #4C1D95;
        padding: 40px 0;
        text-align: center;
        color: white;
    }

    .section {
        width: 85%;
        margin: 40px auto;
    }

    .subtitle {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #4C1D95;
    }

    .card {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        margin-bottom: 40px;
    }

    .protect-container {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .protect-item {
        width: 30%;
        text-align: center;
    }

    .protect-item img {
        width: 100%;
        border-radius: 15px;
    }

    .didyouknow {
        display: flex;
        gap: 20px;
    }

    .didyou-card {
        background: #4C1D95;
        color: white;
        padding: 20px;
        border-radius: 15px;
        flex: 1;
    }

    .article-box {
        width: 40%;
        background: white;
        border-radius: 15px;
        padding: 15px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
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
            Social engineering is a manipulation technique that tricks people into revealing confidential
            information.
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
            <h3>💡 90% of cyber attacks start with social engineering</h3>
            <p>Awareness is your first defense.</p>
        </div>

        <div class="article-box">
            <img src="https://i.imgur.com/Y0nPp2V.jpeg">
            <p><b>Johor police dismantle AI-driven job scam syndicate</b></p>
        </div>
    </div>
</div>

@endsection
