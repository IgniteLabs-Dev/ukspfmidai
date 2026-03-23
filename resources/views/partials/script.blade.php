<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sidebarmenu.js') }}"></script>
<script src="{{ asset('js/app.min.js') }}"></script>
<script src="{{ asset('libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('libs/simplebar/dist/simplebar.js') }}"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.22.0/tabler-icons.min.css"
    integrity="sha512-WvVks4DZApcwzyMhU3G/wQLG2EvzRP6R8kUXA71bLKDPzIBclTO/eRCnXXoSmsCZHeYcp0tUUjPimbZcA1U/uw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>




<script>
    $(document).ready(function() {
        $('.add-user-jabatan, .add-user-atasan-langsung, .add-user-atasan-atasan-langsung').select2();
    });
</script>


@stack('scripts')
