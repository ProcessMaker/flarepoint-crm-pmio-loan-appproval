<div class="col-md-6">

    <h1 class="moveup">{{$client->name}} ({{$client->company_name}})</h1>

    <!--Client info leftside-->
    <div class="contactleft">
        @if($client->email != "")
                <!--MAIL-->
        <p><span class="glyphicon glyphicon-envelope" aria-hidden="true" data-toggle="tooltip"
                 title="{{ __('mail') }}" data-placement="left"> </span>
            <a href="mailto:{{$client->email}}" data-toggle="tooltip" data-placement="left">{{$client->email}}</a></p>
        @endif
        @if($client->primary_number != "")
                <!--Work Phone-->
        <p><span class="glyphicon glyphicon-headphones" aria-hidden="true" data-toggle="tooltip"
                 title=" {{ __('Primary number') }} " data-placement="left"> </span>
            <a href="tel:{{$client->work_number}}">{{$client->primary_number}}</a></p>
        @endif
        @if($client->secondary_number != "")
                <!--Secondary Phone-->
        <p><span class="glyphicon glyphicon-phone" aria-hidden="true" data-toggle="tooltip"
                 title="{{ __('Secondary number') }}" data-placement="left"> </span>
            <a href="tel:{{$client->secondary_number}}">{{$client->secondary_number}}</a></p>
        @endif
        @if($client->address || $client->zipcode || $client->city != "")
                <!--Address-->
        <p><span class="glyphicon glyphicon-home" aria-hidden="true" data-toggle="tooltip"
                 title="{{ __('Full address') }}" data-placement="left"> </span> {{$client->address}}
            <br/>{{$client->zipcode}} {{$client->city}}
        </p>
        @endif
    </div>

    <!--Client info leftside END-->
    <!--Client info rightside-->
    <div class="contactright">
        @if($client->company_name != "")
                <!--Company-->
        <p><span class="glyphicon glyphicon-star" aria-hidden="true" data-toggle="tooltip"
                 title="{{ __('Company') }}" data-placement="left"> </span> {{$client->company_name}}</p>
        @endif
        @if($client->vat != "")
                <!--Company-->
        <p><span class="glyphicon glyphicon-cloud" aria-hidden="true" data-toggle="tooltip"
                 title="{{ __('vat') }}" data-placement="left"> </span> {{$client->vat}}</p>
        @endif
        @if($client->industry != "")
                <!--Industry-->
        <p><span class="glyphicon glyphicon-briefcase" aria-hidden="true" data-toggle="tooltip"
                 title="{{ __('Industry') }}"data-placement="left"> </span> {{$client->industry}}</p>
        @endif
        @if($client->company_type!= "")
                <!--Company Type-->
        <p><span class="glyphicon glyphicon-globe" aria-hidden="true" data-toggle="tooltip"
                 title="{{ __('Company type') }}" data-placement="left"> </span>
            {{$client->company_type}}</p>
        @endif
    </div>
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
        @if (count($client->documents) > 0)
        @foreach($client->documents as $document)
            <tr>
                <td><a href="../files/{{$companyname}}/{{$document->path}}"
                       target="_blank">{{$document->file_display}}</a></td>
                <td>{{$document->size}} <span class="moveright"> MB</span></td>
                <td>{{$document->created_at}}</td>

                {{--<td>
                    <form method="POST" action="{{action('DocumentsController@destroy', $document->id)}}">
                        <input type="hidden" name="_method" value="delete"/>
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <input type="submit" class="btn btn-danger" value="Delete"/>
                    </form>
                </td>--}}
            </tr>
        @endforeach
        @endif
        </tbody>
    </table>
    </div>
</div>

<!--Client info rightside END-->
