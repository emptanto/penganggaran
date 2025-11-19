<!-- Bagian Footer Halaman -->
<footer class="container mt-5 py-4 text-center text-muted border-top">
    <p class="mb-0">&copy; <?= date('Y') ?> Aplikasi Penganggaran (c) Sutanto</p>
</footer>

<!-- Memuat Library CSS Tambahan -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<!-- Memuat Library JavaScript Utama -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Skrip Kustom Aplikasi -->
<script>
(function(window, $) {
    // Namespace global untuk semua fungsi aplikasi agar tidak bentrok
    window.App = window.App || {};

    // =================================================================
    // FUNGSI-FUNGSI UTAMA
    // =================================================================

    /**
     * Inisialisasi plugin Select2 pada elemen yang diberikan.
     * Menggunakan tema Bootstrap 5 untuk tampilan yang konsisten.
     * @param {jQuery} $elements - Elemen <select> yang akan diinisialisasi.
     */
    App.initSelect2 = function($elements) {
        if (!$elements || !$elements.length) return;

        $elements.each(function() {
            const $el = $(this);
            // Hancurkan instance lama jika ada, untuk re-inisialisasi
            if ($el.data('select2')) {
                $el.select2('destroy');
            }
            // Inisialisasi dengan tema Bootstrap 5 dan lebar 100%
            $el.select2({
                theme: 'bootstrap-5', // <-- KUNCI untuk tampilan yang rapi
                width: '100%',
                placeholder: $el.data('placeholder') || 'Pilih salah satu...'
            });
        });
    };

    /**
     * Menambahkan baris baru ke tabel rencana dari <template>.
     */
    App.tambahBarisRencana = function() {
        const template = document.getElementById('template-row');
        const container = document.getElementById('rencana-container');
        if (!template || !container) return;

        const newRow = template.content.cloneNode(true);
        container.appendChild(newRow);

        // Inisialisasi Select2 HANYA pada baris yang baru ditambahkan
        const $lastRow = $(container).find('tr:last-child');
        App.initSelect2($lastRow.find('.js-select2, .select2-rekening'));
    };

    /**
     * Menghapus baris dari tabel rencana.
     * @param {HTMLElement} button - Tombol 'hapus' yang diklik.
     */
    App.hapusBarisRencana = function(button) {
        const $tbody = $('#rencana-container');
        if ($tbody.find('tr').length > 1) {
            $(button).closest('tr').remove();
        } else {
            alert('Minimal harus ada satu baris rencana.');
        }
    };


    // =================================================================
    // EKSEKUSI SAAT DOKUMEN SIAP (DOCUMENT READY)
    // =================================================================
    $(function() {
        // 1. Inisialisasi semua Select2 yang ada saat halaman dimuat
        const $initialSelects = $('.select2-basic, .select2-rekening, .js-select2')
            .filter(function() {
                // Filter agar <select> di dalam <template> tidak ikut diinisialisasi
                return $(this).closest('template').length === 0;
            });
        App.initSelect2($initialSelects);

        // 2. Event listener untuk tombol 'Tambah Baris'
        $('#tambah-baris').on('click', function(e) {
            e.preventDefault();
            App.tambahBarisRencana();
        });

        // 3. Event listener untuk tombol 'Hapus Baris' (menggunakan event delegation)
        // Ini memastikan tombol hapus di baris yang baru dibuat juga berfungsi
        $('#rencana-container').on('click', '.js-hapus-baris', function(e) {
            e.preventDefault();
            App.hapusBarisRencana(this);
        });

        // 4. Jika tabel rencana kosong, tambahkan satu baris secara otomatis
        if ($('#rencana-container').length && $('#rencana-container').children().length === 0) {
            App.tambahBarisRencana();
        }
    });

})(window, jQuery);
</script>

</body>
</html>
