<template>
    <div>
        <form @submit.prevent="submit" ref="formContainer" class="gy-3 form-settings vld-parent"
            @keydown="form.onKeydown($event)">

            <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bolder">Current Password</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" placeholder="Current Password" v-model="form.name">
                    <HasError :form="form" field="phone" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bolder">New Password</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" v-model="form.phone" placeholder="New Password">
                    <HasError :form="form" field="phone" />
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bolder">Confirm Password</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" v-model="form.email" placeholder="Confirm Password">
                    <HasError :form="form" field="email" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label"></label>
                <div class="col-sm-9">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>

    </div>
</template>
  
<script>
import Form from 'vform'
import {
    Button,
    HasError,
    AlertError
} from 'vform/src/components/bootstrap5'


export default {
    components: {
        Button,
        HasError,
        AlertError
    },
    data: () => ({

        form: new Form({
            name: '',
            email: '',
            phone: '',
        })
    }),
    methods: {
        //   submit() {

        //     let loader = this.$loading.show({
        //       container: this.$refs.formContainer,
        //     });

        //     this.form.post(this.route('api.admin.profile.personal-info'))
        //       .then(({
        //         data
        //       }) => {
        //         loader.hide()
        //         this.$toast.open('Operation Successful');
        //         // this.form = data.data
        //       })
        //       .catch((error) => {
        //         loader.hide()
        //       });
        //   },

        //   getProfile() {
        //     axios.get(this.route("api.admin.profile.user"))
        //       .then(response => {

        //         this.form.surname = response.data.data.surname
        //         this.form.other_names = response.data.data.other_names
        //         this.form.email = response.data.data.email
        //         this.form.phone = response.data.data.phone



        //         this.form.user_id = response.data.data.user_id


        //         this.user = response.data.data

        //       })
        //       .catch(error => {

        //       });


        //   },
    },
    created() {
        this.getProfile()
    },

}

</script>
  