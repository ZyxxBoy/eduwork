// Array produk
const products = [
    {
        nama: "Laptop Gaming",
        harga: "Rp 12.000.000",
        deskripsi: "Laptop performa tinggi untuk gaming.",
        kategori: "Elektronik",
        gambar: "https://images.unsplash.com/photo-1517336714739-489689fd1ca8"
    },
    {
        nama: "Kaos Oversize",
        harga: "Rp 120.000",
        deskripsi: "Kaos fashion kekinian.",
        kategori: "Fashion",
        gambar: "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab"
    },
    {
        nama: "Burger Special",
        harga: "Rp 35.000",
        deskripsi: "Burger lezat dengan daging premium.",
        kategori: "Makanan",
        gambar: "https://images.unsplash.com/photo-1568901346375-23c9450c58cd"
    },
    {
        nama: "Smartphone",
        harga: "Rp 5.000.000",
        deskripsi: "HP dengan kamera jernih.",
        kategori: "Elektronik",
        gambar: "https://images.unsplash.com/photo-1511707171634-5f897ff02aa9"
    },
    {
        nama: "Smartwatch",
        harga: "Rp 2.500.000",
        deskripsi: "Jam tangan pintar dengan fitur kesehatan.",
        kategori: "Elektronik",
        gambar: "https://images.unsplash.com/photo-1523275335684-37898b6baf30"
    },
    {
        nama: "Headphone Bluetooth",
        harga: "Rp 850.000",
        deskripsi: "Headphone dengan noise cancellation.",
        kategori: "Elektronik",
        gambar: "https://images.unsplash.com/photo-1505740420928-5e560c06d30e"
    },
    {
        nama: "Mouse Wireless",
        harga: "Rp 250.000",
        deskripsi: "Mouse ergonomis tanpa kabel.",
        kategori: "Elektronik",
        gambar: "https://images.unsplash.com/photo-1527864550417-7fd91fc51a46"
    },
    {
        nama: "Keyboard Mekanikal",
        harga: "Rp 750.000",
        deskripsi: "Keyboard dengan switch responsif.",
        kategori: "Elektronik",
        gambar: "https://images.unsplash.com/photo-1595225476474-87563907a212"
    },
    {
        nama: "Monitor 4K",
        harga: "Rp 4.500.000",
        deskripsi: "Monitor dengan resolusi tinggi.",
        kategori: "Elektronik",
        gambar: "https://images.unsplash.com/photo-1527443224154-c4a3942d3acf"
    },
    {
        nama: "Tablet Pro",
        harga: "Rp 8.000.000",
        deskripsi: "Tablet untuk produktivitas dan hiburan.",
        kategori: "Elektronik",
        gambar: "https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0"
    },
    {
        nama: "Kamera Mirrorless",
        harga: "Rp 15.000.000",
        deskripsi: "Kamera profesional yang ringan.",
        kategori: "Elektronik",
        gambar: "https://images.unsplash.com/photo-1516035069371-29a1b244cc32"
    },
    {
        nama: "Sepatu Sneakers",
        harga: "Rp 600.000",
        deskripsi: "Sepatu kasual yang nyaman dipakai.",
        kategori: "Fashion",
        gambar: "https://images.unsplash.com/photo-1542291026-7eec264c27ff"
    },
    {
        nama: "Jaket Denim",
        harga: "Rp 350.000",
        deskripsi: "Jaket jeans dengan gaya klasik.",
        kategori: "Fashion",
        gambar: "https://images.unsplash.com/photo-1576995853123-5a10305d93c0"
    },
    {
        nama: "Kemeja Pria",
        harga: "Rp 200.000",
        deskripsi: "Kemeja formal untuk acara resmi.",
        kategori: "Fashion",
        gambar: "https://images.unsplash.com/photo-1596755094514-f87e32f85e2c"
    },
    {
        nama: "Gaun Wanita",
        harga: "Rp 450.000",
        deskripsi: "Gaun elegan untuk pesta.",
        kategori: "Fashion",
        gambar: "https://images.unsplash.com/photo-1566150905458-1bf1fc113f0d"
    },
    {
        nama: "Topi Baseball",
        harga: "Rp 100.000",
        deskripsi: "Topi santai untuk sehari-hari.",
        kategori: "Fashion",
        gambar: "https://images.unsplash.com/photo-1588850561407-ed78c282e89b"
    },
    {
        nama: "Celana Jeans",
        harga: "Rp 250.000",
        deskripsi: "Celana jeans pria slim fit.",
        kategori: "Fashion",
        gambar: "https://images.unsplash.com/photo-1542272604-787c3835535d"
    },
    {
        nama: "Kacamata Hitam",
        harga: "Rp 150.000",
        deskripsi: "Kacamata untuk melindungi dari sinar matahari.",
        kategori: "Fashion",
        gambar: "https://images.unsplash.com/photo-1511499767150-a48a237f0083"
    },
    {
        nama: "Pizza Margherita",
        harga: "Rp 85.000",
        deskripsi: "Pizza dengan keju mozzarella leleh.",
        kategori: "Makanan",
        gambar: "https://images.unsplash.com/photo-1513104890138-7c749659a591"
    },
    {
        nama: "Sushi Set",
        harga: "Rp 120.000",
        deskripsi: "Paket sushi dengan ikan segar.",
        kategori: "Makanan",
        gambar: "https://images.unsplash.com/photo-1579871494447-9811cf80d66c"
    },
    {
        nama: "Kopi Latte",
        harga: "Rp 25.000",
        deskripsi: "Kopi dengan susu yang creamy.",
        kategori: "Makanan",
        gambar: "https://images.unsplash.com/photo-1511920170033-f8396924c348"
    },
    {
        nama: "Es Krim Coklat",
        harga: "Rp 20.000",
        deskripsi: "Es krim manis untuk cuaca panas.",
        kategori: "Makanan",
        gambar: "https://images.unsplash.com/photo-1563805042-7684c8e9e1cb"
    },
    {
        nama: "Kentang Goreng",
        harga: "Rp 15.000",
        deskripsi: "Camilan renyah yang gurih.",
        kategori: "Makanan",
        gambar: "https://images.unsplash.com/photo-1576107232684-1279f3908594"
    },
    {
        nama: "Donat Cokelat",
        harga: "Rp 10.000",
        deskripsi: "Donat lembut dengan topping cokelat.",
        kategori: "Makanan",
        gambar: "https://images.unsplash.com/photo-1551024601-bec78aea704b"
    }
];

// Menampilkan produk
function tampilkanProduk(dataProduk) {
    const productList = document.getElementById("product-list");

    productList.innerHTML = "";

    dataProduk.forEach(produk => {
        productList.innerHTML += `
      <div class="product-card">
        <img src="${produk.gambar}" alt="${produk.nama}">
        
        <div class="product-info">
          <span class="category">${produk.kategori}</span>

          <h2>${produk.nama}</h2>

          <p>${produk.deskripsi}</p>

          <p class="price">${produk.harga}</p>
        </div>
      </div>
    `;
    });
}

// Filter kategori
function filterProduk(kategori) {

    if (kategori === "Semua") {
        tampilkanProduk(products);
    } else {

        const hasilFilter = products.filter(produk =>
            produk.kategori === kategori
        );

        tampilkanProduk(hasilFilter);
    }
}

// Tampilkan semua produk pertama kali
tampilkanProduk(products);