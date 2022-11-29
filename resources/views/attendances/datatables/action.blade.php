<a class="btn btn-info" data-toggle="tooltip_show" href="{{ route('stores.show',$email) }}" style="display:inline"><i class="fas fa-eye"></i></a>
<a class="btn btn-primary" data-toggle="tooltip_edit" href="{{ route('stores.edit',$id) }}" style="display:inline"><i class="fas fa-edit"></i></a>
<a class="btn btn-primary" data-toggle="tooltip_workhour" href="{{ route('stores.workhour',$id) }}" style="display:inline"><i class="fas fa-clock"></i></a>
    {!! Form::open(['method' => 'DELETE','route' => ['stores.destroy', $id],'style'=>'display:inline']) !!}
        <button type="submit" data-toggle="tooltip_delete" class="btn btn-danger"><i class="fas fa-trash"></i></button>
    {!! Form::close() !!}