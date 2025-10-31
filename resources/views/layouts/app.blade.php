<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp" rel="stylesheet" />
    <title>Pondok Dukcapil Tapin</title>
    <link rel="icon" type="image/png" href="{{ asset('icon/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.5/css/lightbox.min.css" integrity="sha512-xtV3HfYNbQXS/1R1jP53KbFcU9WXiSA1RFKzl5hRlJgdOJm4OxHCWYpskm6lN0xp0XtKGpAfVShpbvlFH3MDAA==" crossorigin="anonymous" referrerpolicy="no-refer rer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12.0.3/swiper-bundle.min.css" />
    <style>
        /* Pastikan container swiper tidak overflow */
        .swiper {
            width: 100%;
            height: auto;
        }

        /* Batasi ukuran slide */
        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            aspect-ratio: 16 / 9;
            /* Opsional: jaga rasio gambar */
            max-height: 300px;
            /* Sesuaikan sesuai kebutuhan */
        }

        /* Jika slide berisi gambar */
        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            /* Penting: agar gambar tidak stretch */
            display: block;
        }

        /* Pagination styling (opsional) */
        .swiper-pagination-bullet {
            width: 8px;
            height: 8px;
            background-color: #9ca3af;
            /* Warna abu-abu muda */
            opacity: 0.8;
            /* Transparansi */
            border-radius: 50%;
            /* Bulat sempurna */
            margin: 0 4px;
            /* Jarak antar titik */
        }

        /* Pagination Aktif */
        .swiper-pagination-bullet-active {
            background-color: #3b82f6;
            /* Biru (warna primary) */
            opacity: 1;
            transform: scale(1.2);
            /* Sedikit lebih besar saat aktif */
        }

        /* ========== RESET & VARIABEL ========== */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --h-header: 60px;
            --h-footer: 64px;
            --bg-page: #e5ddd5;
            --bg-header: #075e54;
            --bg-footer: #f0f2f5;
            --bubble-me: #dcf8c6;
            --bubble-admin: #fff;
        }

        /* ========== BODY & HTML ========== */
        html,
        body {
            height: 100%;
            overflow: hidden;
            /* scrollbar hanya di chat-body */
            font-family: system-ui, Arial, sans-serif;
        }

        /* ========== WRAPPER UTAMA ========== */
        .chat-wrapper {
            width: 100%;
            height: calc(100vh - 60px);
            /* Sesuaikan dengan tinggi navbar */
            display: flex;
            flex-direction: column;
            background: var(--bg-page);
        }

        .chat-container {
            width: 100%;
            max-width: 900px;
            height: 100%;
            /* isi tinggi wrapper */
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            /* tidak boleh scroll di sini */
        }

        /* ========== HEADER ========== */
        .chat-header {
            height: var(--h-header);
            background: var(--bg-header);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            font-weight: 600;
            flex: 0 0 auto;
            /* tetap di atas */
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
        }

        /* ========== BODY / PESAN ========== */
        .chat-body {
            flex: 1 1 auto;
            /* sisa ruang tinggi */
            overflow-y: auto;
            /* hanya ini yang scroll */
            -webkit-overflow-scrolling: touch;
            padding: 15px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            background: #efeae2 url('https://web.whatsapp.com/img/bg-chat-tile-light_a4be512e7195b6b733d9110b408f075d.png');
        }

        .chat-body::-webkit-scrollbar {
            width: 7px
        }

        .chat-body::-webkit-scrollbar-thumb {
            background: #aaa;
            border-radius: 4px
        }

        /* ========== BUBBLE ========== */
        .message-wrapper {
            display: flex;
            margin-bottom: 15px;
            width: 100%;
            align-items: flex-start;
        }

        .message-wrapper.me {
            justify-content: flex-end;
        }

        .message-wrapper.admin {
            justify-content: flex-start;
        }

        .message-container {
            max-width: 50%;
            display: flex;
            flex-direction: column;
        }

        .bubble {
            padding: 10px 15px;
            border-radius: 18px;
            font-size: 16px;
            line-height: 1.4;
            word-wrap: break-word;
            white-space: pre-wrap;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
        }

        .bubble.me {
            background: var(--bubble-me);
            border-bottom-right-radius: 4px;
        }

        .bubble.admin {
            background: var(--bubble-admin);
            border-bottom-left-radius: 4px;
        }

        .message-date {
            font-size: .75rem;
            color: #667781;
            margin-top: 5px;
            padding: 0 5px;
        }

        .message-wrapper.me .message-date {
            text-align: right;
        }

        .message-wrapper.admin .message-date {
            text-align: left;
        }

        /* pembatas tanggal */
        .date-divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .date-divider span {
            background-color: #efeae2;
            padding: 5px 15px;
            color: #667781;
            font-size: .8rem;
            position: relative;
            z-index: 1;
            border-radius: 12px;
            font-weight: 500;
        }

        .date-divider::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #ccc;
            z-index: 0;
        }

        /* ========== FOOTER / INPUT ========== */
        .chat-footer {
            flex: 0 0 auto;
            /* tinggi tetap */
            height: var(--h-footer);
            max-height: var(--h-footer);
            background: var(--bg-footer);
            border-top: 1px solid #ddd;
            display: flex;
            align-items: center;
            padding: 0 15px;
            gap: 10px;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, .05);
        }

        .chat-footer input {
            flex: 1;
            border: 1px solid #ccc;
            border-radius: 24px;
            padding: 11px 16px;
            font-size: 16px;
            outline: none;
        }

        .chat-footer input:focus {
            border-color: #128c7e;
        }

        .chat-footer button {
            border: none;
            background: #128c7e;
            color: #fff;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            font-size: 15px;
            cursor: pointer;
        }

        .chat-footer button {
            flex-shrink: 0;
            width: 48px;
            height: 48px;
            border: none;
            border-radius: 50%;
            background: #128c7e;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background .2s;
        }

        .chat-footer button:hover {
            background: #075e54;
        }

        /* ========== RESPONSIVE ========== */
        @media(max-width:768px) {
            .chat-container {
                max-width: 100%;
                border-radius: 0;
            }

            .message-container {
                max-width: 70%;
            }

            .chat-body {
                padding: 10px;
            }

            .chat-footer {
                padding: 0 10px;
            }
        }

        @media(max-width:576px) {
            :root {
                --h-header: 50px;
                --h-footer: 56px;
            }

            .chat-header {
                font-size: 1rem;
            }

            .chat-footer input {
                padding: 10px 14px;
                font-size: 14px;
            }

            .chat-footer button {
                width: 40px;
                height: 40px;
            }

            .chat-footer button svg {
                width: 20px;
                height: 20px;
            }

            .message-container {
                max-width: 85%;
            }

            .bubble {
                font-size: 15px;
                padding: 8px 12px;
            }
        }

    </style>
</head>

<body class="bg-cover bg-center bg-fixed" style="background-image: url('{{ asset('images/bg.jpg') }}');">
    <div class="min-h-screen">
        @yield('content')
    </div>

    @include('layouts.partials.footer-nav')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@12.0.3/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: true
            , slidesPerView: 2
            , centeredSlides: false
            , spaceBetween: 30
            , autoplay: {
                delay: 3000
                , disableOnInteraction: false
            , }
            , pagination: {
                el: ".swiper-pagination"
                , clickable: true
            , }
        , });

    </script>
    @stack('scripts')
</body>
</html>
