<!-- ============================================================== -->
<!-- left sidebar -->
<!-- ============================================================== -->
<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Remove these duplicates at the end of the body -->
<script src="{{ asset('../assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('../assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
<div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-divider">
                        Menu
                    </li>
                    <li class="nav-item mt-3">
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!-- ============================================================== -->
<!-- end left sidebar -->
<!-- ============================================================== -->
<script src="{{ asset('../assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('../assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
<script src="{{ asset('../assets/vendor/slimscroll/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('../assets/libs/js/main-js.js') }}"></script>
