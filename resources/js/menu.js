// public/js/menu.js

document.addEventListener("DOMContentLoaded", () => {
    console.log("Menu UI Loaded");

    // Efek sederhana saat tombol kategori diklik (Opsional)
    const catButtons = document.querySelectorAll('.category button');
    
    catButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Hapus kelas active dari semua tombol
            catButtons.forEach(b => b.classList.remove('active'));
            // Tambahkan ke tombol yang diklik
            this.classList.add('active');
        });
    });
});