<div class="form-group">
    {{ Form::label('image_path', __('Image'), ['class' => 'control-label']) }}
    {!! Form::file('image_path',  null, ['class' => 'form-control']) !!}
</div>


<div class="form-group">
    {!! Form::label('name', __('Name'), ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('email', __('Mail'), ['class' => 'control-label']) !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('address', __('Address'), ['class' => 'control-label']) !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('work_number', __('Work number'), ['class' => 'control-label']) !!}
    {!! Form::text('work_number',  null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('personal_number', __('Personal number'), ['class' => 'control-label']) !!}
    {!! Form::text('personal_number',  null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('password', __('Password'), ['class' => 'control-label']) !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('password_confirmation', __('Confirm password'), ['class' => 'control-label']) !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
</div>
<div class="form-group form-inline">
    {!! Form::label('roles', __('Assign role'), ['class' => 'control-label']) !!}
    {!!
        Form::select('roles',
        $roles,
        isset($user->role->role_id) ? $user->role->role_id : null,
        ['class' => 'form-control']) !!}

    {!! Form::label('departments', __('Assign department'), ['class' => 'control-label']) !!}

    {!!
        Form::select('departments',
        $departments,
        isset($user)
        ? $user->department->first()->id : null,
        ['class' => 'form-control']) !!}
    {!! Form::label('access_token', __('Access token for access to processmaker.io'), ['class' => 'control-label']) !!}
    {!! Form::textarea('access_token',  null, ['class' => 'form-control', 'placeholder' => 'Access token']) !!}
    {!! Form::label('refresh_token', __('Refresh token for access to processmaker.io'), ['class' => 'control-label']) !!}
    {!! Form::textarea('refresh_token',  null, ['class' => 'form-control', 'placeholder' => 'Refresh token']) !!}
</div>

{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
