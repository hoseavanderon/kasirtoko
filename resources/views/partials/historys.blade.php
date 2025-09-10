
  <style>
    body { font-family: 'Inter', sans-serif; background: #f5f7fb; }
    .sidebar {
      height: 100vh;
      overflow-y: auto;
      border-right: 1px solid #e5e7eb;
      background: #fff;
      padding: 1rem;
    }
    .content {
      padding: 2rem;
    }
    .date-link { cursor: pointer; }
    .date-link:hover { text-decoration: underline; }
  </style>


<div class="container-fluid">
  <div class="row">
    
    <!-- Sidebar -->
    <div class="col-12 col-md-3 sidebar">
      <h5 class="mb-3">Riwayat</h5>
      <div class="accordion" id="accordionTahun">

        <!-- Tahun 2025 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tahun2025">
              2025
            </button>
          </h2>
          <div id="tahun2025" class="accordion-collapse collapse" data-bs-parent="#accordionTahun">
            <div class="accordion-body p-0">

              <!-- Bulan September -->
              <div class="accordion" id="accordion2025">
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed small" type="button" data-bs-toggle="collapse" data-bs-target="#bulanSep2025">
                      September
                    </button>
                  </h2>
                  <div id="bulanSep2025" class="accordion-collapse collapse" data-bs-parent="#accordion2025">
                    <div class="accordion-body py-2">
                      <ul class="list-unstyled mb-0">
                        <li class="date-link" onclick="loadData('2025-09-10')">10 September 2025</li>
                        <li class="date-link" onclick="loadData('2025-09-09')">09 September 2025</li>
                        <li class="date-link" onclick="loadData('2025-09-08')">08 September 2025</li>
                      </ul>
                    </div>
                  </div>
                </div>

                <!-- Bulan Agustus -->
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed small" type="button" data-bs-toggle="collapse" data-bs-target="#bulanAgst2025">
                      Agustus
                    </button>
                  </h2>
                  <div id="bulanAgst2025" class="accordion-collapse collapse" data-bs-parent="#accordion2025">
                    <div class="accordion-body py-2">
                      <ul class="list-unstyled mb-0">
                        <li class="date-link" onclick="loadData('2025-08-31')">31 Agustus 2025</li>
                        <li class="date-link" onclick="loadData('2025-08-30')">30 Agustus 2025</li>
                      </ul>
                    </div>
                  </div>
                </div>

              </div>
              <!-- End accordion bulan -->
            </div>
          </div>
        </div>

        <!-- Tahun 2024 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tahun2024">
              2024
            </button>
          </h2>
          <div id="tahun2024" class="accordion-collapse collapse" data-bs-parent="#accordionTahun">
            <div class="accordion-body py-2">
              <ul class="list-unstyled mb-0">
                <li class="date-link" onclick="loadData('2024-12-31')">31 Desember 2024</li>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Content -->
    <div class="col-12 col-md-9 content">
      <h4 id="title-riwayat">Pilih tanggal di sidebar</h4>
      <div id="riwayat-container" class="mt-3">
        <!-- Data akan dimuat di sini -->
      </div>
    </div>

  </div>
</div>

<script>
  function loadData(date) {
    document.getElementById('title-riwayat').innerText = "Riwayat Penjualan " + date;
    document.getElementById('riwayat-container').innerHTML = `
      <div class="card mb-3">
        <div class="card-body">
          <h5>Indomie Goreng</h5>
          <p>2 pcs · Rp 8.000</p>
        </div>
      </div>
      <div class="card mb-3">
        <div class="card-body">
          <h5>Aqua Botol 600ml</h5>
          <p>3 pcs · Rp 12.000</p>
        </div>
      </div>
    `;
  }
</script>
