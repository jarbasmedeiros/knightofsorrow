@extends('layouts.main')
@section('title',"Match Details")
@section('styles')
    <style>
        .tab-pane
        {
            padding: 10px;
        }
        .form.form-inline
        {
            display: inline-block;
        }
        .vs:before
        {
            content: 'vs';
            font-size: 25px;
            float: right;
            color: #03A9F4;
        }
        .team-name
        {
            padding: 10px !important;
        }
        .team-name.small
        {
            padding: 5px !important;
        }
        .font125p
        {
            font-size:125% !important;
        }

        .label {
            display: inline;
            font-size: 100%;
            font-weight: normal;
            line-height: 1;
            text-align:start;
            color:black;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25em;
        }
        .dd-bracket
        {
            padding: 20px;
            border: 2px grey dashed;
        }
    </style>
@endsection

@section('before-container')
    <div class="header wg-primary">
        <div class="container">
            <h1 class="ng-binding text-center"><a href="{{ route('tournament.show',$tournament->slug) }}">{{ $tournament->name }}</a> Match {{ $match->match_index+1 }}</h1>
            <h3 class="text-center">{!! link_to_route('tournament.team.show',$match->team1->name,$match->k_team1_id)  !!} vs {!! link_to_route('tournament.team.show',$match->team2->name,$match->k_team2_id)  !!}</h3>
            <h4 style="border-top:1px solid grey;padding: 10px;" class="text-center">{!! $match->getWinningTextForNotifications() !!}</h4>
        </div><!--end .container-->
    </div>
@endsection

@section('main-container')
    <div class="col-xs-12 padding10">
        @forelse($games as $round)
            <div class="col-xs-12 panel panel-default no-margin no-padding" style="margin-bottom: 30px !important;">
                <div class="panel-heading"><b>
                        Match {{ $round->game_index }}</b>
                </div>
                    <div class="panel-body">
                        <div class="well round-detail-summary text-center">
                            {{ $round->timeAgo }} &nbsp;&squarf;&nbsp; {{ $round->mapName }} &nbsp;&squarf;&nbsp; Round
                            time: {{ $round->time }} &nbsp;&squarf;&nbsp; Round: {{ $round->index }}
                        </div>
                        <div class="col-xs-12">
                            <div class="round-detail-players-swat panel panel-default col-xs-6 no-margin no-padding">
                                <div class="panel-heading"><strong>SWAT {!! $round->swatScoreWithColor !!}</strong></div>
                                <div class="panel-body">
                                    @if($round->SwatPlayers->isEmpty())
                                        <h5>Its lone here.</h5>
                                    @else
                                        <table class="table table-hover table-striped no-margin">
                                            <thead>
                                            <tr>
                                                <th class="col-xs-1">Flag</th>
                                                <th class="col-xs-3">Name</th>
                                                <th class="col-xs-1 text-right">Score</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($round->SwatPlayers as $swat)
                                                <tr class="getindistats" data-id="{{ $swat->id }}">
                                                    <td>{!! Html::image('/images/flags/20_shiny/'.$swat->country->countryCode.".png",$swat->country->countryCode,['class' => 'tooltipster', 'title' => $swat->country->countryName]) !!}</td>
                                                    <td><strong>{{ $swat->name }}</strong></td>
                                                    <td class="text-right"><strong>{{ $swat->score }}</strong></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                            <div class="round-detail-players-suspects panel panel-default col-xs-6 no-margin no-padding">
                                <div class="panel-heading"><strong>SUSPECTS {!! $round->suspectsScoreWithColor !!}</strong>
                                </div>
                                <div class="panel-body">
                                    @if($round->SuspectPlayers->isEmpty())
                                        <h5>Its lone here.</h5>
                                    @else
                                        <table class="table table-hover table-striped no-margin">
                                            <thead>
                                            <tr>
                                                <th class="col-xs-1">Flag</th>
                                                <th class="col-xs-3">Name</th>
                                                <th class="col-xs-1 text-right">Score</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($round->SuspectPlayers as $suspect)
                                                <tr class="getindistats" data-id="{{ $suspect->id }}">
                                                    <td>{!! Html::image('/images/flags/20_shiny/'.$suspect->country->countryCode.".png",$suspect->country->countryCode,['class' => 'tooltipster', 'title' => $suspect->country->countryName]) !!}</td>
                                                    <td><strong>{{ $suspect->name }}</strong></td>
                                                    <td class="text-right"><strong>{{ $suspect->score }}</strong></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($match->{"game".$round->game_index."_screenshot"} != null && $match->{"game".$round->game_index."_screenshot"} != "")
                        <div class="col-xs-12">
                            <div class="" style="margin: 20px;">
                            <img class="img img-responsive img-thumbnail" style="width: 100%;height: 500px;" src="{{ $match->{"game".$round->game_index."_screenshot"} }}" alt="">
                            </div>
                        </div>
                        @endif

                    </div>
            </div>
        @empty
            <div class="col-xs-12 panel text-center">
                <h1>No Match Detail To Show</h1>
                <h3></h3>
            </div>
        @endforelse
</div>

    @if(Auth::check() && Auth::user()->canManageTournament($tournament))
        <div class="panel col-xs-12 padding10">
            {!! Form::open(['class' => 'form-horizontal']) !!}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', 'Name', ['class' => 'col-xs-4 control-label']) !!}
                <div class="col-xs-6">
                    {!! Form::text('name',null,['class' => 'form-control']) !!}
                    @if ($errors->has('name'))
                        <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
                </span>
                    @endif
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    @endif
@endsection