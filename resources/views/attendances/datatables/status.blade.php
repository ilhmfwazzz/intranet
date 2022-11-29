{!! Form::open(['method' => 'PATCH','route' => ['stores.update3', $id],'style'=>'display:inline', 'id'=>'form_'.$id]) !!}
    {!! Form::checkbox('is_active', 1, $is_active, array('data-toggle' => 'toggle', 'id' => 'form_'.$id, 'onchange' => "$('#form_$id').submit()")) !!}
    {!! Form::hidden('phone_validate', $phone) !!}
    {!! Form::hidden('email_validate', $email) !!}
{!! Form::close() !!}