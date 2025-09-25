@extends('layouts.app')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/inventory/inventory.css') }}">
    <link rel="stylesheet" href="{{ asset('css/barangmasuk/barangmasuk.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/barangmasuk/barangmasuk.js') }}"></script>
@endpush