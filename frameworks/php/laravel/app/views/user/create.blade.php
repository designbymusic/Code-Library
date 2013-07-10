@extends('layout')

@section('content')
<p>{{ HTML::link('users', 'Back to list'); }}</p>
<h2>Users</h2>

<h3>Create a new user</h3>
{{ Form::open(array('action' => 'UserController@getCreate')) }}
<fieldset>
    <p><?php echo Form::label('name', 'Name');?> <?php echo Form::text('name');?></p>
    <p><?php echo Form::label('email', 'E-Mail Address');?> <?php echo Form::text('email');?></p>

</fieldset>


<?php echo Form::submit('Save');?>

{{ Form::close() }}
@stop