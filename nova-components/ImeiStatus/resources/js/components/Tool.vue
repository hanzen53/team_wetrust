<template>
    <div>
        <heading class="mb-6">IMEI Status</heading>
        <div class="card overflow-hidden">
            <div class="flex border-b border-40">
                <div class="w-4/4 px-8 py-6">
                    <label class="inline-block text-80 h-9 pt-2">IMEI</label>
                    <p class="text-sm leading-normal text-80 italic"></p>
                </div>
                <div class="w-3/4 px-8 py-6">
                    <input  v-model="imei" placeholder="ใส่ IMEI ที่ต้องการตรวจสอบ" type="text" class="w-full form-control form-input form-input-bordered">
                </div>
                <div class="w-4/4 px-8 py-6">
                    <button class="ml-auto btn btn-default btn-primary mr-3" @click="fetchData()">ตรวจสอบ</button>
                </div>
            </div>

        </div>
        <hr>
        <div v-if="show" class="card overflow-hidden">
            <div class="flex border-b border-40">
                <pre class="CodeMirror-line">{{carDataAPI}}</pre>

            </div>

        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {

        data() {
            return {
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
            }
        },

        methods: {
            fetchData: function () {
                axios.defaults.xsrfHeaderName = "X-CSRFToken";
                axios.get('http://api.wetrustgps.com:7899/api/devices/show/'+this.imei)
                    .then(response => {
                        this.show = true;
                        this.carDataAPI = response.data;
                        this.lastKnown =response.data.last_know_position[0];
                        this.imei = this.imei;
                        console.log(response.data)
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })

            }
        },
        mounted() {
            //
        },
    }
</script>

<style>
    /* Scoped Styles */
</style>
