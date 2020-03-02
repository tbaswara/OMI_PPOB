<!DOCTYPE HTML>
<html>
    <style type="text/css" media="print">
        body
        {
            font-family: monospace;
            font-size: 1em;
        }
        
        .no-print
        {
            display: none;
        }
    </style>
    
    <style type="text/css" media="screen">
        body
        {
            font-family: monospace;
            font-size: 1em;
        }
        
        .struk-footer
        {
            padding: 10px;
            width: 90%;
            position: fixed;
            bottom: 0;
            height: 35px;
            background-color: #666666;
            text-align: right;
        }
        
        .struk-footer a
        {
            text-decoration: none;
            color: #FFFFFF
        }
    </style>
    <body>
        <h3>BUKTI PEMBAYARAN TAGIHAN TELCO</h3>
        <table>
            <tbody>
                <tr>
                    <td>Tanggal Bayar</td>
                    <td>:</td>
                    <td>{{$tanggalBayar}}</td>
                </tr>
                <tr>
                    <td>Nama Pelanggan</td>
                    <td>:</td>
                    <td>{{$namaPelanggan}}</td>
                </tr>
                <tr>
                    <td>Nomor Telepon</td>
                    <td>:</td>
                    <td>{{$nomorTelepon}}</td>
                </tr>
                @foreach($dataTagihan as $tagihan)
                <tr>
                    <td>Tagihan Bulan {{$tagihan['billMonth']}}</td>
                    <td>:</td>
                    <td>Rp. {{$tagihan['billAmount']}}</td>
                </tr>
                @endforeach
                <tr>
                    <td>Biaya Admin</td>
                    <td>:</td>
                    <td>Rp. {{$adminFee}}</td>
                </tr>
                <tr>
                    <td>Total Tagihan</td>
                    <td>:</td>
                    <td>Rp. {{$totalTagihan}}</td>
                </tr>
            </tbody>
        </table>
        <br />
        <p>
        HARAP TANDA TERIMA INI DISIMPAN <br />
        SEBAGAI BUKTI PEMBAYARAN YANG SAH
        </p>
        
        <div class="struk-footer no-print">
            <a href="#" onclick="window.print();">
                <button type="button">Print</button>
            </a>
        </div>
    </body>
</html>