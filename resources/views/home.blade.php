@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4 col-sm-12 justify-content-center mx-auto text-center">
        <h2 class="mb-3">Yok Absen Yok</h2>
        <a href="{{ route('attendances.create') }}">
            <input type="button" id="absen" value="ABSEN" class="btn btn-primary" />
        </a>
        <!-- <a href="{{ route('attendances.create') }}" type="button" id="absen" name="absen" class="btn btn-primary" disable>ABSEN</a> -->
        <script type="text/javascript" defer="defer">
            var enableDisable = function() {
                var UTC_hours = new Date().getUTCHours() + 7;
                if (UTC_hours >= 12 || UTC_hours < 6) {
                    document.getElementById('absen').disabled = true;
                } else {
                    document.getElementById('absen').disabled = false;
                }
            };
            setInterval(enableDisable, 1000 * 60);
            enableDisable();
            // 
        </script>
    </div>
</div>
@endsection