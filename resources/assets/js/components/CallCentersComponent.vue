<template>
    <div class="row" id="CallCenters">
        <div>
            <b-alert :show="dismissCountDown"
                    dismissible
                    :variant="myVariant"
                    @dismissed="dismissCountDown=0"
                    @dismiss-count-down="countDownChanged">
            {{ alertMessage }}
            </b-alert>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>CallCenter</th>
                    <th>E-Mail</th>
                    <th>Password</th>
                    <th><b-btn class="btn-success btn-sm" v-b-modal.modal1 >Add New CallCenter</b-btn></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>CallCenter</th>
                    <th>E-Mail</th>
                    <th>Password</th>
                    <th></th>
                </tr>
            </tfoot>
            <tbody>
                <tr v-for="(item, index) in items" :key="item.id">
                    <td>{{ item.name }}</td>
                    <td>{{ item.username }}</td>
                    <td>{{ item.username.split('@',2)[1] }}</td>
                    <td>{{ item.email }}</td>
                    <td class="input-group input-group-sm">
                        <input class="form-control" type="password" name="password" placeholder="Change Password" v-model="item.newPassword" />
                        <button class="btn btn-dark btn-sm" v-on:click="updatePassword(index, item.newPassword)">Update</button>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm" v-on:click="deleteUser(index)">Delete</button>
                        <!-- <button class="btn btn-warning btn-sm">Suspend</button> -->
                    </td>
                </tr>
            </tbody>
        </table>
        <b-modal id="modal1" title="Add New CallCenter" @ok="saveData">
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" value="" v-model="newCallCenter.name" placeholder="Name" required autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>
                <div class="col-md-6">
                    <input id="username" type="text" class="form-control" name="username" value="" v-model="newCallCenter.username" placeholder="Username" required autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" v-model="newCallCenter.password" value="" placeholder="Password" required autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>
                <div class="col-md-6">
                    <input id="email" type="text" class="form-control" name="email" value="" v-model="newCallCenter.email" placeholder="E-Mail" required autofocus>
                </div>
            </div>
        </b-modal>
    </div>
</template>

<script>
    export default {
        data: function() {
            return  {
                items: [],
                dismissSecs: 3,
                dismissCountDown: 0,
                alertMessage: 'Hello World',
                myVariant: 'warning',
                newCallCenter: { }
            }
        },
        props: ['apitoken'],
        mounted () {
            this.getUsers()
        },
        methods: {
            getUsers(){
                axios
                .post('/api/admin/callcenters')
                .then(response => (this.items = response.data.users))
            },
            updatePassword: function(index, newPassword){
                var self = this;
                let item = this.items[index];
                axios
                    .post( 
                        '/api/admin/callcenters/password', { id: item.id, password: newPassword }
                    )
                    .then(function (response) {
                        item.newPassword = '',
                        self.showAlert(response.data.alert, response.data.status)
                    })
            },
            deleteUser: function(index){
                var self = this;
                let item = this.items[index];
                console.log(item)
                axios
                    .post( 
                        '/api/admin/callcenters/delete', { id: item.id }
                    )
                    .then(function (response) {
                        self.showAlert(response.data.alert, response.data.status)
                        if(response.data.alert == 'success'){
                            self.getUsers()
                        }
                    })
            },
            countDownChanged (dismissCountDown) {
                this.dismissCountDown = dismissCountDown
            },
            showAlert (variant, text) {
                this.myVariant = variant
                this.alertMessage = text
                this.dismissCountDown = this.dismissSecs
            },
            saveData() {
                var self = this;
                axios.post(
                    '/api/admin/callcenters/add', this.newCallCenter )
                    .then(function (response){
                        self.showAlert(response.data.alert, response.data.status)
                        self.getUsers()
                        self.newCallCenter = {}
                    })
            }
        }
    }
</script>
