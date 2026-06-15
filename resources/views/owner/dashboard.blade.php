<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Owner — Kelolain</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="name">Kelolain</div>
            <div class="sub">Business Manager</div>
        </div>

        <nav class="sidebar-nav">
            <a class="nav-item active" href="/owner/dashboard">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7" />
                    <rect x="14" y="3" width="7" height="7" />
                    <rect x="14" y="14" width="7" height="7" />
                    <rect x="3" y="14" width="7" height="7" />
                </svg>
                Dashboard
            </a>
            <a class="nav-item" href="#">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="20" x2="18" y2="10" />
                    <line x1="12" y1="20" x2="12" y2="4" />
                    <line x1="6" y1="20" x2="6" y2="14" />
                </svg>
                Analytics
            </a>
            <a class="nav-item" href="#">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <path d="M16 10a4 4 0 0 1-8 0" />
                </svg>
                Product
            </a>
            <a class="nav-item" href="#">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                </svg>
                Tiketin
            </a>
            <a class="nav-item" href="#">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                User
            </a>
        </nav>

        <div class="sidebar-bottom">
            <a class="nav-item" href="#">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3" />
                    <path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14" />
                </svg>
                Settings
            </a>
            <a class="nav-item" href="#" id="logoutBtn" style="color: #e05555;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                Logout
            </a>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main">

        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                <input type="text" placeholder="Cari data, laporan, atau admin...">
            </div>
            <div class="topbar-right">
                <div class="topbar-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                </div>
                <div class="topbar-user">
                    <div class="topbar-user-info">
                        <div class="uname" id="userName">Loading...</div>
                        <div class="urole">Super Admin</div>
                    </div>
                    <div class="topbar-avatar" id="userAvatar">--</div>
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <div class="content">

            <!-- Page Header -->
            <div class="page-header">
                <div>
                    <div class="page-title">Ringkasan Administrasi</div>
                    <div class="page-subtitle">Kelola infrastruktur bisnis dan pantau performa sistem secara realtime.
                    </div>
                </div>
                <div class="header-right">
                    <div class="date-range">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                        <span id="dateRange">01 Jan 2026 – 31 Des 2026</span>
                    </div>
                    <button class="btn-cetak">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 6 2 18 2 18 9" />
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                            <rect x="6" y="14" width="12" height="8" />
                        </svg>
                        Cetak Laporan
                    </button>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="cards-grid">
                <div class="card">
                    <div class="card-header">
                        <div class="card-icon green">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </div>
                        <span class="card-badge up">↑ +5%</span>
                    </div>
                    <div class="card-label">Total Organisasi</div>
                    <div class="card-value" id="totalOrganisasi">—</div>
                    <div class="card-desc">Dibandingkan bulan lalu</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-icon blue">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>
                        <span class="card-badge up">↑ +12%</span>
                    </div>
                    <div class="card-label">Total User Aktif</div>
                    <div class="card-value" id="totalUserAktif">—</div>
                    <div class="card-desc">Pengguna terverifikasi</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-icon orange">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="1" x2="12" y2="23" />
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                            </svg>
                        </div>
                        <span style="font-size:11px;color:#aaa;">Hari ini</span>
                    </div>
                    <div class="card-label">Transaksi Sistem</div>
                    <div class="card-value" id="totalTransaksi">—</div>
                    <div class="card-desc">Volume operasional harian</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-icon teal">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                            </svg>
                        </div>
                        <span class="card-badge online">3 ONLINE</span>
                    </div>
                    <div class="card-label">Health Status</div>
                    <div class="card-value" id="healthStatus">—</div>
                    <div class="card-desc" id="healthDesc">• System Online</div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="charts-row">
                <!-- Pertumbuhan User -->
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Pertumbuhan User</div>
                            <div class="chart-subtitle">Tren penambahan user 6 bulan terakhir</div>
                        </div>
                        <div class="chart-menu">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="1" />
                                <circle cx="19" cy="12" r="1" />
                                <circle cx="5" cy="12" r="1" />
                            </svg>
                        </div>
                    </div>
                    <div class="chart-wrap">
                        <canvas id="userGrowthChart"></canvas>
                    </div>
                </div>

                <!-- Distribusi Produk -->
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Distribusi Produk</div>
                            <div class="chart-subtitle">Per kategori organisasi utama</div>
                        </div>
                    </div>
                    <div class="distribusi-list" id="distribusiList">
                        <div style="text-align:center;padding:20px;color:#bbb;font-size:13px;">Memuat data...</div>
                    </div>
                    <a href="#" class="distribusi-link">Lihat Detail Kategori ›</a>
                </div>
            </div>

            <!-- Aktivitas Admin -->
            <div class="table-card">
                <div class="table-header">
                    <div>
                        <div class="table-title">Aktivitas Admin Terakhir</div>
                        <div class="table-subtitle">Riwayat perubahan dan akses sistem terkini</div>
                    </div>
                    <div class="table-actions">
                        <button class="table-btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="21" y1="10" x2="7" y2="10" />
                                <line x1="21" y1="6" x2="3" y2="6" />
                                <line x1="21" y1="14" x2="3" y2="14" />
                                <line x1="21" y1="18" x2="7" y2="18" />
                            </svg>
                        </button>
                        <button class="table-btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="7 10 12 15 17 10" />
                                <line x1="12" y1="15" x2="12" y2="3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Admin Name</th>
                            <th>Action</th>
                            <th>Timestamp</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="aktivitasTable">
                        <tr>
                            <td colspan="5" style="text-align:center;padding:24px;color:#bbb;font-size:13px;">
                                Memuat data aktivitas...
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="table-footer">
                    <span id="tableInfo">Memuat...</span>
                    <div class="pagination">
                        <button class="page-btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="15 18 9 12 15 6" />
                            </svg>
                        </button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        const API_BASE = '/api';
        const token = localStorage.getItem('token');
        const user = JSON.parse(localStorage.getItem('user') || '{}');

        // Auth guard
        if (!token || !user || user.role !== 'owner') {
            window.location.href = '/login';
        }

        // Set user info di topbar
        if (user.name) {
            document.getElementById('userName').textContent = user.name;
            const initials = user.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
            document.getElementById('userAvatar').textContent = initials;
        }

        // Logout
        document.getElementById('logoutBtn').addEventListener('click', async function(e) {
            e.preventDefault();
            try {
                await fetch(`${API_BASE}/logout`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });
            } catch (e) {}
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            window.location.href = '/login';
        });

        // Format currency
        function formatRupiah(num) {
            if (num >= 1000000000) return 'Rp ' + (num / 1000000000).toFixed(1) + 'B';
            if (num >= 1000000) return 'Rp ' + (num / 1000000).toFixed(1) + 'M';
            if (num >= 1000) return 'Rp ' + (num / 1000).toFixed(0) + 'K';
            return 'Rp ' + num.toLocaleString('id-ID');
        }

        // Format time ago
        function timeAgo(dateStr) {
            const diff = Math.floor((new Date() - new Date(dateStr)) / 60000);
            if (diff < 1) return 'Baru saja';
            if (diff < 60) return diff + ' menit yang lalu';
            if (diff < 1440) return Math.floor(diff / 60) + ' jam yang lalu';
            return Math.floor(diff / 1440) + ' hari yang lalu';
        }

        // Avatar colors
        const avatarColors = ['#2d6a4f', '#3b6fd4', '#e8830a', '#8b5cf6', '#0d9488'];

        function getAvatarColor(name) {
            let hash = 0;
            for (let c of name) hash = c.charCodeAt(0) + ((hash << 5) - hash);
            return avatarColors[Math.abs(hash) % avatarColors.length];
        }

        let userGrowthChart = null;

        // Fetch Dashboard Data
        async function fetchDashboard() {
            try {
                const year = new Date().getFullYear();
                const res = await fetch(`${API_BASE}/owner/dashboard?year=${year}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                if (res.status === 401 || res.status === 403) {
                    localStorage.removeItem('token');
                    localStorage.removeItem('user');
                    window.location.href = '/login';
                    return;
                }

                const json = await res.json();
                if (!json.status) return;

                const data = json.data;

                // === Summary Cards ===
                document.getElementById('totalOrganisasi').textContent = data.summary.total_organisasi.toLocaleString(
                    'id-ID');
                document.getElementById('totalUserAktif').textContent = data.summary.total_user_aktif.toLocaleString(
                    'id-ID');
                document.getElementById('totalTransaksi').textContent = formatRupiah(data.summary.total_transaksi);
                document.getElementById('healthStatus').textContent = data.summary.health_status.percentage + '%';
                document.getElementById('healthDesc').textContent = '• ' + data.summary.health_status.status;

                // === Chart Pertumbuhan User ===
                const labels = data.chart.pertumbuhan_user.map(d => d.nama_bulan);
                const values = data.chart.pertumbuhan_user.map(d => d.total_user);

                if (userGrowthChart) userGrowthChart.destroy();

                const ctx = document.getElementById('userGrowthChart').getContext('2d');
                userGrowthChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            data: values,
                            backgroundColor: values.map((v, i) =>
                                i === values.length - 1 ? '#2d6a4f' : '#d4e9df'
                            ),
                            borderRadius: 6,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: ctx => ctx.raw + ' user'
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    },
                                    color: '#aaa'
                                }
                            },
                            y: {
                                grid: {
                                    color: '#f5f5f3'
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    },
                                    color: '#aaa'
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });

                // === Distribusi Produk ===
                const distribusiList = document.getElementById('distribusiList');
                if (data.chart.distribusi_produk.length === 0) {
                    distribusiList.innerHTML =
                        '<div style="text-align:center;padding:20px;color:#bbb;font-size:13px;">Belum ada data produk</div>';
                } else {
                    const maxTotal = Math.max(...data.chart.distribusi_produk.map(d => d.total_produk));
                    distribusiList.innerHTML = data.chart.distribusi_produk.slice(0, 4).map(item => `
                        <div class="distribusi-item">
                            <div class="distribusi-item-header">
                                <span>${item.nama_category}</span>
                                <span>${item.total_produk} items</span>
                            </div>
                            <div class="distribusi-bar">
                                <div class="distribusi-bar-fill" style="width: ${(item.total_produk / maxTotal * 100)}%"></div>
                            </div>
                        </div>
                    `).join('');
                }

                // === Aktivitas Admin ===
                const tbody = document.getElementById('aktivitasTable');
                if (data.aktivitas_admin.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="5" style="text-align:center;padding:24px;color:#bbb;font-size:13px;">
                                Belum ada aktivitas admin
                            </td>
                        </tr>`;
                } else {
                    const jenisLabel = {
                        'harga_nol': 'Produk Harga Rp 0',
                        'nama_tidak_sesuai': 'Nama Produk Tidak Sesuai',
                        'kategori_terlarang': 'Kategori Terlarang'
                    };

                    tbody.innerHTML = data.aktivitas_admin.map(item => {
                        const initials = item.admin_name.split(' ').map(n => n[0]).join('').substring(0, 2)
                            .toUpperCase();
                        const color = getAvatarColor(item.admin_name);
                        const label = jenisLabel[item.action] || item.action;
                        return `
                        <tr>
                            <td>
                                <div class="avatar-cell">
                                    <div class="avatar-sm" style="background:${color}">${initials}</div>
                                    <span class="avatar-name">${item.admin_name}</span>
                                </div>
                            </td>
                            <td>
                                <div class="action-cell">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                    ${label} — ${item.nama_produk}
                                </div>
                            </td>
                            <td>${timeAgo(item.timestamp)}</td>
                            <td><span class="badge success">SUCCESS</span></td>
                            <td>
                                <button class="view-btn">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>`;
                    }).join('');

                    document.getElementById('tableInfo').textContent =
                        `Menampilkan 1–${data.aktivitas_admin.length} dari ${data.aktivitas_admin.length} aktivitas`;
                }

            } catch (err) {
                console.error('Dashboard error:', err);
            }
        }

        fetchDashboard();
    </script>

</body>

</html>
