@extends('layout')

@section('content')
<h2>User profile</h2>
<?php dd($user);?>
<p>Hello <strong><?php echo $user['name'];?></strong></p>
@stop