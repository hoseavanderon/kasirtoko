

function addDenomination(amount) {
    const paidAmountInput = document.getElementById('paid-amount');
    if (!paidAmountInput) return;

    let currentValue = paidAmountInput.value;
    let currentNumber = parseInt(currentValue.replace(/[^0-9]/g, '')) || 0;

    let newAmount = currentNumber + amount;

    paidAmountInput.value = formatRupiah(newAmount);

    updateChangeDisplay();
}

function toggleFullscreen() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen().catch(err => {
            console.error('Error attempting to enable fullscreen:', err);
        });
    } else {
        document.exitFullscreen().catch(err => {
            console.error('Error attempting to exit fullscreen:', err);
        });
    }
}

document.getElementById('refresh-btn').addEventListener('click', function() {
    // Reload halaman saat tombol diklik
    location.reload();
});

// Event listeners
document.addEventListener('DOMContentLoaded', function() {  
    
    // Fullscreen button
    document.getElementById('fullscreen-btn').addEventListener('click', toggleFullscreen);
    
    const fullscreenBtn = document.getElementById('fullscreen-btn');
    const fullscreenIcon = document.getElementById('fullscreen-icon');

    fullscreenBtn.addEventListener('click', () => {
        if (!document.fullscreenElement) {
            // Android Chrome OK, iOS Safari akan fallback
            document.documentElement.requestFullscreen?.().catch(err => {
                console.warn('Fullscreen gagal:', err);
            });
        } else {
            document.exitFullscreen?.().catch(err => {
                console.warn('Exit fullscreen gagal:', err);
            });
        }
    });

    document.addEventListener('fullscreenchange', () => {
        if (document.fullscreenElement) {
            fullscreenIcon.className = 'bi bi-fullscreen-exit';
            fullscreenBtn.title = 'Exit Fullscreen';
        } else {
            fullscreenIcon.className = 'bi bi-arrows-fullscreen';
            fullscreenBtn.title = 'Enter Fullscreen';
        }
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // F11 for fullscreen
        if (e.key === 'F11') {
            e.preventDefault();
            toggleFullscreen();
        }
        
        // Escape to clear barcode input
        if (e.key === 'Escape') {
            document.getElementById('barcode-input').value = '';
            document.getElementById('barcode-input').focus();
        }
    });
    
    // Keep barcode input focused
    setInterval(() => {
        const barcodeInput = document.getElementById('barcode-input');
        if (!barcodeInput) return; // ❌ hentikan kalau input tidak ada

        const activeElement = document.activeElement;
        if (activeElement === document.body && !document.querySelector('.modal.show')) {
            barcodeInput.focus();
        }
    }, 1000);
});
