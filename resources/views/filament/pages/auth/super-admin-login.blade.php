<x-filament-panels::page.simple>

<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        min-height: 100vh;
        font-family: Arial, sans-serif;
        background:
            url("{{ asset('images/skytech-login-bg.jpg') }}")
            center / cover
            no-repeat fixed;
        position: relative;
    }

    body::before {
        content: "";
        position: fixed;
        inset: 0;
        background: linear-gradient(
            rgba(0, 0, 0, .58),
            rgba(0, 20, 40, .38)
        );
        z-index: 0;
    }

    .skytech-login-page {
        min-height: 100vh;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 30px 15px;
        position: relative;
        z-index: 2;
    }

    .skytech-brand {
        text-align: center;
        margin-bottom: 8px;
        color: #fff;
        text-shadow: 0 0 12px rgba(255,255,255,.55);
    }

    .skytech-logo {
        width: 82px;
        height: 82px;
        object-fit: contain;
        margin: 0 auto 10px;
        filter: drop-shadow(0 4px 12px rgba(0,0,0,.45));
    }

    .skytech-name {
        font-size: 34px;
        line-height: 1.15;
        font-weight: 700;
    }

    .skytech-subtitle {
        margin-top: 7px;
        font-size: 13px;
        letter-spacing: 2px;
        color: #cfefff;
        text-transform: uppercase;
    }

    .skytech-login-card {
        width: 95%;
        max-width: 410px;
        background: transparent;
        padding: 18px;
        text-align: center;
    }

    .skytech-welcome {
        min-height: 30px;
        margin-bottom: 18px;
        color: #7dd3fc;
        font-size: 18px;
        font-weight: 500;
        transition: opacity .8s ease;
        text-shadow: 0 0 8px rgba(0,0,0,.7);
    }

    .skytech-form-title {
        width: 88%;
        margin: 10px auto 14px;
        text-align: center;
        color: #cfefff;
        font-size: 14px;
        font-weight: 500;
        text-shadow: 0 0 8px rgba(0,0,0,.7);
    }

    .skytech-login-card form {
        width: 100%;
    }

    .skytech-login-card
    .fi-fo-component-ctn {
        gap: 0 !important;
    }

    .skytech-login-card
    .fi-input-wrp {
        width: 88%;
        margin: 8px auto;
        border: 2px solid rgba(255,255,255,.25);
        border-radius: 10px;
        background: rgba(255,255,255,.92);
        box-shadow: none;
    }

    .skytech-login-card
    .fi-input {
        color: #111 !important;
        background: transparent !important;
    }

    .skytech-login-card
    .fi-input::placeholder {
        color: #555 !important;
    }

    .skytech-login-card
    .fi-fo-field-wrp-label {
        display: none;
    }

    .skytech-login-card
    .fi-checkbox {
        color: #fff !important;
    }

    .skytech-login-card
    .fi-checkbox-label {
        color: #fff !important;
    }

    .skytech-submit {
        width: 88%;
        padding: 13px;
        margin: 14px auto 8px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(90deg, #0284c7, #0ea5e9);
        color: #fff;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        display: block;
        box-shadow: 0 5px 18px rgba(0,0,0,.25);
        transition: transform .2s ease, opacity .2s ease;
    }

    .skytech-submit:hover {
        transform: translateY(-1px);
        opacity: .94;
    }

    .skytech-submit:disabled {
        opacity: .6;
        cursor: not-allowed;
    }

    .skytech-footer {
        margin-top: 15px;
        font-size: 12px;
        line-height: 1.7;
        color: #fff;
        text-shadow: 0 0 10px rgba(0,0,0,.85);
    }

    .skytech-security {
        margin-top: 5px;
        color: #cfefff;
    }

    @media (max-width: 600px) {
        .skytech-name {
            font-size: 27px;
        }

        .skytech-logo {
            width: 68px;
            height: 68px;
        }

        .skytech-login-card {
            padding: 12px;
        }

        .skytech-welcome {
            font-size: 16px;
        }
    }
</style>

<div class="skytech-login-page">

    <div class="skytech-brand">

        <img
            src="{{ site_image(siteUrlSettings('site_logo'), 'images/skytech-infranet-logo.png') }}"
            alt="{{ siteUrlSettings('site_name') ?? 'SKYTECH INFRANET' }}"
            class="skytech-logo"
        >

        <div class="skytech-name">
            {{ siteUrlSettings('site_name') ?? 'SKYTECH INFRANET ADMIN' }}
        </div>

        <div class="skytech-subtitle">
            HOTSPOT BILLING AND REAL-TIME MONITORING SYSTEM
        </div>

    </div>

    <div class="skytech-login-card">

        <div
            id="skytechWelcomeText"
            class="skytech-welcome"
        >
            Welcome to SKYTECH INFRANET ADMIN
        </div>

        <form wire:submit="authenticate">

            <div class="skytech-form-title">
                Please input your email address and password
            </div>

            {{ $this->form }}

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="skytech-submit"
            >
                <span wire:loading.remove wire:target="authenticate">
                    SIGN IN
                </span>

                <span wire:loading wire:target="authenticate">
                    SIGNING IN...
                </span>
            </button>

        </form>

        <div class="skytech-footer">

            Welcome to your administration portal<br>

            <span class="skytech-security">
                Authorized access only
            </span>

        </div>

    </div>

</div>

<script>
    const skytechMessages = [
        "Welcome to SKYTECH INFRANET ADMIN",
        "Manage your ISP from one powerful platform",
        "Manage customers and billing with ease",
        "Monitor your network and MikroTik infrastructure",
        "Manage payments, resellers and services",
        "Your network. Your business. One platform."
    ];

    let skytechMessageIndex = 0;

    const skytechText =
        document.getElementById("skytechWelcomeText");

    setInterval(() => {

        if (!skytechText) {
            return;
        }

        skytechText.style.opacity = 0;

        setTimeout(() => {

            skytechMessageIndex =
                (skytechMessageIndex + 1) %
                skytechMessages.length;

            skytechText.innerHTML =
                skytechMessages[skytechMessageIndex];

            skytechText.style.opacity = 1;

        }, 700);

    }, 3500);
</script>

</x-filament-panels::page.simple>
