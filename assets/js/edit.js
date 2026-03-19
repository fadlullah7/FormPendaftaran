document.addEventListener('DOMContentLoaded', function() {

    const form = document.getElementById('formEdit');
    const inputFoto = document.getElementById('inputFotoEdit');
    const previewBaru = document.getElementById('previewBaru');
    const previewLama = document.getElementById('previewLama');

    // Preview Foto
    if (inputFoto) {
        inputFoto.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                previewBaru.src = URL.createObjectURL(file);
                previewBaru.style.display = 'block';
                if (previewLama) previewLama.style.opacity = '0.3';
            }
        });
    }

    // Validasi saat Submit
    if (form) {
        form.addEventListener('submit', function(e) {
            const nama = document.querySelector('input[name="nama"]').value;
            const notelp = document.querySelector('input[name="notelp"]').value;

            if (nama.trim().length < 3) {
                e.preventDefault(); // Stop form
                Swal.fire('Oops!', 'Nama minimal 3 karakter!', 'error');
                return;
            }

            if (notelp !== "" && isNaN(notelp)) {
                e.preventDefault(); // Stop form
                Swal.fire('Error', 'Nomor telepon harus angka!', 'error');
                return;
            }
            
            console.log("Validasi Berhasil!");
        });
    }
});