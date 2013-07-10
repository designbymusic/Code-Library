@extends('layout')

@section('content')
<h2>User profile</h2>

<p>Hello <strong><?php echo $user['name'];?></strong></p>
<?php echo Form::model($user, array('url' => array('user/update', $user['id'])));?>

<?php echo Form::text('name');?>
<?php echo Form::text('email');?>
<?php echo Form::submit('Submit');?>
{{ Form::close() }}
@stop