@if (session('error') || $errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let message = @json(session('error') ?? $errors->first());
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: message,
                confirmButtonText: "OK",
                timer: 3000
            });
        });
    </script>
@endif
