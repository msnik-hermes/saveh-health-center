<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="سامانه یکپارچه مدیریت مرکز بهداشت شهرستان ساوه — پرسنل، مراکز، بازرسی، سلامت خانواده و گزارش‌گیری.">
    <title>مرکز بهداشت ساوه | سامانه مدیریت</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        /* Fallback if vite assets missing */
        body { margin: 0; font-family: Vazirmatn, Tahoma, sans-serif; background: #fbfaf7; color: #2c3530; }
    </style>
</head>
<body class="min-h-[100dvh] overflow-x-hidden bg-bone-50 text-ink-900 antialiased">
    {{-- ambient wash --}}
    <div aria-hidden="true" class="pointer-events-none fixed inset-0 -z-10">
        <div class="absolute -left-24 top-[-10%] h-[420px] w-[420px] rounded-full bg-forest-400/15 blur-3xl"></div>
        <div class="absolute right-[-8%] top-[20%] h-[360px] w-[360px] rounded-full bg-amber-signal/10 blur-3xl"></div>
        <div class="absolute inset-x-0 bottom-0 h-48 bg-gradient-to-t from-forest-950/5 to-transparent"></div>
        <div class="absolute inset-0 opacity-[0.035]" style="background-image:url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22n%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.85%22 numOctaves=%222%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23n)%22/%3E%3C/svg%3E');"></div>
    </div>

    <header class="shell pt-6">
        <div class="surface-shell reveal">
            <div class="surface-core flex items-center justify-between gap-4 px-4 py-3 sm:px-5">
                <a href="/" class="flex items-center gap-3">
                    <span class="grid h-11 w-11 place-items-center rounded-2xl bg-forest-800 text-bone-50 shadow-[0_12px_28px_-14px_rgba(13,31,23,0.8)]">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 3.5c-1.2 2.4-3.8 4-6.5 4.2.4 4.8 2.9 8.5 6.5 10.8 3.6-2.3 6.1-6 6.5-10.8C15.8 7.5 13.2 5.9 12 3.5Z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M12 8v5M9.5 10.5h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="leading-tight">
                        <span class="block text-sm font-semibold text-forest-950">مرکز بهداشت ساوه</span>
                        <span class="block text-xs text-ink-500">سامانه مدیریت یکپارچه</span>
                    </span>
                </a>

                <nav class="hidden items-center gap-6 text-sm text-ink-600 md:flex">
                    <a href="#modules" class="transition-colors hover:text-forest-800">ماژول‌ها</a>
                    <a href="#workflow" class="transition-colors hover:text-forest-800">گردش‌کار</a>
                    <a href="#trust" class="transition-colors hover:text-forest-800">امنیت</a>
                </nav>

                <div class="flex items-center gap-2">
                    <a href="{{ url('/admin/login') }}" class="btn-secondary !px-4 !py-2 text-xs sm:text-sm">ورود پنل</a>
                    <a href="{{ url('/admin') }}" class="btn-primary !px-4 !py-2 text-xs sm:text-sm">
                        داشبورد
                        <span class="grid h-6 w-6 place-items-center rounded-full bg-white/15">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><path d="M7.5 2.5H9.5V4.5M9.5 2.5L5 7M2.5 3.5V9.5H8.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        {{-- Hero --}}
        <section class="shell grid items-center gap-10 py-14 lg:grid-cols-12 lg:gap-8 lg:py-20">
            <div class="lg:col-span-7">
                <div class="eyebrow reveal">استان مرکزی · شهرستان ساوه</div>
                <h1 class="reveal reveal-delay-1 mt-5 max-w-[16ch] text-4xl font-bold leading-[1.15] tracking-tight text-forest-950 sm:text-5xl lg:text-[3.4rem]">
                    مدیریت سلامت شبکه را
                    <span class="text-forest-600">شفاف، سریع و یکپارچه</span>
                    کنید
                </h1>
                <p class="reveal reveal-delay-2 mt-5 max-w-[58ch] text-base leading-8 text-ink-600 sm:text-lg">
                    سامانه مرکز بهداشت ساوه، عملیات روزمره واحدها را از پرسنل و خودرو تا مراقبت مادر و کودک، بازرسی و گزارش‌گیری در یک پنل فارسی و امن جمع می‌کند.
                </p>

                <div class="reveal reveal-delay-3 mt-8 flex flex-wrap items-center gap-3">
                    <a href="{{ url('/admin/login') }}" class="btn-primary">
                        ورود به سامانه
                        <span class="grid h-8 w-8 place-items-center rounded-full bg-white/12">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M8 3H11V6M11 3L6 8M3 4V11H10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                    </a>
                    <a href="#modules" class="btn-secondary">مشاهده قابلیت‌ها</a>
                </div>

                <dl class="reveal reveal-delay-4 mt-10 grid grid-cols-3 gap-3 sm:max-w-lg">
                    <div class="rounded-2xl border border-ink-900/5 bg-white/70 px-3 py-3 text-center backdrop-blur-sm">
                        <dt class="text-[11px] text-ink-500">جداول داده</dt>
                        <dd class="mt-1 text-xl font-bold tabular-nums text-forest-900">۱۰۳</dd>
                    </div>
                    <div class="rounded-2xl border border-ink-900/5 bg-white/70 px-3 py-3 text-center backdrop-blur-sm">
                        <dt class="text-[11px] text-ink-500">مدل دامنه</dt>
                        <dd class="mt-1 text-xl font-bold tabular-nums text-forest-900">۹۱</dd>
                    </div>
                    <div class="rounded-2xl border border-ink-900/5 bg-white/70 px-3 py-3 text-center backdrop-blur-sm">
                        <dt class="text-[11px] text-ink-500">زبان رابط</dt>
                        <dd class="mt-1 text-xl font-bold text-forest-900">FA</dd>
                    </div>
                </dl>
            </div>

            <div class="lg:col-span-5">
                <div class="surface-shell reveal reveal-delay-2">
                    <div class="surface-core relative overflow-hidden p-5 sm:p-6">
                        <div class="absolute inset-x-0 top-0 h-24 bg-gradient-to-b from-forest-100/70 to-transparent"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between">
                                <p class="text-xs font-medium tracking-wide text-ink-500">نمای عملیاتی</p>
                                <span class="rounded-full bg-forest-100 px-2.5 py-1 text-[11px] font-medium text-forest-800">زنده</span>
                            </div>
                            <p class="mt-3 text-2xl font-bold tracking-tight text-forest-950">داشبورد شبکه بهداشت</p>
                            <p class="mt-2 text-sm leading-7 text-ink-600">وضعیت مراکز، درخواست‌ها و مراقبت‌ها در یک نگاه.</p>

                            <div class="mt-6 grid grid-cols-2 gap-3">
                                <article class="rounded-2xl bg-forest-950 p-4 text-bone-50">
                                    <p class="text-[11px] text-forest-200">مراکز فعال</p>
                                    <p class="mt-2 text-3xl font-bold tabular-nums">۲۴</p>
                                    <p class="mt-3 text-xs text-forest-300">شهر + روستا</p>
                                </article>
                                <article class="rounded-2xl border border-ink-900/5 bg-bone-50 p-4">
                                    <p class="text-[11px] text-ink-500">درخواست باز</p>
                                    <p class="mt-2 text-3xl font-bold tabular-nums text-forest-900">18</p>
                                    <p class="mt-3 text-xs text-ink-500">تاسیسات / IT / خودرو</p>
                                </article>
                                <article class="col-span-2 rounded-2xl border border-ink-900/5 bg-gradient-to-l from-white to-forest-50 p-4">
                                    <div class="flex items-center justify-between gap-3">
                                        <div>
                                            <p class="text-[11px] text-ink-500">بازرسی‌های این ماه</p>
                                            <p class="mt-1 text-2xl font-bold tabular-nums text-forest-900">47</p>
                                        </div>
                                        <div class="h-12 w-28 rounded-xl bg-[linear-gradient(90deg,#c3decd_0%,#64a57f_45%,#2d6b4b_100%)] opacity-90"></div>
                                    </div>
                                </article>
                            </div>

                            <ul class="mt-5 space-y-2.5">
                                <li class="flex items-center justify-between rounded-xl bg-ink-50/80 px-3 py-2.5 text-sm">
                                    <span class="text-ink-700">مراقبت بارداری</span>
                                    <span class="rounded-full bg-forest-100 px-2 py-0.5 text-[11px] text-forest-800">به‌روز</span>
                                </li>
                                <li class="flex items-center justify-between rounded-xl bg-ink-50/80 px-3 py-2.5 text-sm">
                                    <span class="text-ink-700">نظارت بیماری</span>
                                    <span class="rounded-full bg-amber-signal/15 px-2 py-0.5 text-[11px] text-[color:var(--color-amber-signal)]">نیازمند پیگیری</span>
                                </li>
                                <li class="flex items-center justify-between rounded-xl bg-ink-50/80 px-3 py-2.5 text-sm">
                                    <span class="text-ink-700">ارزیابی خطر شغلی</span>
                                    <span class="rounded-full bg-forest-100 px-2 py-0.5 text-[11px] text-forest-800">ثبت شد</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Modules bento --}}
        <section id="modules" class="shell py-10 lg:py-16">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="eyebrow">ماژول‌ها</p>
                    <h2 class="mt-4 max-w-[18ch] text-3xl font-bold tracking-tight text-forest-950 sm:text-4xl">پوشش واقعی شبکه بهداشت، نه فقط چند فرم</h2>
                </div>
                <p class="max-w-sm text-sm leading-7 text-ink-600">از منابع انسانی و پشتیبانی تا سلامت خانواده، محیط و حرفه‌ای — با رابط فارسی و ساختار سلسله‌مراتبی مراکز.</p>
            </div>

            <div class="mt-10 grid grid-cols-1 gap-4 md:grid-cols-12">
                <article class="surface-shell md:col-span-7">
                    <div class="surface-core h-full p-6 sm:p-8">
                        <p class="text-xs font-medium tracking-[0.16em] text-forest-700 uppercase">سازمان و منابع</p>
                        <h3 class="mt-3 text-2xl font-bold text-forest-950">مراکز، پرسنل، شرکت‌ها</h3>
                        <p class="mt-3 max-w-[48ch] text-sm leading-7 text-ink-600">سلسله‌مراتب مراکز، قراردادها، حضور و غیاب، و ارتباط با واحدهای سازمانی در یک منبع واحد داده.</p>
                        <div class="mt-6 flex flex-wrap gap-2">
                            <span class="rounded-full bg-forest-50 px-3 py-1 text-xs text-forest-800">Centers</span>
                            <span class="rounded-full bg-forest-50 px-3 py-1 text-xs text-forest-800">Employees</span>
                            <span class="rounded-full bg-forest-50 px-3 py-1 text-xs text-forest-800">Companies</span>
                        </div>
                    </div>
                </article>

                <article class="surface-shell md:col-span-5">
                    <div class="surface-core h-full bg-forest-950 p-6 text-bone-50 sm:p-8">
                        <p class="text-xs font-medium tracking-[0.16em] text-forest-300 uppercase">عملیات</p>
                        <h3 class="mt-3 text-2xl font-bold">درخواست و پشتیبانی</h3>
                        <p class="mt-3 text-sm leading-7 text-forest-100/80">تاسیسات، IT و خودرو با مسیر تأیید و پیگیری وضعیت.</p>
                        <div class="mt-8 grid grid-cols-3 gap-2 text-center">
                            <div class="rounded-2xl bg-white/8 p-3"><p class="text-lg font-bold">F</p><p class="mt-1 text-[10px] text-forest-200">Facility</p></div>
                            <div class="rounded-2xl bg-white/8 p-3"><p class="text-lg font-bold">IT</p><p class="mt-1 text-[10px] text-forest-200">Support</p></div>
                            <div class="rounded-2xl bg-white/8 p-3"><p class="text-lg font-bold">V</p><p class="mt-1 text-[10px] text-forest-200">Vehicle</p></div>
                        </div>
                    </div>
                </article>

                <article class="surface-shell md:col-span-4">
                    <div class="surface-core h-full p-6">
                        <h3 class="text-lg font-bold text-forest-950">سلامت خانواده</h3>
                        <p class="mt-2 text-sm leading-7 text-ink-600">بارداری، واکسیناسیون، مدارس، سالمندان و جمعیت.</p>
                    </div>
                </article>
                <article class="surface-shell md:col-span-4">
                    <div class="surface-core h-full p-6">
                        <h3 class="text-lg font-bold text-forest-950">بازرسی و ایمنی</h3>
                        <p class="mt-2 text-sm leading-7 text-ink-600">بازرسی مراکز/شرکت‌ها، ارزیابی خطر و بهداشت محیط.</p>
                    </div>
                </article>
                <article class="surface-shell md:col-span-4">
                    <div class="surface-core h-full p-6">
                        <h3 class="text-lg font-bold text-forest-950">مالی و انبار</h3>
                        <p class="mt-2 text-sm leading-7 text-ink-600">بودجه، تراکنش، موجودی و توزیع واکسن/دارو.</p>
                    </div>
                </article>
            </div>
        </section>

        {{-- Workflow --}}
        <section id="workflow" class="shell py-10 lg:py-16">
            <div class="surface-shell">
                <div class="surface-core overflow-hidden">
                    <div class="grid lg:grid-cols-12">
                        <div class="border-b border-ink-900/5 p-7 sm:p-10 lg:col-span-5 lg:border-b-0 lg:border-l">
                            <p class="eyebrow">گردش‌کار</p>
                            <h2 class="mt-4 text-3xl font-bold tracking-tight text-forest-950">از ثبت تا اقدام، بدون پراکندگی فایل</h2>
                            <p class="mt-4 text-sm leading-7 text-ink-600">هر واحد داده را همان‌جا که تولید می‌شود ثبت می‌کند؛ مدیر شبکه وضعیت را یک‌جا می‌بیند.</p>
                        </div>
                        <ol class="grid gap-0 p-2 sm:grid-cols-3 lg:col-span-7">
                            <li class="rounded-[1.2rem] p-5">
                                <span class="grid h-9 w-9 place-items-center rounded-full bg-forest-100 text-sm font-bold text-forest-800">۱</span>
                                <h3 class="mt-4 font-bold text-forest-950">ثبت در واحد</h3>
                                <p class="mt-2 text-sm leading-7 text-ink-600">فرم‌های تخصصی با فیلدهای دامنه بهداشت ایران.</p>
                            </li>
                            <li class="rounded-[1.2rem] p-5">
                                <span class="grid h-9 w-9 place-items-center rounded-full bg-forest-100 text-sm font-bold text-forest-800">۲</span>
                                <h3 class="mt-4 font-bold text-forest-950">تأیید و ارجاع</h3>
                                <p class="mt-2 text-sm leading-7 text-ink-600">مسیر approval برای درخواست‌ها و موارد حساس.</p>
                            </li>
                            <li class="rounded-[1.2rem] p-5">
                                <span class="grid h-9 w-9 place-items-center rounded-full bg-forest-100 text-sm font-bold text-forest-800">۳</span>
                                <h3 class="mt-4 font-bold text-forest-950">گزارش شبکه</h3>
                                <p class="mt-2 text-sm leading-7 text-ink-600">تجمیع برای مدیریت شهرستان و سطوح بالاتر.</p>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        {{-- Trust --}}
        <section id="trust" class="shell py-10 lg:py-16">
            <div class="grid items-center gap-8 lg:grid-cols-2">
                <div>
                    <p class="eyebrow">اعتماد و دسترسی</p>
                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-forest-950 sm:text-4xl">ساخته‌شده برای محیط دولتی و حساس</h2>
                    <p class="mt-4 max-w-[52ch] text-sm leading-7 text-ink-600 sm:text-base">
                        نقش‌ها، لاگ فعالیت، محدودیت واحد، و پنل مدیریتی مبتنی بر Filament — با جهت‌گیری RTL و تایپوگرافی فارسی.
                    </p>
                    <ul class="mt-6 space-y-3 text-sm text-ink-700">
                        <li class="flex items-start gap-3"><span class="mt-1 h-2 w-2 rounded-full bg-forest-600"></span>کنترل دسترسی مبتنی بر نقش</li>
                        <li class="flex items-start gap-3"><span class="mt-1 h-2 w-2 rounded-full bg-forest-600"></span>ثبت رخداد و ممیزی</li>
                        <li class="flex items-start gap-3"><span class="mt-1 h-2 w-2 rounded-full bg-forest-600"></span>رابط فارسی راست‌چین برای کاربران میدانی</li>
                    </ul>
                </div>
                <div class="surface-shell">
                    <div class="surface-core p-6 sm:p-8">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-forest-950">آماده ورود</p>
                            <span class="text-xs text-ink-500">Admin Panel</span>
                        </div>
                        <p class="mt-3 text-sm leading-7 text-ink-600">با حساب مدیریت وارد شوید و از داشبورد شبکه شروع کنید.</p>
                        <div class="mt-6 rounded-2xl bg-ink-50 p-4 text-sm">
                            <p class="text-ink-500">مسیر پنل</p>
                            <p class="mt-1 font-mono text-forest-900" dir="ltr">/admin</p>
                        </div>
                        <a href="{{ url('/admin/login') }}" class="btn-primary mt-6 w-full">ورود به پنل مدیریت</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="shell pb-12 pt-6">
        <div class="flex flex-col gap-4 border-t border-ink-900/8 pt-8 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-forest-800 text-bone-50">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3.5c-1.2 2.4-3.8 4-6.5 4.2.4 4.8 2.9 8.5 6.5 10.8 3.6-2.3 6.1-6 6.5-10.8C15.8 7.5 13.2 5.9 12 3.5Z" stroke="currentColor" stroke-width="1.5"/></svg>
                </span>
                <div>
                    <p class="text-sm font-semibold text-forest-950">مرکز بهداشت شهرستان ساوه</p>
                    <p class="text-xs text-ink-500">Saveh Health Center Management System</p>
                </div>
            </div>
            <p class="text-xs text-ink-500">طراحی رابط با استاندارد trust-first · Laravel + Filament</p>
        </div>
    </footer>
</body>
</html>
