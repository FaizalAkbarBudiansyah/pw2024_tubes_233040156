// ambil elemen2 yang dibutuhkan
var keyword = document.getElementById('keyword');
var tombolCari = document.getElementById('tombol-cari');
var container = document.getElementById('container');

// tambahkan event ketika keyword ditulis
keyword.addEventListener('keyup', function() {

    // buat object ajax
    var xhr = new HMLHttpRequest();

    // cek kesiapan ajax
    xhr.onreadystatechange = function(){
        if( xhr.readyState == 4 && xhr.status == 200) {
            console.log('ajax ok!');
        }
    }

    // eksekusi ajax
    xhr.open('GET', 'ajax/coba.txt', true);
    xhr.send();
});