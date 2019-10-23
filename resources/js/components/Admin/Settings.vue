<template>
    <v-app light>
        <v-row>
            <nav-drawer-admin></nav-drawer-admin>
            <v-row>
                <v-col cols="10" offset="1" class="content_wrap">
                    <v-row>
                        <v-col cols="12">
                            <div class="title">
                                Settings
                            </div>
                        </v-col>
                    </v-row>
                    <v-divider></v-divider>
                    <v-row>
                        <v-col cols="12">
                            <v-btn color="#ff3c38" dark raised rounded ripple @click.prevent="$router.go(-1)"><v-icon left>arrow_left</v-icon>Back</v-btn>
                        </v-col>
                        <v-col cols="12" md="8">
                            <v-progress-circular v-if="isLoading" indeterminate color="orange" :width="5" :size="50" class="justify-center align-center"></v-progress-circular>
                            <v-card v-else light elevation="12" raised min-height="500" class="pa-3">
                                <v-card-title class="justify-center" v-if="admin">
                                    <div class="subtitle-1">Admin Profile </div>
                                </v-card-title>
                                <v-simple-table v-if="admin">
                                    <tr>
                                        <th>Name:</th>
                                        <td>{{ admin.name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ admin.email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Role:</th>
                                        <td>{{ admin.role }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created Date:</th>
                                        <td>{{ admin.created_date }}</td>
                                    </tr>
                                </v-simple-table>
                                <v-card-actions class="justify-center">
                                    <v-btn dark color="primary" @click.prevent="openPswdDialog = true">Change Password</v-btn>
                                    <v-btn dark color="orange darken-2">Disable Account</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
            <v-dialog max-width="450" v-model="openPswdDialog">
                <v-card>
                    <v-card-title class="subtitle-1 justify-center"> Change Account Password</v-card-title>
                        <!-- <div v-if="!currentPswdCheck" class="alert alert-danger mt-1 mb-4 ml-3 mr-3">{{ currentError }}</div> -->
                    <v-card-text>
                        <v-text-field type="password" label="Current Password" v-model="password.current" required @blur="confirmCurrentPswd" v-validate="'required'" :error-messages="currentError"></v-text-field>
                        <v-text-field type="password" label="New Password" v-model="password.new" ref="password" required v-validate="'required|min:5|max:30'" :error-messages="errors.collect('password')" data-vv-name="password"></v-text-field>
                        <v-text-field type="password" label="Confirm New Password" v-model="password.confirm" required v-validate="'required|confirmed:password'" :error-messages="errors.collect('confirm')" data-vv-name="confirm" data-vv-as="password"></v-text-field>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text color="#ff3c38" @click.prevent="closePswdDialog"> Cancel </v-btn>
                        <v-btn color="primary" dark :loading="isLoading" @click="updatePswd">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <v-snackbar :timeout="4000" top color="#43A047" v-model="pswdUpdateSuccess">
                Account password has been updated!
                <v-btn color="green darken-3" @click.prevent="pswdUpdateSuccess = false">Close</v-btn>
            </v-snackbar>
        </v-row>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            admin: null,
            isLoading: false,
            openPswdDialog: false,
            password: {
                current: '',
                new: '',
                confirm: ''
            },
            currentError: null,
            currentPswdCheck: false,
            confirmNewError: 'Password and Password confirm does not match!'
        }
    },
    methods: {
        getProfile(){
            this.isLoading = true
            axios.get(`/admin_get_profile`).then((res) => {
                this.isLoading = false
                this.admin = res.data
                console.log(res.data)
            })
        },
        confirmCurrentPswd(){
            if(this.password.current !== ''){
                this.currentError = null
                axios.post('/admin_confirm_current_pswd', {
                    pswd: this.password.current
                }).then((res) => {
                    if(res.data === false){
                        this.currentError = 'Kindly enter your correct password.'
                    }
                })
            }
        },
        updatePswd(){
            this.$validator.validateAll('pswd').then((isValid) =>{
                if(isValid && this.currentError === null){
                    if(this.password.current !== ''){
                        this.isLoading = true
                        axios.post('/admin_update_admin_pswd', {
                            current: this.password.current,
                            password: this.password.new,
                            password_confirmation: this.password.confirm
                        }).then((res) => {
                            this.closePswdDialog()
                            this.pswdUpdateSuccess = true
                            this.isLoading = false
                        }).catch((err) => {
                            this.isLoading = false
                        })
                    }else{
                        this.currentError = 'Current Password field required'
                    }
                }
            })
        },
        closePswdDialog(){
            this.$validator.reset()
            this.openPswdDialog = false
            this.password.new = ''
            this.password.confirm = ''
        }
    },
    mounted() {
        this.getProfile()
    },
}
</script>

<style lang="scss" scoped>
    @media screen and(max-width: 700px){
        .content_wrap{
            margin-left: 6rem !important;
        }
    }

    .v-progress-circular{
        justify-content: center !important;
        align-items: center !important;
        // top: 30% !important;
        left: 50%;
        margin-top: 5rem;
    }
    table th, table td{
        font-size: 90% !important;
    }
    .v-card .history{
        overflow-x: scroll !important;
    }
</style>
