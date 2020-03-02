<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <title>Login Page</title>
        <link rel="stylesheet" href="{{ URL::asset('assets/css/foundation.css') }}" />
        <link rel="stylesheet" href="{{ URL::asset('assets/css/datepicker.css') }}" />
        <link rel="stylesheet" href="{{ URL::asset('assets/css/bjqs.css') }}" />
        <link rel="stylesheet" href="{{ URL::asset('assets/css/app.css') }}" />
        <script src="{{ URL::asset('assets/js/vendor/modernizr.js') }}"></script>
    </head>
</head>
<body>
    <input type="hidden" id="time-limit" value="{{ $timer }}:00" />
    <div class="sticky">
        <nav class="top-bar" data-topbar role="navigation">
            <section class="top-bar-section">
                <ul class="right">
                    <li><a href="#" data-reveal-id="modal-change-profile">Profil</a></li>
                    <li><a href="#" data-reveal-id="modal-change-password">Ubah Password</a></li>
                    <li><a href="{{ URL::to('/user/logout') }}">Keluar</a></li>
                    <li><a href="#" id="count-down">{{ $timer }}:00</a></li>
                </ul>

                <ul class="left">
                    <li class="active"><a href="#">Transaksi</a></li>
                    <li><a href="#" data-reveal-id="modal-konfigurasi">Konfigurasi</a></li>
                </ul>
            </section>
        </nav>
    </div>
    <div id="container">
        <div class="row fullwidth">
            <div class="large-3 columns">
                <div class="widget">
                    <div class="widget-header">
                        <h6>Informasi</h6>
                    </div>
                    <div class="widget-body">
                        <p>PPID: {{ $paymentPoint->pp_id }}</p>
                        <p>Saldo: Rp. <span class="currency">{{ $paymentPoint->balance }}</span></p>
                    </div>
                </div>

                <div class="widget">
                    <div class="widget-header">
                        <h6>Pengumuman</h6>
                    </div>
                    <div id="news-slider" class="widget-body">
                        <ul class="bjqs">
                            @foreach($news as $current_news)
                            <li>
                                <h5>{{ $current_news->title }}</h4>
                                <p>{{ $current_news->content }}</p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="large-9 columns">
                @yield('content')
            </div>
        </div>
    </div>

    <div id="modal-change-password" class="modal small reveal-modal" data-reveal>
        <div class="modal-header"><h4>Ubah Password</h4></div>
        <div class="modal-body">
            <input type="password" name="old_password" placeholder="Password Lama" />
            <input type="password" name="new_password" placeholder="Password Baru" />
            <input type="password" name="confirm_password" placeholder="Konfirmasi Password Baru" />
        </div>
        <div class="modal-footer">
            <button id="btn-submit-new-password" class="button small radius">Submit</button>
            <button class="button small radius alert" onclick="$('#modal-notification').foundation('reveal', 'close');">Batal</button>
        </div>
    </div>
    <div id="modal-change-profile" class="modal small reveal-modal" data-reveal>
        <div class="modal-header"><h4>Ubah Profil</h4></div>
        <div class="modal-body">
            <div class="row">
                <div class="large-3 columns">
                    <label>Nama PP</label>
                </div>
                <div class="large-9 columns">
                    <input type="text" name="nama_pp" placeholder="Nama Payment Point" value="{{ $paymentPoint->nama }}" />
                </div>
            </div>
            <div class="row">
                <div class="large-3 columns">
                    <label>Nama Pemilik</label>
                </div>
                <div class="large-9 columns">
                    <input type="text" name="nama_pemilik" placeholder="Nama Pemilik" value="{{ $paymentPoint->nama_pemilik }}" />
                </div>
            </div>
            <div class="row">
                <div class="large-3 columns">
                    <label>Alamat</label>
                </div>
                <div class="large-9 columns">
                    <input type="text" name="alamat" placeholder="Alamat" value="{{ $paymentPoint->alamat }}" />
                </div>
            </div>
            <div class="row">
                <div class="large-3 columns">
                    <label>Kota</label>
                </div>
                <div class="large-9 columns">
                    <input type="text" name="kota" placeholder="Nama Kota" value="{{ $paymentPoint->kota }}" />
                </div>
            </div>
            <div class="row">
                <div class="large-3 columns">
                    <label>Kode Pos</label>
                </div>
                <div class="large-9 columns">
                    <input type="text" name="kode_pos" placeholder="Kode Pos" maxlength="5" value="{{ $paymentPoint->kode_pos }}" />
                </div>
            </div>
            <div class="row">
                <div class="large-3 columns">
                    <label>Kode Propinsi</label>
                </div>
                <div class="large-9 columns">
                    <input type="text" name="kode_propinsi" placeholder="Kode Propinsi" maxlength="3" value="{{ $paymentPoint->kode_propinsi }}" />
                </div>
            </div>
            <div class="row">
                <div class="large-3 columns">
                    <label>Kode Negara</label>
                </div>
                <div class="large-9 columns">
                    <input type="text" name="kode_negara" placeholder="Kode Negara" maxlength="2" value="{{ $paymentPoint->kode_negara }}" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button id="btn-submit-new-profile" class="button small radius">Submit</button>
            <button class="button small radius alert" onclick="$('#modal-change-profile').foundation('reveal', 'close');">Batal</button>
        </div>
    </div>
    <div id="modal-konfigurasi" class="modal small reveal-modal" data-reveal>
        <div class="modal-header"><h4>Konfigurasi</h4></div>
        <div class="modal-body">
            <div class="row">
                <div class="large-4 columns">
                    <label>Auto Logout</label>
                </div>
                <div class="large-8 columns">
                    <select name="timer">
                        <option value="30">30 Menit</option>
                        <option value="45">45 Menit</option>
                        <option value="60">60 Menit</option>
                        <option value="90">90 Menit</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button id="btn-update-timer" class="button small radius">Submit</button>
            <button class="button small radius alert" onclick="$('#modal-konfigurasi').foundation('reveal', 'close');">Batal</button>
        </div>
    </div>
    <div id="modal-notification" class="modal small reveal-modal" data-reveal>
        <div class="modal-header"><h4 id="notif-header"></h4></div>
        <div class="modal-body">
            <p id="notif-body"></p>
        </div>
        <div class="modal-footer">
            <button class="button small radius" onclick="$('#modal-notification').foundation('reveal', 'close');">OK</button>
        </div>
    </div>
    <div id="ajax-loader" class="loader">
        <span class="ico-loader"></span>harap tunggu...
    </div>
    
    <footer id="footer">
        <small>Copyright &copy; 2014 Online Media Indonesia</small>
    </footer>
    <script src="{{ URL::asset('assets/js/vendor/jquery.js') }}"></script>
    <script src="{{ URL::asset('assets/js/foundation.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/datepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/js/bjqs-1.3.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/script.js') }}"></script>
    <script>
        $(document).foundation();
        $(document).click(function()
        {
            var timelimit = $('#time-limit').val();
            $('#count-down').text(timelimit); 
        });
        
        setInterval(function(){
            var currentTime = $('#count-down').text();
            var minutes = Number(currentTime.split(':')[0]);
            var seconds = Number(currentTime.split(':')[1]);
            
            if((seconds === 0) && (minutes === 0))
            {
                console.log('logout');
                window.location.replace('user/logout');
            }
            
            if(seconds === 0)
            {
                minutes = minutes - 1;
                seconds = 60;
            }
            
            seconds--;
            var newTime = zeroFill(minutes) + ":" + zeroFill(seconds);
            $('#count-down').text(newTime);
        }, 1000);
        
        $('#news-slider').bjqs({
            responsive: true,
            showcontrols: false,
            animtype: 'fade'
        });
        
        $('#btn-submit-new-password').click(function()
        {
            var oldPassword = $('input[name="old_password"]').val();
            var newPassword = $('input[name="new_password"]').val();
            var confirmPassword = $('input[name="confirm_password"]').val();
            
            if(newPassword === confirmPassword)
            {
                $('#ajax-loader').show();
                $.ajax({
                    url: 'user/ajaxChangePassword',
                    type: 'POST',
                    data: {
                        old_password : oldPassword,
                        new_password : newPassword
                    }
                }).done(function(data)
                {
                    $('#ajax-loader').hide();
                    var title;
                    if(data.status === 'success')
                    {
                        title = "Sukses"
                    }
                    else if(data.status === 'failed')
                    {
                        title = "Terjadi Kesalahan"
                    }
                    
                    $('#notif-header').text(title);
                    $('#notif-body').text(data.message);
                    $('#modal-notification').foundation('reveal', 'open');
                });
            }
            else
            {
                $('#notif-header').text("Terjadi Kesalahan");
                $('#notif-body').text("Password baru dan konfirmasi password tidak cocok");
                $('#modal-notification').foundation('reveal', 'open');
            }
            
            $('input[name="old_password"]').val("");
            $('input[name="new_password"]').val("");
            $('input[name="confirm_password"]').val("");
        });
        
        $('#btn-submit-new-profile').click(function()
        {
            $('#ajax-loader').show();
            $.ajax({
                url: 'user/ajaxUpdateProfile',
                type: 'POST',
                data: {
                    nama_pp: $('input[name="nama_pp"]').val(),
                    nama_pemilik: $('input[name="nama_pemilik"]').val(),
                    alamat: $('input[name="alamat"]').val(),
                    kota: $('input[name="kota"]').val(),
                    kode_pos: $('input[name="kode_pos"]').val(),
                    kode_propinsi: $('input[name="kode_propinsi"]').val(),
                    kode_negara: $('input[name="kode_negara"]').val()
                }
            }).done(function(data)
            {
                $('#ajax-loader').hide();
                if(data.status === 'success')
                {
                    $('#notif-header').text("Sukses");
                    $('#notif-body').text("Profil anda telah berhasil diperbarui");
                    $('#modal-notification').foundation('reveal', 'open');
                }
            });
        });
        
        $('#btn-update-timer').click(function()
        {
            var timerValue = $('select[name="timer"]').val();
            $.ajax({
                url: 'user/ajaxUpdateTimer',
                type: 'POST',
                data: {timer : timerValue}
            }).done(function(data)
            {
                var countDown = timerValue + ':00';
                $('#time-limit').val(countDown);
                $('#count-down').text(countDown);
                $('#modal-konfigurasi').foundation('reveal', 'close');
            });
        });
        
        function zeroFill(number)
        {
            return number < 10 ? '0' + number : number;
        }
    </script>
    
    @yield('script')
</body>
</html>