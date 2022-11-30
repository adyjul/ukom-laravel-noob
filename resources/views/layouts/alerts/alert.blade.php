<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    const Toast = {
        success(title = " ", message = " ", timeout = 0) {
            toastr["success"](`${message}`, `${title}`, {
                timeOut: timeout,
                extendedTimeOut: timeout
            })
        },
        info(title = " ", message = " ", timeout = 0) {
            toastr["info"](`${message}`, `${title}`, {
                timeOut: timeout,
                extendedTimeOut: timeout
            })
        },
        warning(title = " ", message = " ", timeout = 0) {
            toastr["warning"](`${message}`, `${title}`, {
                timeOut: timeout,
                extendedTimeOut: timeout
            })
        },
        error(title = " ", message = " ", timeout = 0) {
            toastr["error"](`${message}`, `${title}`, {
                timeOut: timeout,
                extendedTimeOut: timeout
            })
        },
    };

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": 0,
        "extendedTimeOut": 0,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "tapToDismiss": false
    }
</script>
@if ($errors->any())
    <script>
        Toast.error('{{ $errors->first() }}')
    </script>
@endif
@if (session()->get('alert') == "alert")
    <script>
        Toast.{{ session()->get('alert-icon') }}('{{ session()->get('alert-title') }}',
            '{{ session()->get('alert-text') }}')
    </script>
@endif
