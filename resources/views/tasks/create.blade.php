@extends('layouts.master')
@section('heading')
    <h1>Create Loan Request</h1>
@stop

@section('content')

    {!! Form::open([
            'route' => 'tasks.store'
            ]) !!}

    <div class="form-group">
        {!! Form::label('title', __('Title') , ['class' => 'control-label']) !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('description', __('Description'), ['class' => 'control-label']) !!}
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-inline">
        <div class="form-group col-sm-4 removeleft ">
            {!! Form::label('deadline', __('Deadline'), ['class' => 'control-label']) !!}
            {!! Form::date('deadline', \Carbon\Carbon::now()->addDays(3), ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-sm-4 removeleft removeright">
            {!! Form::label('status', __('Status'), ['class' => 'control-label']) !!}
            {!! Form::select('status', array(
            '1' => 'Open', '3' =>'Approved', '4' =>'Rejected', '2' => 'Completed'), null, ['class' => 'form-control'] )
         !!}
        </div>
        <div class="form-group col-sm-4 removeright" >
            <div class="input-group">
            {!! Form::label('amount', __('Amount'), ['class' => 'control-label']) !!}
            {{--<span class="input-group-addon">$</span>--}}
            {!! Form::text('amount', null, ['class' => 'form-control', 'placeholder' => '00.00']) !!}
                <span class="input-group-addon">$</span>
            </div>
        </div>

    </div>
    <div class="form-group form-inline">
        {!! Form::label('user_assigned_id', __('Assign user'), ['class' => 'control-label']) !!}
        {!! Form::select('user_assigned_id', $users, null, ['class' => 'form-control']) !!}
        @if(Request::get('client') != "")
            {!! Form::hidden('client_id', Request::get('client')) !!}
        @else
            {!! Form::label('client_id', __('Assign client'), ['class' => 'control-label']) !!}
            {!! Form::select('client_id', $clients, null, ['class' => 'form-control']) !!}
        @endif
    </div>

    {!! Form::submit(__('Create task'), ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}





@stop