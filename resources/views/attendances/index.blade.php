@extends('layouts.app')
@push('css')
<link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<div class="row mb-3">
  <div class="col-lg-12 margin-tb mb-3">
    <div class="pull-left">
      <h2>Attendance Management</h2>
    </div>
    @unlessrole('Admin')
    <div class="pull-right">
      <a href="{{ route('attendances.create') }}">
        <input type="button" id="absen" value="Create New Attendance" class="btn btn-primary" />
      </a>
      <script type="text/javascript" defer="defer">
        var enableDisable = function() {
          var UTC_hours = new Date().getUTCHours() + 7;
          if (UTC_hours > 12 || UTC_hours < 6) {
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
    @endunlessrole
  </div>
  @can('absen-export')
  <div class="col-lg-12 margin-tb mb-3">
    {!! Form::model($attendances, ['method' => 'POST','route' => ['attendances.export']]) !!}
    <div class="row mb-3">
      <div class="col-md-6 col-sm-12">
        <input type="text" name="timestamp" id="reservation" class="form-control float-right" placeholder="Select date range" autocomplete="off">
      </div>
      <div class="col-md-6 col-sm-12">
        <button type="submit" class="btn btn-info">Export</button>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
  @endhasrole
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif
@if ($message = Session::get('danger'))
<div class="alert alert-danger">
  <p>{{ $message }}</p>
</div>
@endif
<table class="datatable table-bordered">
  <thead>
    <tr>
      @isset($attendances[0]->name)
      <th>Nama</th>
      @endisset
      <th>Kategori</th>
      <th>Tanggal</th>
      <th>Keterangan</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($attendances as $key => $attendance)
    <tr>
      @isset($attendance->name)
      <td>{{ $attendance->name }}</td>
      @endisset
      @switch($attendance->category)
      @case(1)
      <td>Work from Office</td>
      @break
      @case(2)
      <td>Work from Home</td>
      @break
      @case(3)
      <td>Rapat/Dinas</td>
      @break
      @case(4)
      <td>Cuti/Tidak Masuk</td>
      @break
      @default
      <td>ERROR</td>
      @endswitch
      <?php
      $today = date('Ymd', strtotime("now"));
      $match_date = date('Ymd', $attendance->entry_date);
      if ($today == $match_date) {
      ?>
        <td>
          <label class="badge badge-success" style="font-size: 100%;"><?php echo date('l, Y-m-d H:i:s', $attendance->entry_date); ?></label>
        </td>
      <?php
      } else {
      ?>
        <td>
          <?php echo date('l, Y-m-d H:i:s', $attendance->entry_date); ?>
        </td>
      <?php } ?>
      <td>{{ $attendance->note }}</td>
    </tr>
    @endforeach
  </tbody>
  <tfoot>
    <tr>
      @isset($attendances[0]->name)
      <th>Nama</th>
      @endisset
      <th>Kategori</th>
      <th>Tanggal</th>
      <th>Keterangan</th>
    </tr>
  </tfoot>
</table>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
  $(function() {
    $('#reservation').daterangepicker().val('');
    $('.datatable').DataTable({
      initComplete: function() {
        this.api().columns().every(function() {
          var that = this;
          $('input', this.footer()).on('keyup change clear', function() {
            if (that.search() !== this.value) {
              that
                .search(this.value)
                .draw();
            }
          });
        });
      },
      "bStateSave": true,
      "fnStateSave": function(oSettings, oData) {
        localStorage.setItem('offersDataTables', JSON.stringify(oData));
      },
      "fnStateLoad": function(oSettings) {
        return JSON.parse(localStorage.getItem('offersDataTables'));
      },
      "ordering": false
    });
  });
</script>
@endpush