document.addEventListener('DOMContentLoaded', function () {
    const profileForm = document.getElementById('profile-form');
    const editBtn = document.getElementById('edit-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const saveBtn = document.getElementById('save-btn');
    const inputs = document.querySelectorAll('.profile-input');

    if (editBtn) {
        editBtn.addEventListener('click', function () {
            // 1. Aktifkan input
            inputs.forEach(input => {
                input.disabled = false;
                input.style.backgroundColor = "#ffffff";
                input.style.borderColor = "#008774"; 
            });

            // 2. Sembunyikan Edit, Munculkan Simpan & Batal
            editBtn.style.display = "none";
            saveBtn.style.display = "block";
            cancelBtn.style.display = "block";
        });
    }

    profileForm.addEventListener('submit', function() {
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sedang diperbarui...';
    });

    if (cancelBtn) {
        cancelBtn.addEventListener('click', function () {
            // Reload buat balikin data asli
            window.location.reload();
        });
    }
});

