<template>
    <div>
        <heading class="mb-6">Device Offline ({{totalOffline}})</heading>

        <card class="flex flex-col items-center justify-center" style="min-height: 300px">
            <table class="table w-full">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Protocol</th>
                    <th>IMEI</th>
                    <th>ทะเบียน</th>
                    <th>Alerts</th>
                    <th>Last update</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>

                <tr v-for="(car,index) in list">
                    <th class="text-center">{{index+1}}</th>
                    <td class="text-center">{{car.protocol}}</td>
                    <td class="text-center">{{car.device_id}}</td>
                    <td class="text-center">{{car.device_name}}</td>
                    <td class="text-center">{{car.device_alerts}}</td>
                    <td class="text-center">{{car.last_update_utc}}</td>
                    <td class="text-center">{{moment(car.last_update_utc).fromNow()}}</td>

                </tr>

                </tbody>

            </table>
        </card>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                list:[],
                car:{
                    device_id:'',
                    protocol:'',
                    device_name:'',
                    last_update_utc:'',
                },
                totalOffline : 0,
            }
        },
        mounted() {
            axios
                .get('/nova-vendor/device-offline')
                .then(response => {
                    this.totalOffline = response.data.total_offline;
                    this.list = response.data.device_offline;
                    console.log(response);
                });
        },
    }
</script>

<style>
    /* Scoped Styles */
</style>
