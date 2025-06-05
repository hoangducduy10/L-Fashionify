@if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: @json(session('success')),
                showConfirmButton: false,
                timer: 5000
            });
        });
    </script>
@endif
