@extends('layouts.master')

@section('heading')

@stop

@section('content')
    @push('scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    @if(\Auth::user()->name == 'Test')


        <script>
            /* Interface for Test user*/
            var taskstatus = {{$tasks->status}};

            var taskInstance = '';

            var client = axios.create({
                baseURL: 'http://{{$host}}/api/v1/',
                //timeout: 1000,
                headers: {
                    "content-type": "application/json",
                    "Accept": "application/json",
                    'Authorization' : 'Bearer {{ \Auth::user()->access_token }}'
                },
                onUploadProgress: function (progressEvent) {

                },

            });

            function getManagerTask() {
                $('div.loader').fadeToggle(300);
                client.get('processes/Loan%20Request/datamodels/search/case_id='+{{$tasks->id}})
                    .then(function (response) {
                        if (response.status == 200 && response.data.data.length > 0) {
                            var instanceId = response.data.data[0].attributes.instance_id;
                            client.get('instances/'+instanceId+'/tasks/Manager%20decision/task_instances/delegated')
                                .then(function (response) {
                                    console.log(response);
                                    taskInstance = response.data.data[0];
                                    if (response.data.data.length > 0){
                                        $('div.loader').fadeToggle(1);
                                        $('div.manager-decision').fadeIn(500);
                                    } else {
                                        client.get('instances/'+instanceId+'/tasks/Manager%20decision/task_instances')
                                            .then(function (response) {
                                                if (response.data.data.length > 0 && response.data.data[0].attributes.status == 'COMPLETE'){
                                                    $('div.loader').fadeToggle(1);
                                                    $('div.manager-decision').html("<p>You \'ve already made decision</p>").fadeIn(300);
                                                }

                                            });
                                    }
                                });
                        }
                    }).catch(function (error) {
                    console.log(error);
                });
            }

            function setManagerDecision(decision) {
                var data = {
                    'data': {
                        'type':'task_instance',
                        'attributes': {
                            'status':'COMPLETE',
                            'content':{'manager_status':decision}
                        }
                    }
                };
                data = JSON.stringify(data);
                client.patch('task_instances/'+taskInstance.id, data)
                    .then(function (response) {
                        console.log(response);
                        if (response.status == 200) {
                            console.log(response.data.data[0]);
                            $('div.loader').fadeToggle(1);
                            $('div.manager-decision')
                                .html('<p>You \'ve made decision</p>');

                        } else return false;
                    }).catch(function (error) {
                    console.log(error);
                });
            }

            $(document).ready(function() {
                console.log(taskstatus);
                if (taskstatus == 1) {
                    getManagerTask();
                }
            });

            $('.manager-decision button').on('click', function () {
                $('div.manager-decision :button')
                    .fadeOut('300');
                $('div.loader').fadeToggle(1);
                setManagerDecision($(this).data('manager_status'));
            });

            /*
             var app = new Vue({
             el: 'body',
             data: {
             who: '11'
             managerdata: false,
             bigboss: false,
             manager_status: '',
             bigboss_status: ''
             },
             methods: {
             managertask: function() {
             console.log(this.who)
             client.get('processes/Loan%20Request/datamodels/search/case_id='+)
             .then(function (response) {
             if (response.status == 200 && response.data.data.length > 0) {
             //console.log(response.data.data[0]);
             this.who = 'Manager'
             this.managerdata = true
             return true;
             } else return false;

             });
             },
             bigbosstask: function() {
             client.get('processes/Loan%20Request/datamodels/search/case_id=')
             .then(function (response) {
             if (response.status == 200 && response.data.data.length > 0) {
             console.log(response.data.data[0]);
             }

             });
             }
             },
             created: function () {
             if (this.managertask() === false) {
             if (!this.bigbosstask() === false) {
             //Here request about decision
             }
             }
             }

             });

             */
        </script>

    @elseif(\Auth::user()->name == 'Bob')


        <script>
            /* Interface for Bob user*/
            var taskstatus = {{$tasks->status}};

            var taskInstance = '';

            var client = axios.create({
                baseURL: 'http://{{$host}}/api/v1/',
                //timeout: 1000,
                headers: {
                    "content-type": "application/json",
                    "Accept": "application/json",
                    'Authorization' : 'Bearer {{ \Auth::user()->access_token }}'
                }

            });

            function getBigBossTask() {
                $('div.loader').fadeToggle(300);
                client.get('processes/Loan%20Request/datamodels/search/case_id='+{{$tasks->id}})
                    .then(function (response) {
                        console.log(response);
                        if (response.status == 200 && response.data.data.length > 0) {
                            var instanceId = response.data.data[0].attributes.instance_id;
                            client.get('instances/'+instanceId+'/tasks/Big%20boss%20 approval/task_instances/delegated')
                                .then(function (response) {
                                    console.log(response);
                                    taskInstance = response.data.data[0];
                                    if (response.data.data.length > 0){
                                        $('div.loader').fadeToggle(1);
                                        $('div.bigboss-decision').fadeIn(500);
                                    } else {
                                        client.get('instances/'+instanceId+'/tasks/Big%20boss%20 approval/task_instances')
                                            .then(function (response) {
                                                if (response.data.data.length > 0 && response.data.data[0].attributes.status == 'COMPLETE'){
                                                    $('div.loader').fadeToggle(1);
                                                    $('div.bigboss-decision').html("<p>You \'ve already made decision</p>").fadeIn(300);
                                                }

                                            });
                                    }
                                });
                        }
                    }).catch(function (error) {
                    console.log(error);
                });
            }

            function setBigBossDecision(decision) {
                var data = {
                    'data': {
                        'type':'task_instance',
                        'attributes': {
                            'status':'COMPLETE',
                            'content':{'manager_status':decision}
                        }
                    }
                };
                data = JSON.stringify(data);
                client.patch('task_instances/'+taskInstance.id, data)
                    .then(function (response) {
                        console.log(response);
                        if (response.status == 200) {
                            console.log(response.data.data[0]);
                            $('div.bigboss-decision :button')
                                .fadeOut('300')
                                .html('<p>You \'ve made decision</p>');
                        } else return false;
                    }).catch(function (error) {
                    console.log(error);
                });
            }

            $(document).ready(function() {
                if (taskstatus == 1) {
                    getBigBossTask();
                }
            });

            $('.bigboss-decision button').on('click', function () {
                setBigBossDecision($(this).data('big_boss_status'));
            });
        </script>

    @endif

    @endpush


{{--<style>
    [v-cloak] {
        display: none;
    }
</style>--}}

    <div class="row">
        @include('partials.clientheader')

            <div id="processmaker"  class="col-md-6 text-center" >
            <img src="{{ asset('imagesIntegration/logo-black-processmaker.svg') }}" width="50%" align="center"/>
            <div class="loader" style="display: none;"><img src="{{asset('images/ajax-loader.gif')}}" /></div>
            <div class="text-center manager-decision" style="display: none;">
                <h2 class="text-center">Manager Decision</h2>
                <button class="btn btn-success" data-manager_status = "approved">Approve</button>
                <button class="btn btn-danger" data-manager_status = "rejected">Reject</button>
            </div>

                <div class="text-center bigboss-decision" style="display: none;">
                    <h2 class="text-center" >Bigboss Decision</h2>
                    <button class="btn btn-success" data-big_boss_status = "approved">Approve</button>
                    <button class="btn btn-danger" data-big_boss_status = "rejected">Reject</button>
                </div>

            </div>


    </div>
    {{--@include('partials.userheader')--}}
    <div class="row">
        <div class="col-md-9">
            @include('partials.comments', ['subject' => $tasks])
        </div>
        <div class="col-md-3">
            <div class="sidebarheader">
                <p>{{ __('Loan information') }}</p>
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
                @elseif($tasks->status == 5)
                    {{ __('Status') }}: {{ __('Reqest internal error') }}
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

                {!! Form::submit(__('Close loan'), ['class' => 'btn btn-success form-control closebtn']) !!}
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