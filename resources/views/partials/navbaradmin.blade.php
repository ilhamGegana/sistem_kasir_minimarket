<!-- resources/views/partials/navbar.blade.php -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <!-- Form Logout -->
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="nav-link btn btn-link" style="border: none; padding: 0;">
                    Logout
                </button>
            </form>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <span class="nav-link" id="current-time">
                <!-- Waktu akan diisi oleh JavaScript -->
            </span>
        </li>
    </ul>
</nav>

@push('scripts')
    <script>
        // Fungsi untuk mendapatkan waktu sekarang dalam format yang diinginkan
        function updateTime() {
            var now = new Date();
            var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            var formattedTime = now.toLocaleDateString('id-ID', options);
            document.getElementById('current-time').innerHTML = formattedTime;
        }

        // Jalankan fungsi updateTime setiap 1 detik
        setInterval(updateTime, 1000);

        // Jalankan fungsi updateTime sekali saat halaman pertama kali dimuat
        updateTime();
    </script>
@endpush

