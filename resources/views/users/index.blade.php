@extends('layouts.app')
@push('css')
<link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
<div class="row mb-3">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Users Management</h2>
        </div>
        @can('user-create')
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
        </div>
        @endcan
    </div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif
<table class="datatable table-bordered">
  <thead>
    <tr>
      <th>No</th>
      <th>Name</th>
      <th>Email</th>
      <th>Roles</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $key => $user)
    <tr>
      <td>{{ ++$i }}</td>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>
      <td>
        @if(!empty($user->getRoleNames()))
          @foreach($user->getRoleNames() as $v)
            <label class="badge badge-success">{{ $v }}</label>
          @endforeach
        @endif
      </td>
      <td>
        <a class="btn btn-info" href="{{ route('users.show',$user->id) }}"><i class="fas fa-eye"></i></a>
        @can('user-edit')
        <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}"><i class="fas fa-edit"></i></a>
        @endcan
        @can('user-delete')
          {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
              <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
          {!! Form::close() !!}
        @endcan
      </td>
    </tr>
    @endforeach
  </tbody>
  <tfoot>
    <tr>
      <th>No</th>
      <th>Name</th>
      <th>Email</th>
      <th>Roles</th>
      <th>Action</th>
    </tr>
  </theatfootd>
</table>
@endsection
@push('scripts')
<script type="text/javascript" src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
  $(function () {
    $('.datatable').DataTable({
        initComplete: function () {
            this.api().columns().every( function () {
            var that = this;
            $( 'input', this.footer() ).on( 'keyup change clear', function () {
                if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
                }
            } );
            } );
        },
      "bStateSave": true,
      "fnStateSave": function (oSettings, oData) {
          localStorage.setItem('offersDataTables', JSON.stringify(oData));
      },
      "fnStateLoad": function (oSettings) {
          return JSON.parse(localStorage.getItem('offersDataTables'));
      }
    });
  });
</script>
@endpush