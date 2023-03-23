<?php

namespace App\Admin\Controllers;

use App\Server;
use App\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class UserController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Users');
            $content->description('List all user');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('User');
            $content->description('edit');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('User');
            $content->description('Create new user');

            $content->body($this->form());
        });
    }


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if ($this->form()->destroy($id)) {
			return response()->json([
				'status'  => true,
				'message' => trans('admin.delete_succeeded'),
			]);
		} else {
			return response()->json([
				'status'  => false,
				'message' => trans('admin.delete_failed'),
			]);
		}
	}

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(User::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->user_type('User Type');
            $grid->username('Username')->sortable();;
            $grid->name('Name');
            $grid->tel('Tel');
            $grid->line('Line')->sortable();;
            $grid->email('Email')->sortable();;
            $grid->created_at('Add Date')->sortable();;

			$grid->filter(function($filter){

				// Remove the default id filter
				$filter->disableIdFilter();


				$filter->where(function ($query) {

					$query->where('username', 'like', "%{$this->input}%")
						->orWhere('name', 'like', "%{$this->input}%")
						->orWhere('tel', 'like', "%{$this->input}%")
						->orWhere('line', 'like', "%{$this->input}%");

				}, 'Search');

			});

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(User::class, function (Form $form) {

            $form->display('id', 'ID');

			$form->select('user_type','User Type')->options(['v3' => 'V3','dlt'=>'DLT']);
			$form->text('username','Username');
			$form->text('name','Name');
			$form->email('email','Email');
			$form->text('tel','Tel');
			$form->text('line','Line');
			$form->password('password','Password');

			$form->select('server')->options(function ($name) {
			})->ajax('/api/servers');

        });
    }



}
