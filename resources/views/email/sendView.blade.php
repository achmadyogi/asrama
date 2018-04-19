
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
    <img src="https://asrama.itb.ac.id/pembinaan/images/logoasrama3.png" width="200px" alt="logo">
    <br><br>
    Dear, {{$name}}
    <br><br>
    <div class="verificationEmail">
        <p>Terimakasih telah bergabung dengan UPT Asrama ITB. Untuk melakukan verifikasi email,<br> Silahkan klik tombol dibawah ini.<br><br>
            <button type="button" class="button"><a href="{{ route('sendEmailDone',['email'=>$user->email, 'token_verification'=>$user->token_verification]) }}">disini</a></button>
        </p>
    </div>
    <hr>
    <address>
        Jalan Ganesha 10, Bandung<br>
        Gedung Campus Center Timur Lantai 2<br>
        Kode Pos: 40132<br>
        089615098438 | 089660552121 (telepon)<br>
        Email: sekretariat.asramaitb@gmail.com<br>
    </address>
    <hr>
    <p style="font-size: 10px"><i>Pesan ini dikirim secara otomatis oleh sistem. Apabila hendak membalas<br>
    pesan ini, silahkan balas pada email yang tertera pada footer.</i></p>
</div>
