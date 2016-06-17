@extends('layouts.main')
@section('title', 'Create News')
@section('main-container')
    <div class="content col-md-9">
        @include('partials._errors')

        <div class="col-md-10 panel composemail" style="padding:10px">
            <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Create News</h5>

            {!! Form::open(['class' => 'form-horizontal']) !!}

            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('title', 'Title', ['class' => 'col-md-3 control-label']) !!}
                <div class="col-md-7">
                    {!! Form::text('title',null,['class' => 'form-control', 'placeholder' => 'News Title']) !!}
                    @if ($errors->has('title'))
                        <span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
                </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                {!! Form::label('text', 'Body', ['class' => 'col-md-3 control-label']) !!}
                <div class="col-md-7">
                    {!! Form::textarea('text',null,['class' => 'form-control', 'placeholder' => 'Write your news here...']) !!}
                    <span class="help-block">
                    @if ($errors->has('text'))
                            <strong>{{ $errors->first('text') }}</strong>
                            <br>
                        @endif
                        <small class="text-info">BBCode is supported.</small>
                </span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-3">
                    <button type="submit" class="btn btn-info confirm">Submit News</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
@endsection

@section('scripts')
    <script src="{{ url('/') }}/js/angular.min.js"></script>
@endsection