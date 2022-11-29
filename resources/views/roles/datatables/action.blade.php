<a class="btn btn-info" data-toggle="tooltip_show" href="{{ route('categories.show',$id) }}" style="display:inline"><i class="fas fa-eye"></i></a>
<a class="btn btn-primary" data-toggle="tooltip_edit" href="{{ route('categories.edit',$id) }}" style="display:inline"><i class="fas fa-edit"></i></a>
    {!! Form::open(['method' => 'DELETE','route' => ['categories.destroy', $id],'style'=>'display:inline']) !!}
        <button type="submit" data-toggle="tooltip_delete" class="btn btn-danger"><i class="fas fa-trash"></i></button>
    {!! Form::close() !!}