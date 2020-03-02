@extends('layout')

@section('content')
<div class="row">
    <div class="large-12 columns">
        <dl class="tabs" data-tab>
            <dd class="active"><a href="#post-paid">Post-Paid</a></dd>
            <dd><a href="#prepaid">Pre-Paid</a></dd>
            <dd><a href="#deposit">Deposit</a></dd>
            <dd><a href="#laporan-bulanan">Laporan (Bulanan)</a></dd>
            <dd><a href="#laporan-harian">Laporan (Harian)</a></dd>
        </dl>
    </div>
</div>
<div class="body">
    
    <!-- View cek tagihan -->
    <div class="tabs-content">
        <div class="content active" id="post-paid">
            <div class="row">
                <div class="large-12 columns">
                    <h4>Transaksi Post-Paid</h4>
                </div>
                <div class="large-6 columns">
                    <label>
                        <select id="product" name="product" class="">
                            <option value="0" selected>-- Pilih Produk --</option>
                        </select>
                    </label>
                    <label>
                        <select id="sub-product" name="sub_product" class="">
                            <option value="0" selected>-- Pilih Sub Produk --</option>
                        </select>
                    </label>
                    <label>
                        <input id="id-pelanggan-postpaid" name="id_pelanggan_postpaid" 
                               type="text" placeholder="ID Pelanggan / No. Meter" value="" />
                        
                        <form id="form-collective-postpaid" enctype="multipart/form-data">
                            <input id="file-collective-postpaid" name="file_collective_postpaid" 
                                   type="file" style="display: none"/>
                        </form>
                    </label>    
                </div>
                <div class="large-6 columns">
                    <label>
                        <input id="collective-payment" type="checkbox" value="" /> Pembayaran Kolektif
                    </label>
                </div>
            </div>
            
            <div class="row">
                <div class="large-12 columns pull-right">
                    <button id="btn-cek-tagihan" type="button" class="button tiny radius">Cek Tagihan</button>
                    <button id="btn-test-print" class="button tiny radius success">Test Print</button>
                </div>
            </div>

            <div class="row">
                <div class="large-12 columns">
                    <table id="table-tagihan">
                        <thead>
                            <tr>
                                <th width="5%"><input type="checkbox" value="" id="check-all-tagihan"/></th>
                                <th width="15%">Jenis</th>
                                <th width="15%">ID Pelanggan</th>
                                <th width="15%">Atas Nama</th>
                                <th width="5%">Lbr</th>
                                <th width="5%">Bln</th>
                                <th width="10%">Tagihan</th>
                                <th width="10%">Admin</th>
                                <th width="10%">Total</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

                <div class="large-12 columns pull-right">
                    <button id="btn-confirm-payment" class="button tiny radius">Bayar Semua</button>
                </div>
            </div>
        </div>
        <!-- End of view cek tagihan -->

        <!-- View prepaid -->
        <div class="content" id="prepaid">
            <div class="row">
                <div class="large-12 columns">
                    <h4>Transaksi Pre-Paid</h4>
                </div>
                <div class="large-6 columns">
                    <label>
                        <select id="prepaid-product" name="prepaid_product" class="">
                            <option value="0" selected>-- Pilih Produk --</option>
                        </select>
                    </label>
                    <label>
                        <select id="prepaid-sub-product" name="prepaid_sub_product" class="">
                            <option value="0" selected>-- Pilih Sub Produk --</option>
                        </select>
                    </label>
                    <label>
                        <input id="prepaid-nomor-pelanggan" name="prepaid_nomor_pelanggan" 
                               type="text" placeholder="ID Pelanggan / No. Meter / No. HP" value="" />
                    </label>    
                </div>
                <div class="large-6 columns"></div>
            </div>
            <div class="row">
                <div class="large-12 columns pull-right">
                    <button id="btn-beli-prepaid" class="button tiny radius">Beli</button>
                </div>
            </div>

            <div class="row">
                <div class="large-12 columns">  
                    <table id="table-purchase">
                        <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th>Jenis</th>
                                <th>No. Pelanggan</th>
                                <th width="25%">Serial Number</th>
                                <th>Nominal</th>
                                <th>Admin</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End of view prepaid -->

        <!-- View deposit -->
        <div class="content" id="deposit">
            <div class="row">
                <div class="large-12 columns">
                    <h4>Riwayat Deposit</h4>
                </div>
                <div class="large-6 columns">
                    <label>
                        <select name="bulan_deposit">
                            <option value="0">-- Pilih Bulan --</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </label>
                    <label>
                        <select name="tahun_deposit">
                            <option value="0">-- Pilih Tahun --</option>
                            <option value="2014">2014</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2016">2017</option>
                            <option value="2016">2018</option>
                            <option value="2016">2019</option>
                            <option value="2016">2020</option>
                        </select>
                    </label>
                </div>
                <div class="large-12 columns pull-right">
                    <button id="btn-check-deposit" class="button radius tiny">
                        Tampilkan
                    </button>
                </div>
                <div class="large-12 columns">
                    <table id="table-deposit">
                        <thead>
                            <tr>
                                <th width="10%">No.</th>
                                <th>Tanggal</th>
                                <th>Saldo Awal</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                                <th>Saldo Akhir</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End of view deposit -->
        
        <!-- View laporan bulanan-->
        <div class="content" id="laporan-bulanan">
            <div class="row">
                <div class="large-12 columns">
                    <h4>Laporan Bulanan</h4>
                </div>
                <div class="large-6 columns">
                    <label>
                        <select name="bulan_laporan">
                            <option value="0">-- Pilih Bulan --</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </label>
                    <label>
                        <select name="tahun_laporan">
                            <option value="0">-- Pilih Tahun --</option>
                            <option value="2014">2014</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2016">2017</option>
                            <option value="2016">2018</option>
                            <option value="2016">2019</option>
                            <option value="2016">2020</option>
                        </select>
                    </label>
                </div>
                
                <div class="large-12 columns pull-right">
                    <button id="btn-laporan-bulanan" type="button" class="button tiny radius">Tampilkan</button>
                    <button class="button tiny radius success">Print</button>
                </div>
                
                <div class="large-12 columns">
                    <table id="table-laporan-bulanan">
                        <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th>Tanggal</th>
                                <th>Jml. Bulan</th>
                                <th>Jml. Bulan</th>
                                <th>Tagihan</th>
                                <th>Admin</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End of view laporan bulanan-->
        
        <!-- View laporan harian-->
        <div class="content" id="laporan-harian">
            <div class="row">
                <div class="large-12 columns">
                    <h4>Laporan Harian</h4>
                </div>
                
                <div class="large-6 columns">
                    <input type="text" id="date-laporan" 
                           name="date_laporan" placeholder="Tanggal Laporan" />
                </div>
                
                <div class="large-12 columns pull-right">
                    <button id="btn-laporan-harian" type="button" class="button tiny radius">Tampilkan</button>
                    <button class="button tiny radius success">Print</button>
                </div>
                
                <div class="large-12 columns">
                    <table id="table-laporan-harian">
                        <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th width="20%">Jenis</th>
                                <th width="15%">ID Pelanggan</th>
                                <th width="20%">Atas Nama</th>
                                <th width="5%">Lbr</th>
                                <th width="5%">Bln</th>
                                <th width="10%">Tagihan</th>
                                <th width="10%">Admin</th>
                                <th width="10%">Total</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End of view laporan harian-->
        
    </div>
</div>

<div id="payment-modal" class="modal small reveal-modal" data-reveal >
    <div class="modal-header">
        <h4>Total Tagihan: Rp. <span id="total-pembayaran"></span></h4>
        <a class="close-reveal-modal">&#215;</a>
    </div>
    <div class="modal-body">
        <label>
            <input type="text" name="jumlah_bayar" placeholder="Nominal Bayar" />
        </label>
    </div>
    <div class="modal-footer">
        <button id="btn-do-confirm" class="button small radius">Konfirm</button>
    </div>
</div>

<div id="confirm-payment-modal" class="modal small reveal-modal" data-reveal >
    <div class="modal-header">
        <h4>Konfirmasi</h4>
        <a class="close-reveal-modal">&#215;</a>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="large-5 columns">
                <strong>Total Tagihan:</strong>
            </div>
            <div class="large-7 columns">
                <p>Rp. <span id="confirm-nominal-tagihan"></span></p>
            </div>
        </div>
        <div class="row">
            <div class="large-5 columns">
                <strong>Dibayarkan:</strong>
            </div>
            <div class="large-7 columns">
                <p>Rp. <span id="confirm-nominal-dibayar"></span></p>
            </div>
        </div>
        <div class="row">
            <div class="large-5 columns">
                <strong>Kembalian:</strong>
            </div>
            <div class="large-7 columns">
                <p>Rp. <span id="confirm-nominal-kembalian"></span></p>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button id="btn-do-payment" class="button small radius">Konfirm</button>
    </div>
</div>

<div id="confirm-prepaid-modal" class="modal small reveal-modal" data-reveal >
    <div class="modal-header">
        <h4>Konfirmasi Prepaid</h4>
        <a class="close-reveal-modal">&#215;</a>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="large-5 columns">
                <strong>Jenis:</strong>
            </div>
            <div class="large-7 columns">
                <p id="confirm-jenis-prepaid"></p>
            </div>
        </div>
        <div class="row">
            <div class="large-5 columns">
                <strong>Nominal:</strong>
            </div>
            <div class="large-7 columns">
                <p id="confirm-nominal-prepaid"></p>
            </div>
        </div>
        <div class="row">
            <div class="large-5 columns">
                <strong>No. HP / No. Meter:</strong>
            </div>
            <div class="large-7 columns">
                <p id="confirm-nomor-prepaid"></p>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button id="btn-confirm-prepaid" class="button small radius">Konfirm</button>
    </div>
</div>
@stop

@section('script')
<script type='text/javascript'>
    $(document).ready(function()
    {
        //inquiry response data
        //need to be stored becoause we will use it again
        //when doing posting payment.
        var inquiryResponseData = {};

        //load all product data
        $('#ajax-loader').show();
        var postPaidProductDict = loadProductData("product/ajaxGetAllPostPaidProducts", $('#product'));
        var prePaidProductDict = loadProductData("product/ajaxGetAllPrePaidProducts", $('#prepaid-product'));
        $('#ajax-loader').hide();

        $('#product').change(function()
        {
            var productCode = $(this).val();
            var subProducts = postPaidProductDict[productCode];

            if (typeof subProducts !== 'undefined')
            {
                $('#sub-product').empty();
                $.each(subProducts, function(i, data)
                {
                    $('#sub-product').append(
                            $('<option></option>')
                            .val(data.product_code)
                            .html(data.product_name));
                });
            }
            else
            {
                $('#sub-product').empty();
            }
        });
        
        $('#prepaid-product').change(function()
        {
            var productCode = $(this).val();
            var subProducts = prePaidProductDict[productCode];

            if (typeof subProducts !== 'undefined')
            {
                $('#prepaid-sub-product').empty();
                $.each(subProducts, function(i, data)
                {
                    $('#prepaid-sub-product').append(
                            $('<option></option>')
                            .val(data.product_code)
                            .attr('data-nominal', data.nominal)
                            .html(data.product_name));
                });
            }
            else
            {
                $('#prepaid-sub-product').empty();
            }
        });

        $('#btn-cek-tagihan').click(function()
        {   
            var productCode = $('#product option:selected').val();
            var subProductCode = $('#sub-product option:selected').val();
            var idPelanggan = $('#id-pelanggan-postpaid').val();
            var url = 'transaksi/ajaxDoInquiry';
            
            if($('#collective-payment').prop('checked'))
            {   
                url = 'transaksi/ajaxDoCollectiveInquiry';
            }
            
            doInquiry(productCode, subProductCode, idPelanggan, url);
        });
        
        $('#btn-test-print').click(function()
        {
            $('input[type="checkbox"].item-tagihan').each(function()
            {
                var inquiryId = $(this).val();
                var inquiryData = inquiryResponseData[inquiryId];
                
                if(this.checked)
                {
                    $.ajax({
                        url: 'transaksi/ajaxDoTestPrint',
                        data: inquiryData
                    }).done(function(data)
                    {
                        var filename = data.message;
                        window.open("struk/"+filename, "", "width=350, height=400");
                    });
                }
            });
        });
        
        $('#file-collective-postpaid').change(function()
        {
            var file = $('#file-collective-postpaid').prop('files')[0];
            var fileExtension = file.name.substr(-3);
            
            if (fileExtension === 'csv' && window.File 
                    && window.FileReader && window.FileList && window.Blob)
            {
                var reader = new FileReader();
                reader.onload = function(e)
                {
                    var text = reader.result;
                    $('#id-pelanggan-postpaid').val(text);
                };

                reader.readAsText(file, 'UTF-8');
            }
            else
            {
                $('#id-pelanggan-postpaid').val("");
            }
        });
        
        $('#btn-confirm-payment').click(function()
        {
            var totalPayment = 0;
            $('input[type="checkbox"].item-tagihan').each(function()
            {
                var target = $(this).closest('tr').children('td:eq(8)');
                var value = (this.checked ? cleanCurrencyFormat(target.text()) : 0);
                totalPayment += parseInt(value);
            });
            
            $('#total-pembayaran').text(formatToCurrency(totalPayment));
            $('#payment-modal').foundation('reveal', 'open');
        });
        
        $('#btn-do-confirm').click(function()
        {
            var totalTagihan = cleanCurrencyFormat($('#total-pembayaran').text());
            var totalDibayar = $('input[name="jumlah_bayar"]').val();
            var kembalian = totalDibayar - totalTagihan;
            
            $('#confirm-nominal-tagihan').text(formatToCurrency(totalTagihan));
            $('#confirm-nominal-dibayar').text(formatToCurrency(totalDibayar));
            $('#confirm-nominal-kembalian').text(formatToCurrency(kembalian));
            
            $('#confirm-payment-modal').foundation('reveal', 'open');
        });
        
        $('#btn-do-payment').click(function()
        {
            $('#confirm-payment-modal').foundation('reveal', 'close');
            $('input[type="checkbox"].item-tagihan').each(function()
            {
                if(this.checked)
                {
                    var transactionId = $(this).val();
                    doPayment(transactionId);
                }
            });
        });
        
        $('#btn-beli-prepaid').click(function()
        {
            var jenisPrepaid = $('#prepaid-product option:selected').text();
            var nominalPrepaid = $('#prepaid-sub-product option:selected').attr('data-nominal');
            var nomorPrepaid = $('#prepaid-nomor-pelanggan').val();
            
            $('#confirm-jenis-prepaid').html(jenisPrepaid);
            $('#confirm-nominal-prepaid').html(formatToCurrency(nominalPrepaid));
            $('#confirm-nomor-prepaid').html(nomorPrepaid);
            
            $('#confirm-prepaid-modal').foundation('reveal', 'open');
        });
        
        $('#btn-confirm-prepaid').click(function()
        {
            $('#confirm-prepaid-modal').foundation('reveal', 'close');
            $('#ajax-loader').show();
            var productCode = $('#prepaid-product option:selected').val();
            var subProductCode = $('#prepaid-sub-product option:selected').val();
            var pelangganId = $('#prepaid-nomor-pelanggan').val();
            var nominal = $('#prepaid-sub-product option:selected').attr('data-nominal');
            
            $.ajax({
                url: "transaksi/ajaxDoPurchase",
                data: {
                    biller_id: productCode,
                    product_id: subProductCode,
                    pelanggan_id: pelangganId,
                    nominal: nominal
                }
            }).done(function(data)
            {
                $('#ajax-loader').hide();
                if(data.status === 'success')
                {
                    var target = $('#table-purchase > tbody:last');
                    var info = data.message;
                    var total = (info.voucherNominal + info.adminFee);
                    var rowCount = $('#table-purchase > tbody tr').length;
                    target.append( '<tr>'
                        + '<td>'+(rowCount + 1)+'</td>'
                        + '<td>'+info.productName+'</td>'
                        + '<td>'+info.operatorCode + info.phoneNumber+'</td>'
                        + '<td>'+info.serialNumber+'</td>'
                        + '<td class="currency">'+formatToCurrency(info.voucherNominal)+'</td>'
                        + '<td class="currency">'+formatToCurrency(info.adminFee)+'</td>'
                        + '<td class="currency">'+formatToCurrency(total)+'</td>'
                        + '<td><span class="label success radius">Success</span></td>'
                        + '</tr>'
                    );
                }
                else
                {
                    $('#notif-header').text("Terjadi Kesalahan");
                    $('#notif-body').text(data.message);
                    $('#modal-notification').foundation('reveal', 'open');
                }
            });
        });
        
        $('#btn-check-deposit').click(function()
        {
            var depositMonth = $('select[name="bulan_deposit"] :selected').val();
            var depositYear = $('select[name="tahun_deposit"] :selected').val();
            
            $('#ajax-loader').show();
            $.ajax({
                url: 'deposit/ajaxGetDepositHistory',
                data: {
                    year: depositYear,
                    month: depositMonth
                }
           }).done(function(data)
            {
                var target = $('#table-deposit > tbody:last');
                target.empty();
                
                var index = 0;
                $.each(data, function(date, obj)
                {
                    target.append( '<tr>'
                        + '<td>'+(++index)+'</td>'
                        + '<td>'+date+'</td>'
                        + '<td class="currency">'+formatToCurrency(obj.opening)+'</td>'
                        + '<td class="currency">'+formatToCurrency(obj.debet)+'</td>'
                        + '<td class="currency">'+formatToCurrency(obj.credit)+'</td>'
                        + '<td class="currency">'+formatToCurrency(obj.saldo)+'</td>'
                        + '</tr>'
                    );
                });
                
                $('#ajax-loader').hide();
            });
        });
        
        $('#btn-laporan-bulanan').click(function()
        {
            var month = $('select[name="bulan_laporan"] :selected').val();
            var year = $('select[name="tahun_laporan"] :selected').val();

           $.ajax({
               url: 'report/ajaxGetMonthlyReport',
               data: 
               {
                   month: month,
                   year: year
               }
           }).done(function(data)
           {
               var target = $('#table-laporan-bulanan > tbody:last');
               target.empty();
                    
               $.each(data, function(index, obj)
                {
                    target.append( '<tr>'
                        + '<td>'+(index + 1)+'</td>'
                        + '<td>'+obj.date+'</td>'
                        + '<td>'+obj.total_bulan+'</td>'
                        + '<td>'+obj.total_rekening+'</td>'
                        + '<td class="currency">'+formatToCurrency(obj.total_tagihan)+'</td>'
                        + '<td class="currency">'+formatToCurrency(obj.total_admin)+'</td>'
                        + '<td class="currency">'+formatToCurrency(obj.total)+'</td>'
                        + '</tr>'
                    );
                });
           });
        });
        
        $('#btn-laporan-harian').click(function()
        {
            var date = $('input[name="date_laporan"]').val();

           $.ajax({
               url: 'report/ajaxGetDailyReport',
               data: 
               {
                   date: date
               }
           }).done(function(data)
           {
               var target = $('#table-laporan-harian > tbody:last');
               target.empty();
                    
               $.each(data, function(index, obj)
                {
                    target.append( '<tr>'
                        + '<td>'+(index + 1)+'</td>'
                        + '<td>'+obj.nama_produk+'</td>'
                        + '<td>'+obj.nomor_rekening+'</td>'
                        + '<td>'+obj.nama_pelanggan+'</td>'
                        + '<td>'+obj.total_rekening+'</td>'
                        + '<td>'+obj.total_bulan+'</td>'
                        + '<td class="currency">'+formatToCurrency(obj.trans_value)+'</td>'
                        + '<td class="currency">'+formatToCurrency(obj.admin_value)+'</td>'
                        + '<td class="currency">'+formatToCurrency(obj.total)+'</td>'
                        + '</tr>'
                    );
                });
           });
        });
        
        $('#date-laporan').fdatepicker({
            format: "dd-mm-yyyy"
        });
        
        $('#collective-payment').change(function()
        {
            if(this.checked)
            {
                $('#file-collective-postpaid').show();
            }
            else
            {
                $('#file-collective-postpaid').hide();
            }
        });
        
        $('#check-all-tagihan').change(function()
        {
            var rootIsChecked = this.checked;
            $('input[type="checkbox"].item-tagihan').each(function()
            {
                if(rootIsChecked)
                {
                    this.checked = true;
                }
                else
                {
                    this.checked = false;
                }
            });
        });

        function loadProductData(url, dropdown)
        {
            var productDict = new Array();
            
            $.ajax({
                url: url
            }).done(function(data)
            {
                $.each(data, function(i, obj)
                {
                    var product = obj.product;
                    var subProducts = obj.sub_products;
                    productDict[product.product_code] = subProducts;

                    dropdown.append(
                            $('<option></option>')
                            .val(product.product_code)
                            .html(product.title));
                });
            });
            
            return productDict;
        }
        
        function doPayment(transactionId)
        {
            $('#ajax-loader').show();
            var transactionData = inquiryResponseData[transactionId];
            $.ajax({
                url: "transaksi/ajaxDoPostingPayment",
                data: transactionData
            }).done(function(data)
            {
                var label = "";
                if(data.status === 'success')
                {
                    label = '<span class="label success radius">Success</span>';
                    var filename = data.message;
                    window.open("struk/"+filename, "", "width=350, height=400");
                }
                else
                {
                    label = '<span class="label alert radius">Error</span>';
                    $('#notif-header').text("Terjadi Kesalahan");
                    $('#notif-body').text(data.message);
                    $('#modal-notification').foundation('reveal', 'open');
                }
                
                $('#'+transactionId).attr('disabled', true);
                $('#'+transactionId).attr('checked', false);
                $('input[name="jumlah_bayar"]').val('');
                    
                var columnStatus = $('#row_'+transactionId).find('td').eq(9);
                columnStatus.html(label);
                $('#ajax-loader').hide();
            });
        }
        
        function doInquiry(productCode, subProductCode, idPelanggan, url)
        {
            $('#ajax-loader').show();
            $.ajax({
                url: url,
                data: {
                    biller_id: productCode,
                    product_id: subProductCode,
                    pelanggan_id: idPelanggan
                }
            }).done(function(data)
            {
                var status = data.status;
                if(status === 'success')
                {
                    var info = data.message;
                    var billData = info.billData;
                    var adminFee = info.adminFee;
                    var totalBill = 0;
                    var countBill = 0;
                    var billRefs = new Array();

                    $.each(billData, function(i, obj) {
                        countBill++;
                        totalBill += obj.billAmount;
                        billRefs[i] = obj.billRef;
                    });

                    var dataId = billRefs.join();
                    inquiryResponseData[dataId] = info;

                    var target = $('#table-tagihan > tbody:last');
                    var grandTotal = parseInt(totalBill) + parseInt(adminFee);
                    target.append( '<tr id="row_'+dataId+'">'
                        + '<td><input id="'+dataId+'" type="checkbox" name="item_tagihan" value="'+dataId+'" class="item-tagihan" /></td>'
                        + '<td>'+info.productName+'</td>'
                        + '<td>'+info.otherCustomerId+'</td>'
                        + '<td>'+info.customerName+'</td>'
                        + '<td>1</td>'
                        + '<td>'+countBill+'</td>'
                        + '<td class="currency">'+formatToCurrency(totalBill)+'</td>'
                        + '<td class="currency">'+formatToCurrency(adminFee)+'</td>'
                        + '<td class="currency">'+formatToCurrency(grandTotal)+'</td>'
                        + '<td><span class="label radius warning">Inquiry</span></td>'
                        + '</tr>'
                    );
                }
                else
                {
                    $('#notif-header').text("Terjadi Kesalahan");
                    $('#notif-body').text(data.message);
                    $('#modal-notification').foundation('reveal', 'open');
                }
                
                $('#ajax-loader').hide();
            });
        }
    });
</script>
@stop