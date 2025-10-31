@extends('layouts.app')

@section('content')
<div class="chat-wrapper">
    <div class="chat-container">
        <header class="chat-header">Layanan Chat Admin</header>

        <main class="chat-body" id="messages"></main>

        <form class="chat-footer" id="form">
            <input id="input" type="text" placeholder="Ketik pesan…" required>
            <button type="submit" aria-label="Kirim">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                </svg>
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /* konversi env ke JS */
    const SERVER_URL = "{{ env('SOCKET_URL') }}";
    const ADMIN_ID = "{{ env('ADMIN_ID') }}";
    const USER_ID = "{{ auth()->user()->nik}}";

    // --- DEBUG: Pastikan variabel ini terisi dengan benar ---
    console.log('Server URL:', SERVER_URL);
    console.log('Admin ID:', ADMIN_ID);
    console.log('User ID:', USER_ID);

</script>
<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
<script>
    const socket = io(SERVER_URL, {
        transports: ["websocket", "polling"]
    });
    const form = document.getElementById('form');
    const input = document.getElementById('input');
    const box = document.getElementById('messages');

    let lastDisplayedDate = null; // Untuk melacak tanggal terakhir yang ditampilkan

    // Fungsi untuk memformat tanggal
    function formatDate(dateString) {
        const date = new Date(dateString);
        const today = new Date();
        const yesterday = new Date(today);
        yesterday.setDate(yesterday.getDate() - 1);

        // Cek apakah tanggalnya hari ini
        if (date.toDateString() === today.toDateString()) {
            return 'Hari ini, ' + date.toLocaleTimeString('id-ID', {
                hour: '2-digit'
                , minute: '2-digit'
            });
        }

        // Cek apakah tanggalnya kemarin
        if (date.toDateString() === yesterday.toDateString()) {
            return 'Kemarin, ' + date.toLocaleTimeString('id-ID', {
                hour: '2-digit'
                , minute: '2-digit'
            });
        }

        // Jika bukan hari ini atau kemarin, tampilkan tanggal lengkap
        return date.toLocaleDateString('id-ID', {
            day: 'numeric'
            , month: 'long'
            , year: 'numeric'
            , hour: '2-digit'
            , minute: '2-digit'
        });
    }

    // Fungsi untuk menambahkan pembatas tanggal
    function addDateDivider(dateString) {
        const date = new Date(dateString);
        const today = new Date();
        const yesterday = new Date(today);
        yesterday.setDate(yesterday.getDate() - 1);

        let dateText;
        if (date.toDateString() === today.toDateString()) {
            dateText = 'Hari ini';
        } else if (date.toDateString() === yesterday.toDateString()) {
            dateText = 'Kemarin';
        } else {
            dateText = date.toLocaleDateString('id-ID', {
                day: 'numeric'
                , month: 'long'
                , year: 'numeric'
            });
        }

        const divider = document.createElement('div');
        divider.classList.add('date-divider');
        const span = document.createElement('span');
        span.textContent = dateText;
        divider.appendChild(span);
        box.appendChild(divider);
    }

    // FUNGSI YANG SUDAH DIPERBAIKI
    function addBubble(text, siapa = 'me', createdAt) {
        // Format tanggal
        const messageDate = new Date(createdAt);
        const messageDateString = messageDate.toDateString();

        // Tambahkan pembatas tanggal jika ini adalah pesan pertama atau tanggal berbeda dari pesan sebelumnya
        if (lastDisplayedDate === null || messageDateString !== lastDisplayedDate) {
            addDateDivider(createdAt);
            lastDisplayedDate = messageDateString;
        }

        // 1. Buat wrapper untuk pesan
        const messageWrapper = document.createElement('div');
        messageWrapper.classList.add('message-wrapper');
        messageWrapper.classList.add(siapa);

        // 2. Buat container untuk gelembung pesan dan tanggal
        const messageContainer = document.createElement('div');
        messageContainer.classList.add('message-container');

        // 3. Buat gelembung pesan
        const b = document.createElement('div');
        b.className = 'bubble ' + siapa;
        b.textContent = text;

        // 4. Buat elemen tanggal
        const messageDateElement = document.createElement('div');
        messageDateElement.classList.add('message-date');
        messageDateElement.textContent = formatDate(createdAt);

        // 5. Susun elemen
        messageContainer.appendChild(b);
        messageContainer.appendChild(messageDateElement);
        messageWrapper.appendChild(messageContainer);
        box.appendChild(messageWrapper);

        // 6. Auto-scroll ke pesan terbaru
        box.scrollTop = box.scrollHeight;
    }

    // FUNGSI YANG SUDAH DIPERBAIKI
    async function loadMessageHistory() {
        // Tampilkan indikator loading (opsional)
        box.innerHTML = '<div style="text-align:center; color:#888;">Memuat pesan...</div>';

        try {
            const response = await fetch(`${SERVER_URL}/api/messages/${ADMIN_ID}/${USER_ID}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const messages = await response.json();

            // --- DEBUG: Lihat struktur data yang diterima ---
            console.log('Messages from API:', messages);

            // Kosongkan kotak pesan sebelum menambahkan histori
            box.innerHTML = '';
            lastDisplayedDate = null; // Reset tanggal terakhir yang ditampilkan

            // Tampilkan setiap pesan
            messages.forEach(msg => {
                // PERBAIKAN: Akses ID pengirim dari objek 'sender' yang bersarang
                // Fallback ke msg.senderId jika 'sender' tidak ada
                const senderIdFromApi = msg.sender ? msg.sender.id : msg.senderId;

                // Bandingkan dengan ID user yang sedang login
                const sender = (senderIdFromApi == USER_ID) ? 'me' : 'admin';

                addBubble(msg.content, sender, msg.createdAt);
            });

        } catch (error) {
            console.error('Gagal memuat histori pesan:', error);
            box.innerHTML = '<div style="text-align:center; color:red;">Gagal memuat pesan lama.</div>';
        }
    }

    // Panggil fungsi untuk memuat histori saat halaman dibuka
    loadMessageHistory();

    socket.on('connect', () => {
        socket.emit('register', {
            id: `${USER_ID}`
            , username: '{{ auth()->user()->name }}'
            , role: 'user'
        });
    });
    socket.on('newMessageFromAdmin', m => addBubble(m.content, 'admin', m.createdAt));

    form.addEventListener('submit', e => {
        e.preventDefault();
        const pesan = input.value.trim();
        if (!pesan) return;

        // Tambahkan pesan ke UI dengan timestamp saat ini
        const now = new Date().toISOString();
        addBubble(pesan, 'me', now);

        // Kirim pesan ke server
        socket.emit('sendMessageToAdmin', pesan);
        input.value = '';
    });

    // Fokus otomatis ke input saat halaman dimuat
    window.addEventListener('load', () => {
        input.focus();
    });

    // Fokus kembali ke input setelah mengirim pesan
    input.addEventListener('blur', () => {
        setTimeout(() => input.focus(), 100);
    });

</script>
@endpush
