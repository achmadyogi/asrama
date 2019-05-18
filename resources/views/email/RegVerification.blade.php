
<div class="container">
    <style>
    .verificationEmail{
        border: 1px solid rgba(175,175,175,1.00);
		background-color: rgba(224,224,224,1.00);
		padding: 15px;
    }
    .button{
        padding: 5px;
        border-radius: 4px;
        background-color: #0769B0;
        color: white;
    }
    </style>
    <img src="https://asrama.itb.ac.id/pembinaan/images/logoasrama3.png" width="50px" alt="logo"><h2><b>UPT ASRAMA ITB</b></h2>
    <br>
    Dear, {{$nama}}
    <br>
    <div class="verificationEmail">
        <p>Selamat! Anda telah dinyatakan diterima di UPT Asrama ITB. Berikut ini adalah rincian pendaftaran
            yang sudah dilakukan. Untuk mendapatkan informasi selengkapnya, silahkan periksa akun asrama Anda.<br>
            <span style="display: inline-block; width: 150px;">ID Pendaftaran</span>: {{$id}}<br>
            <span style="display: inline-block; width: 150px;">Nama Pendaftar</span>: {{$nama}}<br>
            {{-- <span style="display: inline-block; width: 150px;">Kamar</span>: {{$kamar}}<br>
            <span style="display: inline-block; width: 150px;">Gedung</span>: {{$gedung}}<br> --}}
            <span style="display: inline-block; width: 150px;">Asrama</span>: {{$asrama}}<br>
            <span style="display: inline-block; width: 150px;">Tanggal Mulai</span>: {{$masuk}}<br>
            <span style="display: inline-block; width: 150px;">Jenis Pendaftaran</span>: Pendaftaran Reguler<br>
            Untuk rincian bisa dilihat pada menu pendaftaran di web asrama.<br>
            Apabila Anda menemukan kesalahan, jangan ragu untuk menghubungi kami pada kontak dan alamat yang
            sudah disediakan pada footer.<br>

            Terima kasih
        </p>
    </div>
    <hr>
    <address>
        Jalan Ganesha 10, Bandung<br>
        Gedung Campus Center Timur Lantai 2<br>
        Kode Pos: 40132<br>
        085295489912 | 0222534119 (telepon)<br>
        Email: sekretariat@asrama.itb.ac.id<br>
    </address>
    <hr>
    <p style="font-size: 10px"><i>Pesan ini dikirim secara otomatis oleh sistem. Apabila hendak membalas<br>
    pesan ini, silahkan balas pada email yang tertera pada footer.</i></p>
</div>
