// Auto-hide success alert បន្ទាប់ពី 4 វិនាទី
document.addEventListener("DOMContentLoaded", function() {
    const alert = document.getElementById('success-alert');
    if(alert) {
        setTimeout(() => {
            alert.classList.add('hide'); // fade out
            setTimeout(() => alert.remove(), 1000); // remove from DOM
        }, 1000);
    }
});

// Delete confirmation using SweetAlert2
document.querySelectorAll('.btn-delete').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        let link = this.href;
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
            }
        });
    });
});