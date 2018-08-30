<template>
    <div class="row" id="CallCenters">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>CallCenter</th>
                    <th>E-Mail</th>
                    <th>Password</th>
                    <th></th>
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
                <tr v-for="item in items">
                    <td>{{ item.name }}</td>
                    <td>{{ item.username }}</td>
                    <td>{{ item.username.split('@',2)[1] }}</td>
                    <td>{{ item.email }}</td>
                    <td class="input-group input-group-sm">
                        <input class="form-control" type="text" name="password" id="password" placeholder="Change Password" v-model="newPassword" />
                        <button class="btn btn-info btn-sm" v-on:click="updatePassword(item.id)">Update</button>
                    </td>
                    <td><button class="btn btn-danger btn-sm">Delete</button><button class="btn btn-warning btn-sm">Suspend</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data: function() {
            return  {
                items: [
                    {
                        id: 1,
                        name: 'Petrit Berisha',
                        username: 'pberisha@ADMIN',
                        domain: 'ADMIN',
                        email: 'pberisha@led-con.com',
                    }
                ],
                newPassword: null,
            }
        },
        props: ['apitoken'],
        mounted () {
            axios
            .post('/api/admin/callcenters', { 'api-token': this.apitoken })
            .then(response => (this.items = response.data.users))
        },
        methods: {
            updatePassword: function(id, event){
                alert('testing: ' + id);
            },
        }
    }
</script>
