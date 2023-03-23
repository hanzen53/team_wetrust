<?php

namespace App\Admin\Controllers;

use App\DLTCar;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class DLTCarController extends Controller
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

            $content->header('DLT Car');
            $content->description('รถที่เข้าระบบ DLT');

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

            $content->header('header');
            $content->description('description');

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

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(DLTCar::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->owner_name('เจ้าของรถ')->sortable();
            $grid->ownership_name('ผู้ประกอบการ')->sortable();
            $grid->register_name('ทะเบียน')->sortable();
            $grid->register_make('ยี่ห้อ')->sortable();
            $grid->register_model('รุ่น')->sortable();
            $grid->register_chassi('เลขตัวถัง')->sortable();
            $grid->register_engine_number('เลขตัวเครื่อง')->sortable();

//            $grid->created_at();
//            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(DLTCar::class, function (Form $form) {

            $form->display('id', 'ID');

			$form->text('owner_name');
			$form->text('ownership_name');
			$form->text('register_name');
			$form->text('register_make');
			$form->text('register_model');
			$form->text('register_chassi');
			$form->text('register_engine_number');
        });
    }
}
