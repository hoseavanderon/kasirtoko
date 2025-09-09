@extends('layout')

@section('content')
    @include('partials.home')  
@endsection

@section('modals')
<div class="modal fade" id="reviewModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Review Transaksi</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
            <tr>
              <th>Produk</th>
              <th>Qty</th>
              <th>Harga</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody id="review-items"></tbody>
        </table>

        <div class="d-flex justify-content-between mt-3">
          <span class="fw-bold">Subtotal:</span>
          <span class="fw-bold" id="review-subtotal">Rp0</span>
        </div>
        <div class="d-flex justify-content-between">
          <span class="fw-bold">Dibayar:</span>
          <span class="fw-bold" id="review-paid">Rp0</span>
        </div>
        <div class="d-flex justify-content-between">
          <span class="fw-bold">Kembalian:</span>
          <span class="fw-bold" id="review-change">Rp0</span>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" id="confirm-payment-btn">
          Konfirmasi Bayar
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="successModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4">
      <div class="mb-3">
        <i class="bi bi-check-circle-fill text-success" style="font-size:4rem;"></i>
      </div>
      <h4 class="fw-bold mb-4">Transaksi Berhasil !!</h4>

      <div class="d-flex justify-content-between mb-2">
        <span class="fw-bold">Subtotal:</span>
        <span class="fw-bold" id="success-subtotal">Rp0</span>
      </div>
      <div class="d-flex justify-content-between mb-2">
        <span class="fw-bold">Total:</span>
        <span class="fw-bold" id="success-total">Rp0</span>
      </div>
      <div class="d-flex justify-content-between fs-4 mt-3">
        <span class="fw-bold">Kembalian:</span>
        <span class="fw-bold text-success" id="success-change">Rp0</span>
      </div>

      <div class="mt-4">
        <button class="btn btn-primary btn-lg" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

@endsection