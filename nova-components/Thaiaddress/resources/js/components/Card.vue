<template>
    <card class="flex flex-col items-center justify-center">
        <div class="px-3 py-3">
            <h1 class="text-center text-3xl text-80 font-light">Thaiaddress</h1>
            <ThailandAutoComplete v-model="district" type="district" @select="select" label="ตำบล" size="small" placeholder="ตำบล..."/>
      <ThailandAutoComplete v-model="amphoe" type="amphoe" @select="select" label="อำเภอ" color="#42b883" placeholder="อำเภอ..."/>
      <ThailandAutoComplete v-model="province" type="province" @select="select" label="จังหวัด" size="medium" color="#35495e" placeholder="จังหวัด..."/>
      <ThailandAutoComplete v-model="zipcode" type="zipcode" @select="select" label="รหัสไปรษณีย์" size="large" color="#00a4e4" placeholder="รหัสไปรษณีย์..."/>
        </div>
    </card>
</template>

<script>
import ThailandAutoComplete from 'vue-thailand-address-autocomplete'

export default {
    data () {
        return {
          district: '',
          amphoe: '',
          province: '',
          zipcode: ''
        }
      },

    props: [
        'card',

        // The following props are only available on resource detail cards...
        // 'resource',
        // 'resourceId',
        // 'resourceName',
    ],

    components: {
        ThailandAutoComplete
    },

    mounted() {
        //
    },
    methods: {
        select (address) {
          this.district = address.district
          this.amphoe = address.amphoe
          this.province = address.province
          this.zipcode = address.zipcode
        }
      }
}
</script>
