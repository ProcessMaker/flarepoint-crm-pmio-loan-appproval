@extends('layouts.master')

@section('content')

        <h3>{{ __('Integrations') }}</h3>
        {{--<div class="col-sm-4">
            <img src="imagesIntegration/dinero-logo.png" width="50%" align="center" alt="">

            {!! Form::open([
               'route' => 'integrations.store'
           ]) !!}
            <div class="form-group">
                {!! Form::label('api_key', __('Api key'), ['class' => 'control-label']) !!}
                {!! Form::text('api_key', null, ['class' => 'form-control']) !!}
            </div>


            <div class="form-group">
                {!! Form::label('org_id',  __('Organization id'), ['class' => 'control-label']) !!}
                {!! Form::text('org_id', null, ['class' => 'form-control']) !!}
            </div>


            {!! Form::hidden('name', 'Dinero') !!}
            {!! Form::hidden('api_type', 'billing') !!}

            {!! Form::submit(__('Update'), ['class' => 'btn btn-primary']) !!}

            {!! Form::close() !!}
        </div>

        <div class="col-sm-4">

            <img src="imagesIntegration/billy-logo-final_blue.png" width="50%" align="center" alt="">
            {!! Form::open([

           ]) !!}
            <div class="form-group">
                {!! Form::label('api_key', __('Api key'), ['class' => 'control-label']) !!}
                {!! Form::text('api_key', null, ['class' => 'form-control']) !!}
            </div>


            {!! Form::hidden('name', 'Billy') !!}
            {!! Form::hidden('api_type', 'billing') !!}
            {!! Form::submit(__('Update'), ['class' => 'btn btn-primary']) !!}

            {!! Form::close() !!}
        </div>--}}
        <div class="row">
            <div class="col-sm-4">
                @php
                 $host = (isset($check[0]->host)) ?  $check[0]->host : null;
                @endphp
                <img src="imagesIntegration/logo-black-processmaker.svg" width="50%" align="center" alt="">
                {!! Form::open([

               ]) !!}
                <div class="form-group">
                    {!! Form::label('host', __('Host'), ['class' => 'control-label']) !!}
                    <div class="input-group">
                    <span class="input-group-addon" id="basic-addon3">https://</span>
                    {!! Form::text('host', $host, ['class' => 'form-control']) !!}
                    </div>
                </div>


                {!! Form::hidden('name', 'Processmaker_core') !!}
                {!! Form::hidden('api_type', 'processmaker_core') !!}
                {!! Form::submit(__('Update'), ['class' => 'btn btn-primary']) !!}

                {!! Form::close() !!}
            </div>
        </div>

@stop