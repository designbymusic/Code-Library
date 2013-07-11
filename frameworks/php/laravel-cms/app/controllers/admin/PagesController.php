<?php namespace App\Controllers\Admin;
 
use App\Models\Page;
use Input, Notification, Redirect, Sentry, Str;
 
class PagesController extends \BaseController {
 
    public function index()
    {
        return \View::make('admin.pages.index')->with('pages', Page::all());
    }
 
    public function show($id)
    {
        return \View::make('admin.pages.show')->with('page', Page::find($id));
    }
 
    public function create()
    {
        return \View::make('admin.pages.create');
    }
	 public function store(){
	    $page = new Page;
	    $page->title   = Input::get('title');
	    $page->slug    = Str::slug(Input::get('title'));
	    $page->body    = Input::get('body');
	    $page->user_id = Sentry::getUser()->id;
	    $page->save();
	 
	    return Redirect::route('admin.pages.edit', $page->id);
	}
 
    public function edit($id)
    {
        return \View::make('admin.pages.edit')->with('page', Page::find($id));
    }
 
public function update($id)
{
    $page = Page::find($id);
    $page->title   = Input::get('title');
    $page->slug    = Str::slug(Input::get('title'));
    $page->body    = Input::get('body');
    $page->user_id = Sentry::getUser()->id;
    $page->save();
 
    Notification::success('The page was saved.');
 
    return Redirect::route('admin.pages.edit', $page->id);
}
 
	public function destroy($id){
	    $page = Page::find($id);
	    $page->delete();
	 
	    return Redirect::route('admin.pages.index');
	}
 
}