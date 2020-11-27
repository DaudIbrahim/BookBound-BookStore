<!-- JS Scripts-->

<!-- jQuery Js -->
<script src="{{ asset('assets/admin') }}/assets/js/jquery-1.10.2.js"></script>

<!-- Bootstrap Js -->
<script src="{{ asset('assets/admin') }}/assets/js/bootstrap.min.js"></script>
<script src="{{ asset('assets/admin') }}/assets/materialize/js/materialize.min.js"></script>

<!-- Metis Menu Js -->
<script src="{{ asset('assets/admin') }}/assets/js/jquery.metisMenu.js"></script>

<!-- Morris Chart Js -->
<script src="{{ asset('assets/admin') }}/assets/js/morris/raphael-2.1.0.min.js"></script>
<script src="{{ asset('assets/admin') }}/assets/js/morris/morris.js"></script>

<!-- Custom Js -->
<script src="{{ asset('assets/admin') }}/assets/js/custom-scripts.js"></script>

{{-- Axios Library --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js" 
    integrity="sha256-bd8XIKzrtyJ1O5Sh3Xp3GiuMIzWC42ZekvrMMD4GxRg=" crossorigin="anonymous"></script>

{{-- Personalize JS --}}
@yield('javascript')