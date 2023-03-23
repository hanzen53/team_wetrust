<?php

namespace App\Admin\Controllers;

use App\Device;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class DeviceController extends Controller
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

            $content->header('Devices');
            $content->description('List all devices');

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
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$device = Device::find($id);
		$device->is_delete = 1;

		$unit_id = $device->uniqueId;

		if ($device->save()) {

			$data = array("is_deleted" => 1);
			$data_string = json_encode($data);

			$ch = curl_init('http://api.wetrustgps.com:7899/api/devices/mark-delete/'.$unit_id);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($data_string))
			);

			$result = curl_exec($ch);

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
        return Admin::grid(Device::class, function (Grid $grid) {

			$grid->model()->where('is_delete', '=', 0);

            $grid->id('ID')->sortable();

            $grid->name('ทะเบียน')->sortable();
            $grid->uniqueId('IMEI')->sortable();
            $grid->gps_model('GPS รุ่น')->sortable();
            $grid->chassis_no('เลขตัวถัง')->sortable();
            $grid->sim_carrie('ค่าย SIM')->sortable();
            $grid->sim_type('ชนิด SIM')->sortable();
            $grid->sim_phone_no('เบอร์')->sortable();
            $grid->speed_limit('จำกัดความเร็ว');
            $grid->install_date('วันที่ติดตั้ง')->sortable();
            $grid->next_billing('รอบบิลถัดไป')->sortable();
            $grid->server('server')->sortable();



			$grid->filter(function($filter){

				// Remove the default id filter
				//$filter->disableIdFilter();


				$filter->where(function ($query) {

					$query->where('name', 'like', "%{$this->input}%")
						->orWhere('uniqueId', 'like', "%{$this->input}%")
						->orWhere('sim_phone_no', 'like', "%{$this->input}%");

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
        return Admin::form(Device::class, function (Form $form) {

            $form->display('id', 'ID');

			$form->select('server')->options(function ($name) {
			})->ajax('/api/servers');
        });
    }
}
