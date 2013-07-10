<?php
//
class FooController extends BaseController {

    public function test($id){
        return View::make('foo', array('user' => 'FooYoo'));
    }

}