<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".confirm-btn").forEach(button => {
            button.addEventListener("click", function() {
                let form = this.closest(".confirm-form");
                let actionType = this.dataset.action || "this action"; 
                let confirmText = this.dataset.confirmText || "Yes, proceed!"; 
                let cancelText = this.dataset.cancelText || "Cancel"; 

                Swal.fire({
                    title: "Are you sure?",
                    text: `Do you really want to ${actionType}? This action cannot be undone.`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: confirmText,
                    cancelButtonText: cancelText
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
