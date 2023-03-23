<template>
    <div>
        <heading class="mb-6">All DLT Master File ({{masterFileCount}})</heading>

        <card class="flex flex-col items-center justify-center" style="min-height: 300px">


            <table class="table w-full">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Unit ID</th>
                    <th>หมายเลขตัวถัง</th>
                    <th>หมายเลขทะเบียน</th>
                    <th>ยี่ห้อรถยนต์</th>
                    <th>ลักษณะรถและประเภทการขนส่ง</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(car,index) in masterFileData">
                    <td class="text-center"> {{index+1}}</td>
                    <td class="text-center"> {{car.unit_id}}</td>
                    <td class="text-center"> {{car.vehicle_chassis_no}}</td>
                    <td class="text-center"> {{car.vehicle_id}}</td>
                    <td class="text-center"> {{car.vehicle_register_type}}</td>
                    <td class="text-center"> {{car.vehicle_type}}</td>
                </tr>
                </tbody>
            </table>


        </card>
    </div>
</template>

<script>
    import axios from 'axios';
    import moment from 'moment';
    export default {

        data() {
            return {
                masterFileCount: 0,
                masterFileData : [],
                errors: []
            }
        },
        mounted () {

            //const headers = {"Authorization": "Basic d2VnbG9iYWw6NzRyakg0aFJaU3JI"};

            axios
                .get('https://gpsservice.dlt.go.th/masterfile/getList/0/5000',{ headers: {"Authorization": "Basic d2VnbG9iYWw6NzRyakg0aFJaU3JI"} })
                .then(response => {
                    this.masterFileData = response.data.results;
                    this.masterFileCount = response.data.count;
                    console.log(this.masterFileData);
                    console.log(response.data.count);
            });
        }

    }
</script>

<style>
    /* Scoped Styles */
</style>
