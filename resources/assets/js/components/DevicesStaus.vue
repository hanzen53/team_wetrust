<template lang="html">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">สถานะรถ</h3>
                        <!-- /.box-tools -->
                    </div>


                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-sm-10">
                                <input type="text" v-model="imei" class="form-control" id="imei" name="imei" placeholder="IMEI" @keypress.up.enter="fetchData()">
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-success pull-right form-control"
                                        @click="fetchData()">Check
                                </button>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>

                        <div v-if="show">
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="box box-success box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">IMEI</h3>
                                            <!-- /.box-tools -->
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            {{carDataAPI.device_id}}
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="box box-success box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">ทะเบียน</h3>
                                            <!-- /.box-tools -->
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            {{carDataAPI.device_name}}
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="box box-success box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">เวลาเครื่อง</h3>
                                            <!-- /.box-tools -->
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            {{device_time}}
                                        </div>
                                        <!-- /.box-body -->
                                    </div>

                                </div>
                                <div class="col-xs-3">
                                    <div class="box box-success box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">เวลา server</h3>
                                            <!-- /.box-tools -->
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            {{server_time}}
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="box box-success box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">คนขับ</h3>
                                            <!-- /.box-tools -->
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            {{driver_id}}
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="box box-success box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">สถานะ</h3>
                                            <!-- /.box-tools -->
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            {{status}}
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="box box-success box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">ตำแหน่ง</h3>
                                            <!-- /.box-tools -->
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            {{lat}},{{lon}}
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-xs-12">
                                    <div class="box box-success box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Alerts</h3>
                                            <!-- /.box-tools -->
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            {{alerts}}
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>

                            </div>


                            <div class="row">


                                <div class="col-xs-6">
                                    <div class="box box-success box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Power</h3>
                                            <!-- /.box-tools -->
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <ul>
                                                <li>Acc: {{acc}}</li>
                                                <li>ไฟนอก: {{ext_power}}</li>
                                                <li>GPS battery: {{battery}}</li>
                                                <li>ADC : {{adc1_voltage}}</li>
                                            </ul>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="box box-success box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">I/O</h3>
                                            <!-- /.box-tools -->
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <ul>
                                                <li>Input 1: {{input1}}</li>
                                                <li>Input 2: {{input2}}</li>
                                                <li>Input 3: {{input3}}</li>
                                                <li>Input 4: {{input4}}</li>
                                                <li>Output 1: {{output1}}</li>
                                                <li>Output 2: {{output2}}</li>
                                                <li>Output 3: {{output3}}</li>
                                                <li>Output 4: {{output4}}</li>

                                            </ul>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>

                            </div>




                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
	import axios from 'axios';
	import moment from 'moment';

	export default {

		data: () => ({
			show: false,
			imei: '',
			carDataAPI: [],
			lastKnown: [],
			device_time: '',
			server_time: '',
			driver_id: '',
			lat: 0,
			lon: 0,
			status: '',
            acc: 0,
			ext_power: 0,
			battery: 0,
			adc1_voltage : 0,
            input1 : 0,
            input2 : 0,
            input3 : 0,
            input4 : 0,
            output1 : 0,
			output2 : 0,
			output3 : 0,
			output4 : 0,
            alerts: ''
		}),

//		created: function () {
//			this.fetchData();
//		},

		methods: {
			fetchData: function () {

//				axios.get('http://api.wetrustgps.com:7899/api/devices/show/863835028083082')
//					.then(response => {
//						// JSON responses are automatically parsed.
//						//this.carDataAPI = response.data;
//						//this.lastKnown = last_know_position[0];
//						console.log(response.data)
//					})
//					.catch(e => {
//						this.errors.push(e)
//					})

				var self = this;
				$.get('http://api.wetrustgps.com:7899/api/devices/show/' + self.imei, function (data) {

					console.log(data);

					self.show = true;
					self.carDataAPI = data;
					self.lastKnown = data.last_know_position[0];
					self.device_time = data.last_know_position[0].utc_ts;
					self.server_time = data.last_know_position[0].recv_utc_ts;
					self.driver_id = data.last_know_position[0].driver_id;
					self.lat = data.last_know_position[0].lat;
					self.lon = data.last_know_position[0].lon;
					self.status = data.last_know_position[0].status;
					self.acc = data.last_know_position[0].acc;
					self.ext_power = data.last_know_position[0].ext_power;
					self.battery = data.last_know_position[0].battery_analog;
					self.adc1_voltage = data.last_know_position[0].adc1_voltage;
					self.input1 = data.last_know_position[0].input_1;
					self.input2 = data.last_know_position[0].input_2;
					self.input3 = data.last_know_position[0].input_3;
					self.input4 = data.last_know_position[0].input_4;
					self.output1 = data.last_know_position[0].output_1;
					self.output2 = data.last_know_position[0].output_2;
					self.output3 = data.last_know_position[0].output_3;
					self.output4 = data.last_know_position[0].output_4;
					self.alerts = JSON.parse(data.last_know_position[0].alerts);
				});
			}
		}
	}
</script>