document.addEventListener('DOMContentLoaded', function() {
    
   
    const inputFoto = document.getElementById('inputFoto');
    const preview = document.getElementById('preview');
    if (inputFoto && preview) {
        inputFoto.onchange = evt => {
            const [file] = inputFoto.files;
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        }
    }

   
    const form = document.getElementById('formPendaftaran');
    if (form) {
        form.addEventListener('submit', function(e) {
            const nama = document.querySelector('input[name="nama"]').value;
            const notelp = document.querySelector('input[name="notelp"]').value;
            const jk = document.querySelector('input[name="jk"]:checked');

            if (nama.trim().length < 3) {
                e.preventDefault();
                Swal.fire('Oops!', 'Nama minimal 3 karakter', 'error');
                return;
            }

            if (!jk) {
                e.preventDefault();
                Swal.fire('Peringatan', 'Silakan pilih Jenis Kelamin', 'warning');
                return;
            }

            if (notelp !== "" && !/^\d+$/.test(notelp)) {
                e.preventDefault();
                Swal.fire('Error', 'Nomor telepon harus berupa angka!', 'error');
                return;
            }
        });
    }

    const searchInput = document.getElementById('cariSiswa');
    if (searchInput) {
        
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
            }
        });

        searchInput.addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('table tbody tr');

            rows.forEach(row => {
                if (row.cells.length > 0) {
                    let nama = row.cells[0].textContent.toLowerCase();
                    row.style.display = nama.includes(filter) ? '' : 'none';
                }
            });
        });
    }
});


function hapusData(url) {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    })
}