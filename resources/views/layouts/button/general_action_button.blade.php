@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '._btn_act', function() {
                let targetUrl = $(this).attr('href')
                let title = $(this).data("title") ?? ''
                let text = $(this).data("text") == undefined ? 'Yakin Melakukan Aksi?' : $(this).data(
                    "text")

                Swal.fire({
                    icon: 'question',
                    title,
                    text,
                    showCancelButton: true,
                    confirmButtonText: 'Ya!',
                    cancelButtonText: `Batal.`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = targetUrl;
                    }
                })

                return false;
            })
        });
    </script>
@endpush
