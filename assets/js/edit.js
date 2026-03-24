document.addEventListener('DOMContentLoaded', function() {
    
    // --- 1. FITUR PRATINJAU FOTO ---
    const inputFoto = document.getElementById('inputFotoEdit');
    const previewBaru = document.getElementById('previewBaru');
    const previewLama = document.getElementById('previewLama');

    if (inputFoto && previewBaru) {
        inputFoto.onchange = evt => {
            const [file] = inputFoto.files;
            if (file) {
                previewBaru.src = URL.createObjectURL(file);
                previewBaru.style.display = 'block';
                if (previewLama) previewLama.style.opacity = '0.3';
            }
        }
    }

    // --- 2. FITUR VALIDASI FORM ---
    const form = document.getElementById('formEdit');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const nama = document.querySelector('input[name="nama"]').value;
            const notelp = document.querySelector('input[name="notelp"]').value;

            if (nama.trim().length < 3) {
                e.preventDefault(); 
                Swal.fire('Oops!', 'Nama minimal 3 karakter!', 'error');
                return;
            }
            
            if (notelp !== "" && !/^\d+$/.test(notelp)) {
                e.preventDefault(); 
                Swal.fire('Error', 'Nomor telepon harus berupa angka!', 'error');
                return;
            }
            
            console.log("Validasi Berhasil!");
        });
    }
});