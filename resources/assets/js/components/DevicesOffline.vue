<template lang="html">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Total offline ({{totalOffline}})</div>

                    <div class="panel-body">
                        <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Protocol</th>
                                <th>IMEI</th>
                                <th>Name</th>
                                <th>Alerts</th>
                                <th>Last update</th>
                                <!--<th>Find owner</th>-->
                            </tr>
                        </thead>

                        <tbody>

                        <tr v-for="(car,index) in list">
                        <th scope="row">{{index+1}}</th>
                        <td>{{car.protocol}}</td>
                        <td>{{car.device_id}}</td>
                        <td>{{car.device_name}}</td>
                        <td>{{car.device_alerts}}</td>
                        <td>{{car.last_update_utc}}</td>
                        <!--<td><a :href="/crm/car-owner?q="> เจ้าของรถ </a></a></td>-->
                        </tr>

                        </tbody>

                        </table>
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
    	data:function () {

           return {
           	list:[],
               car:{
				   device_id:'',
				   protocol:'',
				   device_name:'',
				   last_update_utc:'',
			   },
			   totalOffline : 0,
           };
	   },
		created: function () {
			this.fetchData();
		},

		methods: {
			fetchData: function () {
				var self = this;
				// $.get('http://api.wetrustgps.com:7899/api/devices/offline', function( data ) {
				// 	self.list = data.device_offline;
				// 	self.totalOffline = data.total_offline;
				// 	console.log(data);
                // });
                
                axios
                 .get('http://api01.wetrustgps.com:7899/api/devices/offline')
                 .then(response => (this.info = response))

			}

		}

    }
</script>