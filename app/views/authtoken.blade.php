<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <title>Setup AuthToken</title>
        <link rel="stylesheet" href="{{ URL::asset('assets/css/foundation.css') }}" />
        <link rel="stylesheet" href="{{ URL::asset('assets/css/app.css') }}" />
        <script src="{{ URL::asset('assets/js/vendor/modernizr.js') }}"></script>
    </head>
    </head>
    <body>
        <div class="row" style="position: relative; top: 25%">
            <form method="POST">
                <div class="medium-6 medium-centered columns modal">
                    <div class="modal-header">
                        <h4>Setup AuthToken</h4>
                    </div>
                    <div class="modal-body">
                        @if(isset($message))
                        <div data-alert class="alert-box alert radius">
                            {{ $message }}
                            <a href="#" class="close">&times;</a>
                        </div>
                        @else
                        <div data-alert class="alert-box info radius">
                            Sistem tidak mendeteksi adanya AuthToken di komputer anda <br />
                            silahkan masukan kode AuthToken terlebih dahulu
                            <a href="#" class="close">&times;</a>
                        </div>
                        @endif
                        
                        <label>
                            <input type="text" name="username" placeholder="Username" />
                        </label>
                        <label>
                            <input type="text" name="auth_token" placeholder="AuthToken" />
                        </label>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="button radius expand" />Setup
                    </div>
                </div>
            </form>
        </div>
        
        <script src="{{ URL::asset('assets/js/vendor/jquery.js') }}"></script>
        <script src="{{ URL::asset('assets/js/foundation.min.js') }}"></script>
        <script>
            $(document).foundation();
        </script>
    </body>
</html>