@extends('admin._layouts.default')
 
@section('main')
 
    <h2>Edit page &raquo; {{ $page->title }}</h2>
    {{ Notification::showAll() }}
    @if($errors->has())
        @foreach ($errors->all() as $error)
            <div class="alert error">{{ $error }}</div>
        @endforeach
    @endif    
    {{ Form::model($page, array('method' => 'put', 'route' => array('admin.pages.update', $page->id))) }}
 
        <div class="control-group">
            {{ Form::label('title', 'Title') }}
            <div class="controls">
                {{ Form::text('title') }}
            </div>
        </div>
 
        <div class="control-group">
            {{ Form::label('body', 'Content') }}
            <div class="controls">
                {{ Form::textarea('body') }}
            </div>
        </div>
 
        <div class="form-actions">
            {{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
            <a href="{{ URL::route('admin.pages.index') }}" class="btn btn-large">Cancel</a>
        </div>
 
    {{ Form::close() }}
 
@stop