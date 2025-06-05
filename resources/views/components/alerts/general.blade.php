@if (session('error') || isset($success) || $errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let message = @json(session('error') ?? $success ?? $errors->first());
            let type = @json(session('error') || $errors->any() ? 'error' : 'success');

            Swal.fire({
                icon: type,
                title: type === 'error' ? 'Error!' : 'Success!',
                text: message,
                confirmButtonText: "OK",
                timer: 3000,
                showClass: {
                    popup: "animate__animated animate__bounceIn"
                }
            }).then(() => {
                @if (isset($redirectTo))
                    window.location.href = @json($redirectTo);
                @endif
            });
        });
    </script>
@endif