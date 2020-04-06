<h2 style="text-align:center">
    <u>
        BERITA ACARA
    </u>
</h2>
<p style="text-align:center">
    <u>
        PENYERAHAN BBM EX.MOBIL TANGKI
    </u>
</p>
<p style="text-align:center;" >
    <?php echo 'No.:___ / ENM_PTMN / ___ / 20__'?>
</p>

<p style="text-align: justify;
        text-justify: inter-word;;" 
>
Pada hari ini, __________, Tanggal _____________ Bulan _____________ Tahun 20 ____, Pukul _________ WITA
telah dilksanakan serah terimah Produk BBM Solar Industri Dari Agen Resmi <u> <?php echo strtoupper( $vendor->name )?></u> kepada Perusahaan <u> <?php echo strtoupper( $company->name )?></u>      
No. Delivery Order Agent <u> <?php echo strtoupper( $delivery_order->code )?></u> dengan Visual Check Sebagai Berikut: 
</p>
<table>
    <tr>
        <td style="width:30%">Nama Transportir</td>
        <td style="width:5%">:</td>
        <td style="width:65% ;border-bottom:0.5px solid black">
        <?php echo strtoupper( $delivery_order->driver_name )?>
        </td>
    </tr>
</table>
<br><br>
<table>
    <tr>
        <td style="width:30%">No. Pol. Mobil Tangki</td>
        <td style="width:5%">:</td>
        <td style="width:65% ;border-bottom:0.5px solid black">
        <?php echo strtoupper( $delivery_order->plat_number )?>
        </td>
    </tr>
</table>
<br><br>
<table>
    <tr>
        <td style="width:30%">Kapasitas Mobil Tangki</td>
        <td style="width:5%">:</td>
        <td style="width:65% ;border-bottom:0.5px solid black">
        <?php echo number_format( $car->capacity )?> Ltr
        </td>
    </tr>
</table>
<br><br>
<table>
    <tr>
        <td style="width:30%">Qty. BBM</td>
        <td style="width:5%">:</td>
        <td style="width:15% ;border-bottom:0.5px solid black"></td>
        <td style="width:5% ;">Ltr, </td>
        <td style="width:2% ;border:0.5px solid black"></td>
        <td style="width:30% ;"> Cukup(masuk toleransi losis)</td>
        <td style="width:2% ;border:0.5px solid black"></td>
        <td style="width:30% ;"> Tidak Cukup</td>
    </tr>
</table>
<br><br>
<table>
    <tr>
        <td style="width:30%">SG / Temp</td>
        <td style="width:5%">:</td>
        <td style="width:15% ;border-bottom:0.5px solid black"></td>
        <td style="width:5% ;">/ </td>
        <td style="width:15% ;border-bottom:0.5px solid black"></td>
        <td style="width:5% ;">`C </td>
    </tr>
</table>
<br><br>
<table>
    <tr>
        <td style="width:30%">Kondisi Tangki</td>
        <td style="width:5%">:</td>
        <td style="width:2% ;border:0.5px solid black"></td>
        <td style="width:60% ;"> Penutup Atas dan atau Bawah Tersegel</td>
    </tr>
</table>
<br><br>
<table>
    <tr>
        <td style="width:30%"></td>
        <td style="width:5%">:</td>
        <td style="width:2% ;border:0.5px solid black"></td>
        <td style="width:60% ;"> Penutup Atas dan atau Bawah Tidak Tersegel</td>
    </tr>
</table>
<br><br>
<table>
    <tr>
        <td style="width:30%">Kualitas Minyak</td>
        <td style="width:5%">:</td>
        <td style="width:2% ;border:0.5px solid black"></td>
        <td style="width:30% ;"> Baik</td>
        <td style="width:2% ;border:0.5px solid black"></td>
        <td style="width:30% ;"> Tidak Baik</td>
    </tr>
</table>
<br><br>
<table>
    <tr>
        <td style="width:30%">Keterangan</td>
        <td style="width:5%">:</td>
        <td style="width:2% ;border:0.5px solid black"></td>
        <td style="width:30% ;"> Terkontaminasi</td>
        <td style="width:2% ;border:0.5px solid black"></td>
        <td style="width:30% ;"> Tidak Terkontaminasi</td>
    </tr>
</table>
<br><br>
<table>
    <tr>
        <td style="width:30%"></td>
        <td style="width:5%">:</td>
        <td style="width:2% ;border:0.5px solid black"></td>
        <td style="width:60% ;"> Tercampur Air atau Minyak lain dan Tidak Layak Konsumsi</td>
    </tr>
</table>
<br><br>
<p style="text-align: justify;
        text-justify: inter-word;;" 
>
Setelah Ke Dua belah Pihak melakukan visual check BBM tersebut diatas, maka dinyatakan bahwa barang
tersebut : 
</p>
<table>
    <tr>
        <td style="width:2% ;border:0.5px solid black"></td>
        <td style="width:30%"> Diterima Tanpa Keberatan</td>
    </tr>
</table>
<br><br>
<table>
    <tr>
        <td style="width:2% ;border:0.5px solid black"></td>
        <td style="width:30%"> Diterima Dengan Catatan</td>
        <td style="width:5%">:</td>
        <td style="width:63% ;border:0.5px solid black"></td>
    </tr>
</table>
<br><br>
<table>
    <tr>
        <td style="width:2% ;border:0.5px solid black"></td>
        <td style="width:90%"> Tidak Diterima (ditolak) & diganti dengan yang baru</td>
    </tr>
</table>
<br><br>
<p style="text-align: justify;
        text-justify: inter-word;;" 
>
Demikian Berita Acara penyerahan BBM Industri ini di buat, untuk dipergunakan sebagaimana mestinya.
</p>
<center>
<table>
    <tr>
        <td style="width:33% ;text-align: center">
                Yang menyerahkan,<br>
                <?php echo strtoupper( $vendor->name )?>
        </td>
        <td style="width:33%"> </td>
        <td style="width:33%">
                Yang Menerima,<br>
                PT. 
        </td>
    </tr>
</table>
</center>
<br><br><br><br><br><br>
<center>
<table>
    <tr>
        <td style="width:33% ">
        (_____________________________)
        </td>
        <td style="width:33%"> </td>
        <td style="width:33%">
        (_____________________________)
        </td>
    </tr>
</table>
</center>
<center>
<table>
    <tr>
        <td style="width:33% ; text-align: center">
                Driver
        </td>
        <td style="width:33%"> </td>
        <td style="width:33% ; text-align: center">
                Pws. Penerima BBM Industri
        </td>
    </tr>
</table>
</center>
<!--  -->
<!--  -->
<center>
<table>
    <tr>
        <td style="width:33%;"> </td>
        <td style="width:33% ;text-align: center">
                Mengetahui,<br>
                <?php echo strtoupper( $vendor->name )?>
        </td>
        <td style="width:33%;"> </td>
    </tr>
</table>
</center>
<br><br><br><br><br><br>
<center>
<table>
    <tr>
        <td style="width:33%;"> </td>
        <td style="width:33% ;">
        (_____________________________)
        </td>
        <td style="width:33%;"> </td>
    </tr>
</table>
</center>

