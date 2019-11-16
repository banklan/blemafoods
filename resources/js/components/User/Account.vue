<template>
    <v-app light>
        <v-row>
            <nav-drawer-user></nav-drawer-user>
            <v-col cols="10" offset="1">
                <v-row>
                    <v-col cols="10" offset="1">
                        <div class="title ml-4 page_title">My Account</div>
                    </v-col>
                </v-row>
                <v-divider></v-divider>
                <v-row class="ml-5">
                    <v-col cols="12">
                        <v-card min-height="400" elevation="12" class="ml-5 mb-4 pa-5 main_wrap">
                            <v-container grid-list-xs>
                                <v-row>
                                    <v-col cols="12" sm="6" v-if="!editProfile">
                                        <div class="subtitle-1 mx-4 mb-4"><strong>User Information</strong></div>
                                        <span v-if="user">
                                            <v-simple-table light min-height="350" class="mb-4">
                                                <tr>
                                                    <th>Name: </th>
                                                    <td>{{ user.name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Email: </th>
                                                    <td>{{ user.email }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Phone: </th>
                                                    <td>{{ user.phone }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Alternate Phone: </th>
                                                    <td>{{ user.alt_phone }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Address: </th>
                                                    <td>{{ user.address }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Location: </th>
                                                    <td>{{ user.location && user.location.name }}</td>
                                                </tr>
                                            </v-simple-table>
                                            <v-btn fab color="#ff383c" dark class="my-5" @click.prevent="modifyAccount"><v-icon>edit</v-icon></v-btn>
                                        </span>
                                        <v-progress-circular v-else class="justify-center" indeterminate color="#ff383c" :width="5" :size="50"></v-progress-circular>
                                    </v-col>
                                    <v-col v-if="editProfile" cols="12" sm="6">
                                        <div class="subtitle-1 mx-4 mb-4"><strong>Edit User Information</strong></div>
                                        <div v-if="user" class="ml-4">
                                            <v-text-field label="Name" v-model="edit.name" required :counter="60" v-validate="'required|max:60'" :error-messages="errors.collect('name')" data-vv-name="name"></v-text-field>
                                            <v-text-field label="Phone Number" v-model="edit.phone" required v-validate="'required|numeric'" :error-messages="errors.collect('phone')" data-vv-name="phone"></v-text-field>
                                            <v-text-field label="Alternate Phone Number" v-model="edit.alt_phone" v-validate="'numeric'" :error-messages="errors.collect('alt_phone')" data-vv-name="alt_phone"></v-text-field>
                                            <v-textarea outlined no-resize auto-grow rows="2" label="Address" v-model="edit.address" required :counter="100" v-validate="'required|max:100'" :error-messages="errors.collect('address')" data-vv-name="address"></v-textarea>
                                            <v-text-field label="Location" readonly v-model="edit.location"></v-text-field>
                                            <v-select :items="locations" item-text="name" item-value="id" label="Change Location" v-model="edit.location_id" v-validate="edit.location_id == null ? 'required' : ''" :error-messages="errors.collect('location')" data-vv-name="location"></v-select>
                                            <div class="my-5">
                                                <v-btn class="px-5" raised elevation="12" rounded large dark color="#ff383c" :loading="updating" @click.prevent="update">Save Updates</v-btn>
                                                <v-btn text color="#ff383c" @click="editProfile = false">Cancel</v-btn>
                                            </div>
                                        </div>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card>
                        <v-card min-height="300" elevation="12" class="ml-5 pa-5 main_wrap">
                            <div class="subtitle-1 mt-5 mx-5"><strong>Change Profile Password</strong></div>
                           <v-card-text>
                               <v-row>
                                   <v-col cols="12" sm="5" class="ml-3">
                                        <v-text-field label="Old Password" type="password" v-model="oldPswd" @blur="checkOldPswd" :error-messages="pswdConfirmError" data-vv-scope="pswd"></v-text-field>
                                        <v-text-field label="New Password" type="password" v-model="newPswd" ref="password" name="password" v-validate="'required|min:4|max:20'" :error-messages="errors.collect('password')" data-vv-name="New password" data-vv-scope="pswd"></v-text-field>
                                        <v-text-field label="Confirm New Password" type="password" v-model="confPswd" name="pswd_conf" v-validate="'required|confirmed:password'" :error-messages="errors.collect('confirm')" data-vv-as="password confirm" data-vv-scope="pswd" data-vv-name="confirm"></v-text-field>
                                   </v-col>
                               </v-row>
                            </v-card-text>
                            <v-card-actions>
                                <v-btn class="px-5 mx-5" raised elevation="12" rounded large dark color="#ff383c" :loading="changingPswd" @click.prevent="changePswd">Save Password</v-btn>
                           </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-col>
            <v-snackbar v-model="updateSuccess" :timeout="4000" top color="#44a80f">
                Your profile has been updated successfully.
                <v-btn color="white green--text" text @click.prevent="updateSuccess = false">Close</v-btn>
            </v-snackbar>
            <v-snackbar v-model="pswdChangedSuccess" :timeout="4000" top color="#44a80f">
                Your password has been updated successfully.
                <v-btn color="white green--text" text @click.prevent="pswdChangedSuccess = false">Close</v-btn>
            </v-snackbar>
        </v-row>
    </v-app>
</template>

<script>
export default {
    data(){
        return{
            loading: false,
            user: null,
            editProfile: false,
            edit: {
                name: '',
                address: '',
                phone: '',
                alt_phone: '',
                location: '',
                location_id: null
            },
            locations: [],
            updating: false,
            updateSuccess: false,
            changingPswd: false,
            oldPswd: '',
            oldPswdCheck: false,
            pswdConfirmError: '',
            newPswd: '',
            confPswd: '',
            pswdChangedSuccess: false
        }
    },
    methods:{
        getAccount(){
            axios.get('/get_user_account').then((res) => {
                this.user = res.data
                console.log(res.data)
            })
        },
        modifyAccount(){
            this.editProfile = true
            this.edit.name = this.user.name
            this.edit.address = this.user.address
            this.edit.phone = this.user.phone
            this.edit.alt_phone = this.user.alt_phone
            if(this.user.location_id == null){
                this.edit.location = 'Not filled'
                this.edit.location_id = null
            }else{
                this.edit.location = this.user.location.name
                this.edit.location_id = this.user.location_id
            }
        },
        getLocations(){
            axios.get('/get_user_locations').then((res) => {
                this.locations = res.data
            })
        },
        update(){
            this.$validator.validateAll().then((isValid) =>{
                if(isValid){
                    this.updating = true
                    axios.post('/update_user_profile', {
                        update: this.edit
                    }).then((res) => {
                        console.log(res.data)
                        this.user = res.data
                        this.updating = false;
                        this.editProfile = false
                        this.updateSuccess = true
                    })
                }
            })
        },
        checkOldPswd(){
            this.pswdConfirmError = ''
            axios.post('/confirm_old_pswd', {
                password: this.oldPswd
            }).then((res) => {
                if(res.data == true){
                    this.oldPswdCheck = true
                }else{
                    this.oldPswdCheck = false
                    this.pswdConfirmError = 'Incorrect Password'
                }
            })
        },
        changePswd(){
            // this.checkOldPswd()
             this.$validator.validateAll('pswd').then((isValid) =>{
                if(isValid && this.oldPswdCheck === true){
                    axios.post('/update_user_password', {
                        password: this.newPswd.trim(),
                        password_confirmation: this.confPswd.trim()
                    }).then((res) => {
                        this.oldPswd = ''
                        this.newPswd = ''
                        this.confPswd = ''
                        this.$validator.reset()
                        this.pswdChangedSuccess = true
                    })
                }else{
                    // console.log("failed validation")
                }
             })
        }
    },
    mounted() {
       if(window.Laravel.auth){
            this.getAccount()
        }

        this.getLocations()
    },
}
</script>

<style lang="scss" scoped>
    .v-application{
        .page_title{
            margin-top: -8px;
        }
        hr{
            margin-top: 5px !important;
        }

        @media screen and (max-width: 700px){
            .v-card.main_wrap{
                margin-right: -30px !important;
            }
        }
    }

</style>

