function initPageScripts() {
    // Load more logic (jika ada)
    let visible = 5;
    const items = document.querySelectorAll('#history-list .history-item');
    const btn = document.getElementById('load-more-btn');

    function updateList() {
        items.forEach((item, i) => {
            item.style.display = i < visible ? 'flex' : 'none';
        });

        let remaining = items.length - visible;
        if (btn) {
            if (remaining > 0) {
                btn.style.display = 'inline-block';
                btn.textContent = `Load ${remaining} more`;
            } else {
                btn.style.display = 'none';
            }
        }
    }

    if(btn) {
        btn.addEventListener('click', () => {
            visible += 5;
            updateList();
        });
        updateList();
    }

    // Delete logic
    document.querySelectorAll('.btn-delete-detail').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            const detailId = this.dataset.id;
            const productName = this.dataset.product;

            Swal.fire({
                title: 'Hapus Produk?',
                text: `Yakin ingin menghapus ${productName}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/delete-detail/${detailId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Berhasil!', data.message, 'success').then(() => {
                                // Reload history partial
                                document.querySelector('.navbar-btn[data-page="history"]').click();
                            });
                        } else {
                            Swal.fire('Gagal!', data.message, 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus.', 'error');
                    });
                }
            });
        });
    });
}
initPageScripts();