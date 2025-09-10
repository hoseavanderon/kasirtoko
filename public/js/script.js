
function addDenomination(amount) {
    var paidAmountInput = document.getElementById('paid-amount');
    if (!paidAmountInput) return;

    var currentValue = paidAmountInput.value;
    var currentNumber = parseInt(currentValue.replace(/[^0-9]/g, '')) || 0;

    var newAmount = currentNumber + amount;
    paidAmountInput.value = formatRupiah(newAmount);

    updateChangeDisplay();
}

// Toggle fullscreen (desktop & tablet/HP Android)
// Catatan: Safari iOS tidak mendukung requestFullscreen
function toggleFullscreen() {
    if (!document.fullscreenElement) {
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen().catch(function(err) {
                console.error('Error attempting to enable fullscreen:', err);
            });
        }
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen().catch(function(err) {
                console.error('Error attempting to exit fullscreen:', err);
            });
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {  
    // ================= REFRESH BUTTON =================
    var refreshBtn = document.getElementById('refresh-btn');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function() {
            location.reload();
        });
        refreshBtn.addEventListener('touchend', function() {
            location.reload();
        });
    }

    // ================= FULLSCREEN BUTTON =================
    var fullscreenBtn = document.getElementById('fullscreen-btn');
    var fullscreenIcon = document.getElementById('fullscreen-icon');

    if (fullscreenBtn) {
        fullscreenBtn.addEventListener('click', toggleFullscreen);
        fullscreenBtn.addEventListener('touchend', toggleFullscreen);
    }

    document.addEventListener('fullscreenchange', function() {
        if (document.fullscreenElement) {
            fullscreenIcon.className = 'bi bi-fullscreen-exit';
            fullscreenBtn.title = 'Exit Fullscreen';
        } else {
            fullscreenIcon.className = 'bi bi-arrows-fullscreen';
            fullscreenBtn.title = 'Enter Fullscreen';
        }
    });

    // ================= KEYBOARD SHORTCUTS =================
    document.addEventListener('keydown', function(e) {
        // F11 for fullscreen
        if (e.key === 'F11') {
            e.preventDefault();
            toggleFullscreen();
        }

        // Escape to clear barcode input
        if (e.key === 'Escape') {
            var barcodeInput = document.getElementById('barcode-input');
            if (barcodeInput) {
                barcodeInput.value = '';
                barcodeInput.focus();
            }
        }
    });

    // ================= KEEP BARCODE INPUT FOCUSED =================
    setInterval(function() {
        var barcodeInput = document.getElementById('barcode-input');
        if (!barcodeInput) return;

        var activeElement = document.activeElement;
        if (activeElement === document.body && !document.querySelector('.modal.show')) {
            barcodeInput.focus();
        }
    }, 1000);
});

