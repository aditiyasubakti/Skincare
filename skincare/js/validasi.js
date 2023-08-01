function validateForm() {
    var name = document.getElementById('nama');
    var price = document.getElementById('harga');
    var image = document.getElementById('gambar');
    var description = document.getElementById('deskripsi');
    if (name == "") {
        alert("Nama barang harus diisi");
        return false;
    }

    if (price == "") {
        alert("Harga barang harus diisi");
        return false;
    }

    if (image == "") {
        alert("Gambar barang harus diunggah");
        return false;
    }

    if (description == "") {
        alert("Deskripsi barang harus diisi");
        return false;
    }
}