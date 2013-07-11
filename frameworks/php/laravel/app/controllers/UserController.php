<?php

class UserController extends BaseController {


    /**
     * Instantiate a new UserController instance.
     */
    public function __construct() {
        /*$this->beforeFilter('auth');
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->afterFilter('log', array('only' =>
            array('fooAction', 'barAction')));*/
    }

    /**
     * Show the profile for the given user.
     */
    public function getProfile($id) {
        $user = User::find($id);
        return View::make('user.profile', array('user' => $user));
    }

    /**
     * RESTful methods
     */
    public function getIndex() {
        $users = User::all();
        return View::make('user.index')->with('users', $users);
    }

    public function getCreate() {
        return View::make('user.create', array());
    }
    public function postCreate() {

        $user  = new User;
        $user->create(Input::all());
        Session::flash('message', 'User '.$user->name.' has been created');
        return Redirect::to('users')->withInput();
    }    

    public function update(){
        
    }
}