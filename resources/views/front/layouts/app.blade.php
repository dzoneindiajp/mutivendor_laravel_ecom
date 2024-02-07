<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!-- Include Head -->

@include('front.includes.head')

@php
$page = !empty($page) ? $page : '';
@endphp
<body style="{{(!empty($page) && $page == 'login') ? 'background-image: url('.asset('assets/front/img/about/login.jpg').'); background-attachment: fixed;' : '' }}">
    @if(empty($page) && $page != 'login')
    @include('front.includes.header')
    @endif
  
    @if(Session::has('error'))
        <script type="text/javascript">
            $(document).ready(function(e) {

                show_message("{{{ Session::get('error') }}}", 'error');
            });
        </script>
    @endif
    @if(Session::has('success'))
        <script type="text/javascript">
            $(document).ready(function(e) {
                show_message("{{{ Session::get('success') }}}", 'success');
            });
        </script>
    @endif
    @if(Session::has('flash_notice'))
        <script type="text/javascript">
            $(document).ready(function(e) {
                show_message("{{{ Session::get('flash_notice') }}}", 'success');
            });
        </script>
    @endif
    @if(Session::has('warning'))
        <script type="text/javascript">
            $(document).ready(function(e) {
                show_message("{{{ Session::get('warning') }}}", 'warning');
            });
        </script>
    @endif
    @yield('content')
        
    <!-- </div> -->
    @if(empty($page) && $page != 'login')
    <!-- Include Footer -->
    @include('front.includes.footer')
    @endif
    <script src="{{ asset('assets/front/js/vendor/modernizr-3.6.0.min.js') }}"></script>

    <script src="{{ asset('assets/front/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/front/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>


    <script src="{{ asset('assets/front/js/ajax_request.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Retrieve the flash message from local storage
            var flashMessage = localStorage.getItem('flashMessage');
            var flashMessageTitle = localStorage.getItem('flashMessageTitle');
            if (flashMessage) {
                // Display the flash message using your preferred method
                show_message(flashMessage, 'success', flashMessageTitle ? { title: flashMessageTitle } : {});

                // Clear the flash message from local storage to avoid showing it again
                localStorage.removeItem('flashMessage');
                localStorage.removeItem('flashMessageTitle');
            }

           
        });
        function show_message(message, type, attributes = {}) {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            if (type == 'success') {
                toastr.success(message, attributes.hasOwnProperty('title') ? attributes.title : '');
                // toastr.success(message,attributes.hasOwnProperty('title') ? attributes.title : 'Success');
            } else if (type == 'error') {
                toastr.error(message, attributes.hasOwnProperty('title') ? attributes.title : '');
            } else if (type == 'warning') {
                toastr.warning(message, attributes.hasOwnProperty('title') ? attributes.title : '');
            }

        }
    </script>
    

    @stack('scripts')

</body>

</html>
