@include('layouts.header')
@include('layouts.navbar')
<div class="dashboard-main-wrapper">
    @include('layouts.sidebar')
    <div class="dashboard-wrapper">
        <div class="container-fluid  dashboard-content">
            @yield('content')
            @yield('script')
        </div>
        @include('layouts.footer')
    </div>
</div>
