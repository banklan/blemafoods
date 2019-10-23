<template>
    <v-app light>
        <nav-drawer-admin></nav-drawer-admin>
        <v-container>
            <v-row>
                <v-col cols="10" offset="1" md="4" offset-md="1">
                    <div v-if="user" class="title ml-8">Users Management - <span class="subtitle-1"><strong>{{ user.name }}</strong></span></div>
                </v-col>
            </v-row>
            <v-divider></v-divider>
            <v-row>
                <v-col cols="10" offset="1">
                    <div class="ml-8">
                        <v-btn color="#ff3c38" dark raised rounded ripple @click.prevent="$router.go(-1)"><v-icon left>arrow_left</v-icon>Back</v-btn>
                    </div>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="10" offset="1" md="5">
                    <div class="user_wrap">
                        <v-card v-if="!editUser" light raised elevation="14" min-height="400" class="pa-4">
                            <v-progress-circular v-if="!user" indeterminate color="#ff3c38" :width="5" :size="30" class="justify-center align-center"></v-progress-circular>
                            <v-simple-table v-else min-height="350">
                                <template v-slot:default>
                                    <tr>
                                        <th>Name:</th>
                                        <td>{{ user.name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ user.email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td>{{ user.phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alternate Phone:</th>
                                        <td>{{ user.alt_phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address:</th>
                                        <td>{{ user.address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Location:</th>
                                        <td>{{ user.location && user.location.name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Area Code:</th>
                                        <td>{{ user.area_code }}</td>
                                    </tr>
                                    <tr>
                                        <th>Account Status:</th>
                                        <td>{{ user.user_status }}</td>
                                    </tr>
                                    <tr>
                                        <th>Member Since:</th>
                                        <td>{{ user.join_date }}</td>
                                    </tr>
                                </template>
                            </v-simple-table>
                            <v-card-actions v-if="user" class="my-4 justify-center">
                                <v-btn dark color="#03a209" class="ml-4" @click.prevent="modifyUser">Edit User</v-btn>
                                <v-btn v-if="user.status == 1" dark color="orange" class="ml-4" @click.prevent="openStatusDialog('disable')">Disable</v-btn>
                                <v-btn v-if="user.status != 1" dark color="#214ef3" class="ml-4" @click.prevent="openStatusDialog('enable')">Enable</v-btn>
                            </v-card-actions>
                        </v-card>
                        <v-card v-if="editUser" light raised elevation="14" min-height="400" class="pa-4">
                            <v-card-title class="justify-center">
                                <div class="subtitle-1">Update User</div>
                            </v-card-title>
                            <v-card-text>
                                <v-text-field label="Name" v-model="editData.name" required :counter="60" v-validate="'required|max:60'" :error-messages="errors.collect('name')" data-vv-name="name"></v-text-field>
                                <v-text-field label="Email" v-model="editData.email" disabled v-validate="'required|email'" :error-messages="errors.collect('email')" data-vv-name="email"></v-text-field>
                                <v-text-field label="Phone" v-model="editData.phone" required v-validate="'required|numeric'" :error-messages="errors.collect('phone')" data-vv-name="phone"></v-text-field>
                                <v-text-field label="Alternate Phone" v-model="editData.alt_phone" v-validate="'numeric'" :error-messages="errors.collect('alt_phone')" data-vv-name="alt_phone"></v-text-field>
                                <v-text-field label="Address" v-model="editData.address" required :counter="120" v-validate="'required|max:120'" :error-messages="errors.collect('address')" data-vv-name="address"></v-text-field>
                                <v-select label="Location" v-model="editData.location_id" :items="locations" item-text="name" item-value="id" v-validate="'required'" :error-messages="errors.collect('location')" data-vv-name="location"></v-select>
                            </v-card-text>
                            <v-card-actions>
                                <v-btn text color="#ff3c38" @click.prevent="editUser = false">Cancel</v-btn>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" @click.prevent="updateUser" :loading="isSaving" class="px-10">Save</v-btn>
                            </v-card-actions>
                        </v-card>
                    </div>
                </v-col>
                <v-col cols="10" offset="1" md="5">
                    <div class="user_order">
                        <v-card light raised elevation="14" min-height="400" class="pa-4">
                            <v-progress-circular v-if="ordersLoading" indeterminate color="#ff3c38" :width="5" :size="30" class="justify-center align-center"></v-progress-circular>
                            <div v-else>
                                <div class="subtitle-1 text-center">Last 3 Order History</div>
                                <v-divider></v-divider>
                                <div v-if="orders.length == 0">
                                    <div class="subtitle-2">
                                        There are is no order history for this customer
                                    </div>
                                </div>
                                <div v-else>
                                    <v-simple-table min-height="350">
                                        <template v-slot:default>
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Order No</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="order in orders" :key="order.id">
                                                    <td>{{ order.date }}</td>
                                                    <td>{{ order.order_id }}</td>
                                                    <td><v-btn text small dark color="blue lighten-1" :to="{name: 'AdminOrder', params: {id: order.id, order: order.order_id}}"><v-icon>visibility</v-icon></v-btn></td>
                                                </tr>
                                            </tbody>
                                        </template>
                                    </v-simple-table>
                                    <v-divider></v-divider>
                                    <div class="other_details mt-8" v-if="user">
                                        <div class="subtitle-1 text-center">{{ user.name }} activities</div>
                                        <v-divider></v-divider>
                                        <v-simple-table>
                                            <template v-slot:default>
                                                <tr>
                                                    <th>No of Orders: </th>
                                                    <td v-if="count">{{ count }}</td>
                                                    <td><v-btn text color="primary" :to="{name: 'AdminUserOrders', params: {user: user.id, slug: user.slug}}">All Orders</v-btn></td>
                                                </tr>
                                                <tr>
                                                    <th>No of Special Orders: </th>
                                                    <td v-if="specialCount">{{ specialCount }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Last login: </th>
                                                    <td>12/09/2019</td>
                                                </tr>
                                            </template>
                                        </v-simple-table>
                                    </div>
                                </div>
                            </div>
                        </v-card>
                    </div>
                </v-col>
                <v-col cols="10" offset="1" md="5" class="mb-6">
                    <div class="user_wrap">
                        <v-card light min-height="100" class="py-6">
                            <v-card-title class="justify-center">
                                <div class="subtitle-1">Manage Users Account</div>
                            </v-card-title>
                            <v-divider></v-divider>
                            <v-card-actions class="justify-center">
                                <v-btn dark color="#a00a8e" class="ml-4" @click.prevent="resetDialog = true">Reset Password</v-btn>
                                <v-btn dark color="red" class="ml-4" @click.prevent="delDialog = true">Delete Account</v-btn>
                            </v-card-actions>
                        </v-card>
                    </div>
                </v-col>
                <v-dialog v-model="delDialog" max-width="350">
                    <v-card>
                        <v-card-title class="subtitle-1 justify-center">Are you sure you want to delete this user?</v-card-title>
                        <v-card-text>
                            <div class="subtitle-2 red--text">
                                Once deleted the account cannot be recovered.
                            </div>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text color="#ff3c38" @click.prevent="delDialog = false"> Cancel </v-btn>
                            <v-btn color="#ff3c38" dark @click.prevent="delAccount">Delete User</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <v-dialog v-model="statusDialog" max-width="350">
                    <v-card>
                        <v-card-title class="subtitle-1 justify-center">Do you want to {{ statusAction }} this user?</v-card-title>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text color="#ff3c38" @click.prevent="statusDialog = false"> Cancel </v-btn>
                            <v-btn color="#ff3c38" dark @click.prevent="changeStatus">{{ statusAction }} User</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <v-dialog v-model="resetDialog" max-width="350">
                    <v-card>
                        <v-card-title v-if="user" class="subtitle-1 justify-center">Reset Password for {{ user.name }}</v-card-title>
                        <v-card-text>
                            <v-text-field type="password" label="New Password" v-model="reset.password"></v-text-field>
                            <v-text-field type="password" label="Confirm Password" v-model="reset.conf"></v-text-field>
                        </v-card-text>
                        <div v-if="pswdError" class="px-4">
                            <div class="alert alert-danger">{{ pswdError }}</div>
                        </div>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text color="#ff3c38" @click.prevent="cancelReset"> Cancel </v-btn>
                            <v-btn color="#ff3c38" dark @click.prevent="resetPassword">Save Password</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <v-snackbar v-model="editSuccess" :timeout="4000" top color="#44a80f">
                    User has been updated successfully!
                    <v-btn color="white green--text" text @click.prevent="editSuccess = false">Close</v-btn>
                </v-snackbar>
                <v-snackbar v-model="resetSuccess" :timeout="4000" top color="#44a80f">
                    User password has been reset!
                    <v-btn color="white green--text" text @click.prevent="resetSuccess = false">Close</v-btn>
                </v-snackbar>
            </v-row>
        </v-container>
    </v-app>
</template>

<script>
export default {
    data(){
        return{
            id: this.$route.params.user,
            user: null,
            orders: [],
            ordersLoading: false,
            count: null,
            specialCount: null,
            editUser: false,
            editData: {
                name: '',
                email: '',
                phone: '',
                alt_phone: '',
                address: '',
                location_id: ''
            },
            locations: [],
            isSaving: false,
            editSuccess: false,
            statusDialog: false,
            statusAction: '',
            resetDialog: false,
            reset: {
                password: '',
                conf: ''
            },
            pswdError: null,
            resetSuccess: false,
            delDialog: false
        }
    },
    methods:{
        getUser(){
            axios.get(`/admin_get_user/${this.$route.params.user}`).then((res) => {
                this.user = res.data
            })
        },
        getUsersOrders(){
            this.ordersLoading = true
            axios.get(`/admin_get_users_order_history/${this.$route.params.user}`).then((res)=>{
                this.ordersLoading = false
                this.orders = res.data
            })
        },
        getOrdersCount(){
            axios.get(`/admin_get_users_orders_count/${this.$route.params.user}`).then((res) => {
                this.count = res.data
            })
        },
        getSpecialOrdersCount(){
            axios.get(`/admin_get_users_special_orders_count/${this.$route.params.user}`).then((res) => {
                this.specialCount = res.data
            })
        },
        getLocations(){
            axios.get('/admin_getAllLocations').then((res)=>{
                this.locations = res.data
            })
        },
        modifyUser(){
            this.editUser = true
            this.editData.name = this.user.name
            this.editData.email = this.user.email
            this.editData.phone = this.user.phone
            this.editData.alt_phone = this.user.alt_phone
            this.editData.address = this.user.address
            this.editData.location_id = this.user.location_id
        },
        updateUser(){
             this.$validator.validateAll().then((isValid) =>{
                if(isValid){
                    this.isSaving = true
                    axios.post(`/admin_update_user/${this.$route.params.user}`, {
                        user: this.editData
                    }).then((res) => {
                        this.isSaving = false
                        this.editUser = false
                        this.editSuccess = true
                        this.user = res.data
                    })
                }
             })
        },
        openStatusDialog(action){
            this.statusDialog = true
            this.statusAction = action
            console.log(action)
        },
        changeStatus(){
            axios.post(`/admin_change_users_status/${this.$route.params.user}`, {
                status: this.user.status
            }).then((res) => {
                this.user.status = res.data
                this.statusDialog = false
            })
        },
        resetPassword(){
            if(this.reset.password != '' && this.reset.conf !=''){
                if(this.reset.password === this.reset.conf){
                    axios.post(`/admin_reset_users_password/${this.$route.params.user}`, {
                        password: this.reset.password
                    }).then((res) => {
                        console.log(res.data)
                        this.cancelReset()
                        this.resetSuccess = true
                    })
                }else{
                    this.pswdError = "Password & Password confirm do not match"
                }
            }else{
                this.pswdError = "Password & Password confirm fields are required"
            }
        },
        cancelReset(){
            this.resetDialog = false;
            this.reset.password = ''
            this.reset.conf = ''
            this.pswdError = null
        },
        delAccount(){
            axios.post(`/admin_delete_user/${this.$route.params.user}`).then((res)=>{
                console.log(res.data)

                this.$router.push({name: 'AdminUsers'})
            })
        }
    },
    mounted() {
        this.getUser()
        this.getUsersOrders()
        this.getOrdersCount()
        this.getSpecialOrdersCount()
        this.getLocations()
    },
}
</script>

<style lang="scss" scoped>
    @media screen and(max-width: 620px){
        .user_wrap, .user_order{
            margin-left: 40px;
            width: 100%;
        }
    }
    @media screen and(min-width: 960px){
        .user_order{
            margin-left: -40px;
        }
    }
</style>

