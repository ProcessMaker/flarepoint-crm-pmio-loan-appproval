@extends('layouts.master')

@section('heading')

@stop

@section('content')
@push('scripts')
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush

    <div class="row">
        @include('partials.clientheader')
        <div  class="col-md-6"></div>
        {{--@include('partials.userheader')--}}
        <div class="col-md-12">
            <table class="table">
                <h4>{{ __('All Documents') }}</h4>
                {{--<div class="col-xs-10">
                    <div class="form-group">
                        <form method="POST" action="{{ url('/clients/upload', $client->id)}}" class="dropzone" id="dropzone"
                              files="true" data-dz-removea
                              enctype="multipart/form-data"
                        >
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                        </form>
                        <p><b>{{ __('Max size') }}</b></p>
                    </div>
                </div>--}}
                <thead>
                <tr>
                    <th>{{ __('File') }}</th>
                    <th>{{ __('Size') }}</th>
                    <th>{{ __('Created at') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($client->documents as $document)
                    <tr>
                        <td><a href="../files/{{$companyname}}/{{$document->path}}"
                               target="_blank">{{$document->file_display}}</a></td>
                        <td>{{$document->size}} <span class="moveright"> MB</span></td>
                        <td>{{$document->created_at}}</td>

                        <td>
                            <form method="POST" action="{{action('DocumentsController@destroy', $document->id)}}">
                                <input type="hidden" name="_method" value="delete"/>
                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                <input type="submit" class="btn btn-danger" value="Delete"/>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            @include('partials.comments', ['subject' => $tasks])
        </div>
        <div class="col-md-3">
            <div class="sidebarheader">
                <p>{{ __('Task information') }}</p>
            </div>
            <div class="sidebarbox">
                <p>{{ __('Assigned') }}:
                    <a href="{{route('users.show', $tasks->user->id)}}">
                        {{$tasks->user->name}}</a></p>
                <p>{{ __('Created at') }}: {{ date('d F, Y, H:i', strtotime($tasks->created_at))}} </p>

                @if($tasks->days_until_deadline)
                    <p>{{ __('Deadline') }}: <span style="color:red;">{{date('d, F Y', strTotime($tasks->deadline))}}

                            @if($tasks->status == 1)({!! $tasks->days_until_deadline !!})@endif</span></p>
                    <!--Remove days left if tasks is completed-->

                @else
                    <p>{{ __('Deadline') }}: <span style="color:green;">{{date('d, F Y', strTotime($tasks->deadline))}}

                            @if($tasks->status == 1)({!! $tasks->days_until_deadline !!})@endif</span></p>
                    <!--Remove days left if tasks is completed-->
                @endif
                <p>
                @if($tasks->status == 1)
                    {{ __('Status') }}: {{ __('Open') }}
                @elseif($tasks->status == 2)
                    {{ __('Status') }}: {{ __('Closed') }}
                @elseif($tasks->status == 3)
                    {{ __('Status') }}: {{ __('Approved') }}
                @elseif($tasks->status == 4)
                    {{ __('Status') }}: {{ __('Rejected') }}
                @endif
                </p>
                <p><span style="font-weight: bold;">{{__('Amount')}}</span>: {{number_format($tasks->amount, 2, '.', ' ')}} <span>$</span></p>
            </div>
            @if($tasks->status == 1)

                {!! Form::model($tasks, [
               'method' => 'PATCH',
                'url' => ['tasks/updateassign', $tasks->id],
                ]) !!}
                {!! Form::select('user_assigned_id', $users, null, ['class' => 'form-control ui search selection top right pointing search-select', 'id' => 'search-select']) !!}
                {!! Form::submit(__('Assign user'), ['class' => 'btn btn-primary form-control closebtn']) !!}
                {!! Form::close() !!}

                {!! Form::model($tasks, [
          'method' => 'PATCH',
          'url' => ['tasks/updatestatus', $tasks->id],
          ]) !!}

                {!! Form::submit(__('Close task'), ['class' => 'btn btn-success form-control closebtn']) !!}
                {!! Form::close() !!}

            @endif
            {{--<div class="sidebarheader">
                <p>{{ __('Time management') }}</p>
            </div>
            <table class="table table_wrapper ">
                <tr>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Time') }}</th>
                </tr>
                <tbody>
                @foreach($tasktimes as $tasktime)
                    <tr>
                        <td style="padding: 5px">{{$tasktime->title}}</td>
                        <td style="padding: 5px">{{$tasktime->time}} </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <br/>
            <button type="button" class="btn btn-primary form-control" value="add_time_modal" data-toggle="modal" data-target="#ModalTimer">
                {{ __('Add time') }}
            </button>

            <button type="button" class="btn btn-primary form-control movedown" data-toggle="modal"
                    data-target="#myModal">
                {{ __('Create invoice') }}
            </button>--}}
            
            <div class="activity-feed movedown">
                @foreach($tasks->activity as $activity)
                    <div class="feed-item">
                        <div class="activity-date">{{date('d, F Y H:i', strTotime($activity->created_at))}}</div>
                        <div class="activity-text">{{$activity->text}}</div>

                    </div>
                @endforeach
            </div>
            <div class="modal fade" id="ModalTimer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">
                            {{ __('Time management') }}
                                ({{$tasks->title}})</h4>
                            
                            }
                        </div>
                       {!! Form::open([
                            'method' => 'post',
                            'url' => ['tasks/updatetime', $tasks->id],
                        ]) !!}
                        <div class="modal-body">

                 

                            <div class="form-group">
                                {!! Form::label('title', __('Title'), ['class' => 'control-label']) !!}
                                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' =>  Lang::get('task.invoices.modal.title_placerholder')]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('comment',  __('Description'), ['class' => 'control-label']) !!}
                                {!! Form::textarea('comment', null, ['class' => 'form-control', 'placeholder' => Lang::get('task.invoices.modal.description_placerholder')]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('value', __('Hourly price'), ['class' => 'control-label']) !!}
                                {!! Form::text('value', null, ['class' => 'form-control', 'placeholder' => '300']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('time', __('Time spend'), ['class' => 'control-label']) !!}
                                {!! Form::text('time', null, ['class' => 'form-control', 'placeholder' => '3']) !!}
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default col-lg-6"
                                    data-dismiss="modal">{{ __('Close') }}</button>
                            <div class="col-lg-6">
                                {!! Form::submit( __('Register time'), ['class' => 'btn btn-success form-control closebtn']) !!}
                            </div>
                          
                        </div>
                          {!! Form::close() !!}
                    </div>
                </div>
            </div>


            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{ __('Create invoice')}} </h4>
                        </div>
                        {!! Form::model($tasks, [
                           'method' => 'POST',
                           'url' => ['tasks/invoice', $tasks->id],
                        ]) !!}
                        <div class="modal-body">
                            @if($apiconnected)
                                @foreach ($contacts as $key => $contact)
                                    {!! Form::radio('invoiceContact', $contact['guid']) !!}
                                    {{$contact['name']}}
                                    <br/>
                                @endforeach
                                {!! Form::label('mail', __('Send mail with invoice to Customer?(Cheked = Yes):'), ['class' => 'control-label']) !!}
                                {!! Form::checkbox('sendMail', true) !!}
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default col-lg-6"
                                    data-dismiss="modal">{{ __('Close') }}</button>
                            <div class="col-lg-6">
                                {!! Form::submit(__('Create'), ['class' => 'btn btn-success form-control closebtn']) !!}
                            </div>
                        </div>
                      {!! Form::close() !!}
                    </div>
                </div>
            </div>


        </div>

    </div>
@stop