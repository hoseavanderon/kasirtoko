@extends('layout')

@section('content')
    @include('partials.home')  
@endsection

@section('modals')
<div class="modal fade" id="reviewModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
    <div class="modal-content">

      <div class="modal-body">

        <div class="d-flex justify-content-between align-items-center mb-3 px">
          <h5 class="m-0">Review Transaksi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(0);"></button>
        </div>

        <div id="review-items" class="mb-3 px-2"></div>

        <hr class="my-2">

        <div class="px-2">
          <div class="d-flex justify-content-between" style="font-size: 1rem; font-weight: 400;">
            <span>Subtotal</span>
            <span id="review-subtotal">Rp0</span>
          </div>
          <div class="d-flex justify-content-between mb-2" style="font-size: 1rem; font-weight: 400;">
            <span>Dibayar</span>
            <span id="review-paid">Rp0</span>
          </div>
          <div class="d-flex justify-content-between fw-bold" style="font-size: 1.25rem;">
            <span>Kembalian</span>
            <span id="review-change">Rp0</span>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-success w-100" id="confirm-payment-btn">Konfirmasi Bayar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="successModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content text-center p-4">
      <div class="mb-3">
        <i class="bi bi-check-circle-fill text-success" style="font-size:4rem;"></i>
      </div>
      <h4 class="fw-bold mb-4">Transaksi Berhasil !!</h4>

      <div class="px-3">
        <div class="d-flex justify-content-between mb-1" style="font-weight: 400; font-size: 1rem;">
          <span>Subtotal</span>
          <span id="success-subtotal">Rp0</span>
        </div>
        <div class="d-flex justify-content-between mb-1" style="font-weight: 400; font-size: 1rem;">
          <span>Total</span>
          <span id="success-total">Rp0</span>
        </div>
        <div class="d-flex justify-content-between fw-bold" style="font-size: 1.25rem; color: #000;">
          <span>Kembalian</span>
          <span id="success-change">Rp0</span>
        </div>
      </div>

      <div class="mt-4">
        <button class="btn btn-primary btn-lg" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

@endsection