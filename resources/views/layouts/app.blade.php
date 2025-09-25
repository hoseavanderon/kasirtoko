@include('layouts.partials.header')

@stack('styles')

<div class="main-container">
    <div class="container-fluid p-0"> 
        <div class="row g-0" id="dynamic-page-container">
            @yield('content')
        </div>
    </div>
</div>

@yield('modals')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>
</html>