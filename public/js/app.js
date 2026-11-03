/* ===================================================
   RAMEN DAPUR GILA — App JavaScript
   =================================================== */

// ---------- Toggle Password Visibility ----------
function togglePw(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// ---------- Toggle Navigation Mobile ----------
function toggleNav() {
    const links = document.getElementById('navLinks');
    const icon = document.getElementById('navToggleIcon');

    links.classList.toggle('open');

    if (links.classList.contains('open')) {
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-times');
    } else {
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
    }
}

// ---------- Toggle Dropdown Profil ----------
function toggleDropdown() {
    const menu = document.getElementById('dropdownMenu');
    menu.classList.toggle('show');
}

// Tutup dropdown saat klik di luar
document.addEventListener('click', function (e) {
    const dropdown = document.getElementById('navDropdown');
    const menu = document.getElementById('dropdownMenu');

    if (dropdown && menu && !dropdown.contains(e.target)) {
        menu.classList.remove('show');
    }
});

// ---------- Toggle Sidebar Admin ----------
function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    sidebar.classList.toggle('open');
}

// Tutup sidebar saat klik di luar (mobile)
document.addEventListener('click', function (e) {
    const sidebar = document.getElementById('adminSidebar');
    const toggle = document.querySelector('.sidebar-toggle');

    if (sidebar && sidebar.classList.contains('open') &&
        !sidebar.contains(e.target) &&
        toggle && !toggle.contains(e.target)) {
        sidebar.classList.remove('open');
    }
});

// ---------- Quantity Control (Keranjang) ----------
function changeQty(btn, delta) {
    const form = btn.closest('form');
    const input = form.querySelector('.qty-value');
    let val = parseInt(input.value) || 1;
    let max = parseInt(input.max) || 999;

    val += delta;

    if (val < 1) val = 1;
    if (val > max) val = max;

    input.value = val;

    // Submit form setelah debounce singkat
    clearTimeout(btn._timeout);
    btn._timeout = setTimeout(function () {
        form.submit();
    }, 400);
}

// ---------- Auto-hide Alert ----------
document.addEventListener('DOMContentLoaded', function () {
    const alerts = document.querySelectorAll('.alert');

    alerts.forEach(function (alert) {
        setTimeout(function () {
            alert.style.transition = 'opacity 0.4s, transform 0.4s';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-8px)';

            setTimeout(function () {
                alert.remove();
            }, 400);
        }, 4000);
    });

    // ---------- Owner Dashboard Chart ----------
    const chartCanvas = document.getElementById('pendapatanChart');

    if (chartCanvas) {
        // Ambil data dari Blade (di-encode sebagai JSON)
        const chartLabels = chartCanvas.dataset.labels
            ? JSON.parse(chartCanvas.dataset.labels)
            : [];
        const chartData = chartCanvas.dataset.values
            ? JSON.parse(chartCanvas.dataset.values)
            : [];

        new Chart(chartCanvas, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: chartData,
                    backgroundColor: 'rgba(194, 32, 32, 0.6)',
                    borderColor: 'rgba(194, 32, 32, 1)',
                    borderWidth: 1,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e1e1e',
                        titleColor: '#f5f5f5',
                        bodyColor: '#888',
                        borderColor: '#2a2a2a',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 10,
                        callbacks: {
                            label: function (ctx) {
                                return 'Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#555',
                            font: { size: 11 }
                        },
                        grid: { display: false },
                        border: { display: false }
                    },
                    y: {
                        ticks: {
                            color: '#555',
                            font: { size: 11 },
                            callback: function (val) {
                                if (val >= 1000000) return 'Rp ' + (val / 1000000).toFixed(1) + 'jt';
                                if (val >= 1000) return 'Rp ' + (val / 1000).toFixed(0) + 'rb';
                                return 'Rp ' + val;
                            }
                        },
                        grid: { color: 'rgba(42,42,42,0.5)' },
                        border: { display: false }
                    }
                }
            }
        });
    }
});

// ---------- Confirm Delete (tambahan safety) ----------
document.querySelectorAll('form[method="POST"]').forEach(function (form) {
    const methodInput = form.querySelector('input[name="_method"]');
    if (methodInput && methodInput.value.toUpperCase() === 'DELETE') {
        if (!form.onsubmit) {
            form.onsubmit = function () {
                return confirm('Yakin ingin menghapus data ini?');
            };
        }
    }
});