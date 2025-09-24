@include('layouts.partials.header')

    <div class="pos-container">
        <div class="container-fluid p-0"> 
            <div class="row g-0" id="dynamic-page-container">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/history/history.js') }}"></script>
</body>
</html>