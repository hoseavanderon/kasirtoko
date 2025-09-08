@forelse ($products as $product)
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="product-card fade-in" data-product-id="{{ $product->id }}">
            <div class="product-image">
                <i class="bi bi-box-seam"></i> {{-- kamu bisa ganti dengan gambar produk --}}
            </div>
            <div class="card-body p-3">
                <h6 class="card-title mb-2 fw-semibold">{{ $product->nama_produk }}</h6>
                <p class="card-text text-primary fw-bold mb-0">
                    Rp {{ number_format($product->jual, 0, ',', '.') }}
                </p>
                <p class="text-muted small pt-1 mb-0">
                    {{ $product->barcode }}
                </p>
                <div class="mt-2">
                    {!! DNS1D::getBarcodeHTML($product->barcode, 'C128', 1.5, 40) !!}
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12 text-center">
        <p class="text-muted">Tidak ada produk ditemukan.</p>
    </div>
@endforelse
