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
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4">
                            <i class="fab fa-fw fa-wpforms"></i>Category
                        </a>
                        <div id="submenu-4" class="collapse submenu">

                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('category.index')}}">Index</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('category.create')}}">Create</a>
                                </li>
                                {{--                                <li class="nav-item">--}}
                                {{--                                    <a class="nav-link" href="multiselect.html">Multiselect</a>--}}
                                {{--                                </li>--}}
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-5" aria-controls="submenu-5">
                            <i class="fas fa-fw fa-table"></i>Users
                        </a>
                        <div id="submenu-5" class="collapse submenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('user.index')}}">Index</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('user.create')}}">Create</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-8" aria-controls="submenu-8"><i class="fas fa-fw fa-columns"></i>Product</a>
                        <div id="submenu-8" class="collapse submenu" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('product.index')}}">Index</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('product.create')}}">Create</a>
                                </li>
                                {{--                                <li class="nav-item">--}}
                                {{--                                    <a class="nav-link" href="icon-simple-lineicon.html">Simpleline Icon</a>--}}
                                {{--                                </li>--}}
                            </ul>
                        </div>
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
<script>
    $(document).ready(function() {
        // Custom click handler for collapse toggling
        $('.nav-link[data-toggle="collapse"]').on('click', function(e) {
            e.preventDefault(); // Prevent the default anchor click behavior

            var target = $(this).attr('data-target'); // Get the target submenu
            var $target = $(target); // Convert to jQuery object

            // Collapse any other open submenus
            $('.collapse').not($target).collapse('hide');

            // Toggle the collapse on the target submenu
            $target.collapse('toggle');
        });
    });
</script>
