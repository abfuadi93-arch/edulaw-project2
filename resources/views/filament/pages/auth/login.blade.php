<div class="edulaw-auth">
    <style>
        .edulaw-auth {
            height: 100vh;
            background:
                radial-gradient(circle at 12% 14%, rgba(37, 99, 235, .34), transparent 30rem),
                radial-gradient(circle at 86% 12%, rgba(255, 255, 255, .14), transparent 24rem),
                linear-gradient(135deg, #0f172a 0%, #0b2458 48%, #061027 100%);
            color: #0f172a;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            overflow: hidden;
            padding: clamp(12px, 2vw, 28px);
        }

        .edulaw-auth__shell {
            background: rgba(248, 250, 252, .96);
            border: 1px solid rgba(226, 232, 240, .28);
            border-radius: 8px;
            box-shadow: 0 32px 90px rgba(2, 6, 23, .42);
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(390px, .95fr);
            height: calc(100vh - clamp(24px, 4vw, 56px));
            overflow: hidden;
            position: relative;
        }

        .edulaw-auth__story {
            background:
                radial-gradient(circle at 72% 22%, rgba(99, 102, 241, .24), transparent 22rem),
                radial-gradient(circle at 20% 82%, rgba(37, 99, 235, .22), transparent 24rem),
                linear-gradient(145deg, #0f172a 0%, #0b2a63 52%, #07132f 100%);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            gap: clamp(16px, 2.2vh, 24px);
            justify-content: center;
            min-height: 100%;
            overflow: hidden;
            padding: clamp(24px, 3.2vw, 44px);
            position: relative;
        }

        .edulaw-auth__story::before,
        .edulaw-auth__story::after {
            content: "";
            pointer-events: none;
            position: absolute;
        }

        .edulaw-auth__story::before {
            background:
                linear-gradient(90deg, rgba(255, 255, 255, .72), rgba(255, 255, 255, .12)),
                repeating-linear-gradient(135deg, rgba(96, 165, 250, .28) 0, rgba(96, 165, 250, .28) 1px, transparent 1px, transparent 28px);
            height: 100%;
            left: 0;
            opacity: .48;
            top: 0;
            width: 100%;
            mask-image: radial-gradient(circle at 0 0, #000 0, transparent 36rem);
        }

        .edulaw-auth__story::after {
            border: 1px solid rgba(96, 165, 250, .28);
            border-radius: 999px;
            height: 760px;
            left: -270px;
            top: 70px;
            width: 760px;
        }

        .edulaw-auth__brand,
        .edulaw-auth__headline,
        .edulaw-auth__visual,
        .edulaw-auth__pillars {
            position: relative;
            z-index: 1;
        }

        .edulaw-auth__brand {
            align-items: center;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            gap: 14px;
            justify-content: center;
            margin-inline: auto;
            text-align: center;
            text-decoration: none;
            width: min(100%, 320px);
        }

        .edulaw-auth__brand strong,
        .edulaw-auth__brand span {
            display: block;
        }

        .edulaw-auth__brand strong {
            font-size: clamp(20px, 1.8vw, 24px);
            font-weight: 900;
            line-height: 1.1;
        }

        .edulaw-auth__brand span {
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .12em;
            margin-top: 6px;
            text-transform: uppercase;
        }

        .edulaw-auth__headline {
            max-width: 650px;
        }

        .edulaw-auth__headline h1 {
            color: #ffffff;
            font-size: clamp(34px, 3.4vw, 48px);
            font-weight: 900;
            letter-spacing: 0;
            line-height: 1.03;
            margin: 0;
        }

        .edulaw-auth__headline h1 span {
            color: #ffffff;
        }

        .edulaw-auth__headline p {
            color: rgba(226, 232, 240, .88);
            font-size: clamp(14px, 1.25vw, 16px);
            line-height: 1.6;
            margin: 14px 0 0;
            max-width: 500px;
        }

        .edulaw-auth__visual {
            align-items: end;
            display: grid;
            grid-template-columns: minmax(0, 1fr) 130px;
            margin-top: 0;
            min-height: 142px;
        }

        .edulaw-auth__workspace {
            background:
                radial-gradient(circle at 56% 42%, rgba(219, 234, 254, .24), transparent 9rem),
                linear-gradient(180deg, rgba(15, 23, 42, .28), rgba(15, 23, 42, .62)),
                linear-gradient(135deg, rgba(255, 255, 255, .12), rgba(255, 255, 255, .04));
            border: 1px solid rgba(148, 163, 184, .24);
            border-radius: 8px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .1), 0 26px 60px rgba(2, 6, 23, .26);
            min-height: 136px;
            overflow: hidden;
            padding: 22px;
            position: relative;
        }

        .edulaw-auth__workspace::before {
            background:
                linear-gradient(180deg, rgba(96, 165, 250, .18), rgba(37, 99, 235, .03)),
                linear-gradient(90deg, transparent 8%, rgba(255, 255, 255, .14) 8%, rgba(255, 255, 255, .14) 12%, transparent 12%, transparent 28%, rgba(255, 255, 255, .13) 28%, rgba(255, 255, 255, .13) 32%, transparent 32%, transparent 48%, rgba(255, 255, 255, .12) 48%, rgba(255, 255, 255, .12) 52%, transparent 52%);
            border-bottom: 1px solid rgba(148, 163, 184, .22);
            border-radius: 7px 7px 0 0;
            content: "";
            height: 86px;
            left: 28%;
            opacity: .72;
            position: absolute;
            right: 24px;
            top: 24px;
        }

        .edulaw-auth__workspace::after {
            background:
                radial-gradient(circle, rgba(255, 255, 255, .36) 1px, transparent 1.5px) 0 0 / 18px 18px,
                linear-gradient(90deg, transparent, rgba(255, 255, 255, .2), transparent);
            bottom: 32px;
            content: "";
            height: 54px;
            left: 22px;
            opacity: .32;
            position: absolute;
            right: 18px;
        }

        .edulaw-auth__constitution {
            border-bottom: 4px solid rgba(255, 255, 255, .28);
            bottom: 66px;
            height: 58px;
            left: 31%;
            opacity: .72;
            position: absolute;
            right: 24px;
            z-index: 1;
        }

        .edulaw-auth__constitution::before {
            background:
                linear-gradient(135deg, transparent 0 47%, rgba(255, 255, 255, .34) 48% 52%, transparent 53%) top center / 92px 24px no-repeat,
                linear-gradient(90deg, transparent 0 12%, rgba(255, 255, 255, .24) 12% 16%, transparent 16% 28%, rgba(255, 255, 255, .24) 28% 32%, transparent 32% 44%, rgba(255, 255, 255, .24) 44% 48%, transparent 48% 60%, rgba(255, 255, 255, .24) 60% 64%, transparent 64%) bottom center / 112px 36px no-repeat;
            content: "";
            inset: 0;
            position: absolute;
        }

        .edulaw-auth__person {
            bottom: 30px;
            height: 70px;
            position: absolute;
            width: 74px;
            z-index: 3;
        }

        .edulaw-auth__person::before {
            background: linear-gradient(145deg, #f8fafc, #bfdbfe);
            border-radius: 999px;
            content: "";
            height: 18px;
            left: 31px;
            position: absolute;
            top: 0;
            width: 18px;
        }

        .edulaw-auth__person::after {
            background: linear-gradient(135deg, #2563eb 0 55%, #1e40af 56%);
            border-radius: 18px 18px 8px 8px;
            bottom: 0;
            box-shadow: inset 12px 0 0 rgba(255, 255, 255, .14);
            content: "";
            height: 48px;
            left: 22px;
            position: absolute;
            width: 36px;
        }

        .edulaw-auth__person--left {
            left: 100px;
        }

        .edulaw-auth__person--right {
            left: 210px;
            transform: scale(.88);
        }

        .edulaw-auth__person--right::after {
            background: linear-gradient(135deg, #0f172a 0 55%, #1e3a8a 56%);
        }

        .edulaw-auth__desk {
            background: linear-gradient(90deg, #0b1f4d, #132f6d);
            border-top: 1px solid rgba(255, 255, 255, .42);
            bottom: 0;
            height: 30px;
            left: 0;
            position: absolute;
            right: 0;
            z-index: 2;
        }

        .edulaw-auth__laptop {
            background: linear-gradient(145deg, #dbeafe, #93c5fd);
            border-radius: 8px 8px 4px 4px;
            bottom: 34px;
            box-shadow: 0 16px 28px rgba(2, 6, 23, .24);
            height: 56px;
            left: 44%;
            position: absolute;
            width: 102px;
            z-index: 4;
        }

        .edulaw-auth__laptop::after {
            background: #0f172a;
            border-radius: 999px;
            content: "";
            height: 10px;
            left: 50%;
            opacity: .35;
            position: absolute;
            top: 24px;
            transform: translateX(-50%);
            width: 10px;
        }

        .edulaw-auth__book,
        .edulaw-auth__paper {
            border: 1px solid rgba(226, 232, 240, .22);
            border-radius: 6px;
            position: absolute;
        }

        .edulaw-auth__book {
            background: linear-gradient(145deg, #0b2458, #132f6d);
            bottom: 36px;
            height: 40px;
            left: 36px;
            width: 64px;
            z-index: 4;
        }

        .edulaw-auth__book::before {
            color: #ffffff;
            content: "UUD";
            font-size: 13px;
            font-weight: 900;
            left: 15px;
            position: absolute;
            top: 13px;
        }

        .edulaw-auth__paper {
            background: rgba(248, 250, 252, .94);
            bottom: 44px;
            height: 52px;
            right: 36px;
            transform: rotate(-5deg);
            width: 52px;
            z-index: 4;
        }

        .edulaw-auth__paper::before {
            background: linear-gradient(#64748b 0 0) 12px 18px / 46px 2px no-repeat,
                linear-gradient(#94a3b8 0 0) 12px 30px / 38px 2px no-repeat,
                linear-gradient(#94a3b8 0 0) 12px 42px / 44px 2px no-repeat;
            content: "";
            inset: 0;
            position: absolute;
        }

        .edulaw-auth__scale {
            align-self: end;
            height: 112px;
            margin-left: 14px;
            position: relative;
        }

        .edulaw-auth__scale::before {
            background: #ffffff;
            border-radius: 999px;
            bottom: 18px;
            content: "";
            left: 50%;
            position: absolute;
            top: 18px;
            transform: translateX(-50%);
            width: 4px;
        }

        .edulaw-auth__scale::after {
            background:
                linear-gradient(#ffffff 0 0) center 28px / 72px 3px no-repeat,
                radial-gradient(circle, #ffffff 0 4px, transparent 5px) center 24px / 14px 14px no-repeat,
                linear-gradient(#ffffff 0 0) center bottom 17px / 68px 3px no-repeat;
            content: "";
            inset: 0;
            position: absolute;
        }

        .edulaw-auth__bowl {
            border: 2px solid #ffffff;
            border-top: 0;
            border-radius: 0 0 999px 999px;
            height: 26px;
            position: absolute;
            top: 46px;
            width: 42px;
        }

        .edulaw-auth__bowl:first-child {
            left: 18px;
        }

        .edulaw-auth__bowl:last-child {
            right: 18px;
        }

        .edulaw-auth__pillars {
            backdrop-filter: blur(18px);
            background: rgba(15, 23, 42, .38);
            border: 1px solid rgba(148, 163, 184, .34);
            border-radius: 8px;
            display: grid;
            gap: 8px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            margin-top: 2px;
            margin-bottom: 0;
            padding: 10px;
        }

        .edulaw-auth__pillar {
            align-items: center;
            display: flex;
            gap: 8px;
            min-width: 0;
        }

        .edulaw-auth__pillar-icon {
            align-items: center;
            border: 1px solid rgba(255, 255, 255, .48);
            border-radius: 8px;
            color: #ffffff;
            display: inline-flex;
            flex: 0 0 auto;
            height: 32px;
            justify-content: center;
            width: 32px;
        }

        .edulaw-auth__pillar span {
            color: #ffffff;
            display: block;
            font-size: 11px;
            font-weight: 800;
            line-height: 1.35;
        }

        .edulaw-auth__form-side {
            align-items: center;
            background:
                radial-gradient(circle at 78% 12%, rgba(99, 102, 241, .1), transparent 20rem),
                linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            display: flex;
            justify-content: center;
            padding: clamp(22px, 3.4vw, 46px);
            position: relative;
        }

        .edulaw-auth__form-side::before {
            background: #ffffff;
            content: "";
            height: 118px;
            left: 0;
            position: absolute;
            top: 0;
            width: 8px;
        }

        .edulaw-auth__card {
            max-width: 420px;
            width: 100%;
        }

        .edulaw-auth__badge {
            align-items: center;
            background: #0b2458;
            border: 1px solid rgba(37, 99, 235, .22);
            border-radius: 8px;
            box-shadow: 0 14px 28px rgba(15, 23, 42, .12);
            color: #ffffff;
            display: inline-flex;
            font-size: 14px;
            font-weight: 800;
            gap: 10px;
            line-height: 1;
            margin-bottom: 18px;
            padding: 11px 18px;
            white-space: nowrap;
        }

        .edulaw-auth__badge svg {
            color: #ffffff;
            height: 20px;
            width: 20px;
        }

        .edulaw-auth__badge span {
            color: #ffffff;
        }

        .edulaw-auth__card h2 {
            color: #0b2458;
            font-size: clamp(28px, 2.7vw, 36px);
            font-weight: 900;
            letter-spacing: 0;
            line-height: 1.12;
            margin: 0;
        }

        .edulaw-auth__subheading {
            color: #475569;
            font-size: 14px;
            line-height: 1.6;
            margin: 10px 0 18px;
        }

        .edulaw-auth__card .fi-fo-field-wrp-label span {
            color: #0f172a;
            font-weight: 800;
        }

        .edulaw-auth__card .fi-form {
            gap: 14px;
        }

        .edulaw-auth__card .fi-fo-component-ctn {
            gap: 14px;
        }

        .edulaw-auth__card .fi-input-wrp {
            border-radius: 8px;
            box-shadow: 0 0 0 1px rgba(148, 163, 184, .24), 0 8px 20px rgba(15, 23, 42, .04);
        }

        .edulaw-auth__card .fi-input {
            min-height: 44px;
        }

        .edulaw-auth__card .fi-btn {
            border-radius: 8px;
            min-height: 44px;
        }

        .edulaw-auth__card .fi-btn.fi-color-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            box-shadow: 0 16px 34px rgba(37, 99, 235, .28);
        }

        .edulaw-auth__register {
            align-items: center;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            display: flex;
            flex-wrap: wrap;
            font-size: 14px;
            gap: 8px;
            justify-content: center;
            line-height: 1.6;
            margin-top: 16px;
            padding-top: 16px;
            text-align: center;
        }

        .edulaw-auth__footer {
            color: #64748b;
            font-size: 13px;
            margin-top: 16px;
            margin-bottom: 0;
            text-align: center;
        }

        .edulaw-auth__footer a {
            color: #2563eb;
            font-weight: 800;
            text-decoration: none;
        }

        @media (max-width: 980px) {
            .edulaw-auth {
                padding: 0;
            }

            .edulaw-auth__shell {
                border-radius: 0;
                grid-template-columns: 1fr;
                min-height: 100vh;
            }

            .edulaw-auth__story {
                min-height: auto;
                overflow: visible;
            }

            .edulaw-auth__visual {
                grid-template-columns: 1fr;
            }

            .edulaw-auth__scale {
                display: none;
            }
        }

        @media (max-width: 620px) {
            .edulaw-auth__story,
            .edulaw-auth__form-side {
                padding: 24px;
            }

            .edulaw-auth__headline h1 {
                font-size: 34px;
            }

            .edulaw-auth__workspace {
                min-height: 150px;
                padding: 20px;
            }

            .edulaw-auth__pillars {
                grid-template-columns: 1fr;
            }

            .edulaw-auth__badge {
                margin-bottom: 20px;
                width: 100%;
            }
        }
    .fi-body {
        overflow-x: hidden;
    }
</style>

    <div class="edulaw-auth__shell">
        <aside class="edulaw-auth__story">
                <a href="{{ url('/') }}" class="edulaw-auth__brand">
                    <span>
                        <strong>Edulaw Project</strong>
                        <span>Equal &bull; Educative &bull; Embrace</span>
                    </span>
                </a>

                <div class="edulaw-auth__headline">
                    <h1>Legal Insight for <span>Everyone</span></h1>
                </div>

                <div class="edulaw-auth__visual" aria-hidden="true">
                    <div class="edulaw-auth__workspace">
                        <div class="edulaw-auth__constitution"></div>
                        <div class="edulaw-auth__person edulaw-auth__person--left"></div>
                        <div class="edulaw-auth__person edulaw-auth__person--right"></div>
                        <div class="edulaw-auth__book"></div>
                        <div class="edulaw-auth__laptop"></div>
                        <div class="edulaw-auth__paper"></div>
                        <div class="edulaw-auth__desk"></div>
                    </div>

                    <div class="edulaw-auth__scale">
                        <span class="edulaw-auth__bowl"></span>
                        <span class="edulaw-auth__bowl"></span>
                    </div>
                </div>

                <div class="edulaw-auth__pillars" aria-label="Nilai utama Edulaw">
                    <div class="edulaw-auth__pillar">
                        <span class="edulaw-auth__pillar-icon">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H7a3 3 0 0 0-3 3V5.5Z" stroke="currentColor" stroke-width="1.7" />
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" stroke="currentColor" stroke-width="1.7" />
                            </svg>
                        </span>
                        <span>Riset Hukum Terpercaya</span>
                    </div>

                    <div class="edulaw-auth__pillar">
                        <span class="edulaw-auth__pillar-icon">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 3a7 7 0 0 0-4 12.74V18h8v-2.26A7 7 0 0 0 12 3Z" stroke="currentColor" stroke-width="1.7" />
                                <path d="M9 22h6M10 18v-3h4v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                            </svg>
                        </span>
                        <span>Insight Mendalam</span>
                    </div>

                    <div class="edulaw-auth__pillar">
                        <span class="edulaw-auth__pillar-icon">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M7 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM17 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="currentColor" stroke-width="1.7" />
                                <path d="M2.5 21a5.5 5.5 0 0 1 11 0M13.5 18.5a4.5 4.5 0 0 1 8 2.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                            </svg>
                        </span>
                        <span>Mendorong Perubahan</span>
                    </div>
                </div>
        </aside>

        <main class="edulaw-auth__form-side">
                <section class="edulaw-auth__card" aria-labelledby="edulaw-login-title">
                    <div class="edulaw-auth__badge">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M4 9h16M6 9v10M10 9v10M14 9v10M18 9v10M5 19h14M7 6l5-3 5 3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Welcome to <span>Edulaw Project</span>
                    </div>

                    <h2 id="edulaw-login-title">{{ $this->getHeading() }}</h2>

                    <p class="edulaw-auth__subheading">
                        Silakan masuk untuk melanjutkan ke platform editorial, riset, dan publikasi Edulaw.
                    </p>

                    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

                    <x-filament-panels::form id="form" wire:submit.prevent="authenticate">
                        {{ $this->form }}

                        <x-filament-panels::form.actions
                            :actions="$this->getCachedFormActions()"
                            :full-width="$this->hasFullWidthFormActions()"
                        />
                    </x-filament-panels::form>

                    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}

                    @if (filament()->hasRegistration())
                        <div class="edulaw-auth__register">
                            Belum punya akun contributor?
                            {{ $this->registerAction }}
                        </div>
                    @endif

                    <p class="edulaw-auth__footer">
                        &copy; {{ now()->year }} <a href="{{ url('/') }}">Edulaw Project</a>. All rights reserved.
                    </p>
                </section>
        </main>
    </div>
</div>
