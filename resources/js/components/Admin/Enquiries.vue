<template>
    <v-app light>
        <v-row>
            <nav-drawer-admin></nav-drawer-admin>
            <v-container>
                <v-row>
                    <v-col cols="10" offset="1" class="content_wrap">
                        <v-row>
                            <v-col cols="12" sm="6">
                                <div class="title">
                                    Mails & Enquiries
                                </div>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <div class="mt-n6">
                                    <v-text-field v-model="search" append-icon="search" label="Search for Mail" single-line hide-details @keyup="searchEnquiry"></v-text-field>
                                </div>
                            </v-col>
                        </v-row>
                        <v-divider></v-divider>
                        <v-row>
                            <v-col cols="12">
                                <div class="table_header">
                                    <div class="subtitle-1"></div>
                                </div>
                                <v-row>
                                    <v-col cols="12" md="10">
                                        <v-simple-table fixed-header min-height="300px" class="order_table">
                                            <template v-slot:default v-if="messages">
                                            <thead>
                                                <tr>
                                                    <th class="text-left">Date</th>
                                                    <th class="text-left">Sender</th>
                                                    <th class="text-left">Title</th>
                                                    <th class="text-left">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(msg, index) in messages" :key="index" :class="{ unread : msg.status == 0 }">
                                                    <td>{{ msg.sent }}</td>
                                                    <td>{{ msg.name }}</td>
                                                    <td>{{ msg.message | truncate(20) }}</td>
                                                    <td><v-btn dark color="primary" small :to="{name: 'AdminEnquiryMail', params: {slug: msg.slug, mail: msg.id}}"><v-icon>visibility</v-icon></v-btn>&nbsp; <v-btn small dark color="#ff3c38" @click.prevent="openDelDialog(msg, index)"><v-icon>delete_forever</v-icon></v-btn></td>
                                                 </tr>
                                            </tbody>
                                            </template>
                                            <template v-else>
                                                <div class="subtitle-1">There are no enquiries/email at the moment</div>
                                            </template>
                                        </v-simple-table>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-dialog v-model="delDialog" max-width="450">
                    <v-card>
                        <v-card-title class="justify-center">
                            <div class="subtitle-1">Do you really want to delete this mail/enquiry?</div>
                        </v-card-title>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text color="#ff3c38" @click.prevent="delDialog = false"> Cancel </v-btn>
                            <v-btn color="primary" dark @click.prevent="deleteMsg" :loading="loading">Delete Message</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <v-snackbar v-model="delSuccess" :timeout="4000" top color="#43A047">
                    Enquiry was successfully deleted.
                    <v-btn color="#388E3C" flat @click="delSuccess = false">Close</v-btn>
                </v-snackbar>
            </v-container>
        </v-row>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            messages: [],
            search: '',
            messageToDel: null,
            msgIndexToDel: null,
            delDialog: false,
            delSuccess: false
        }
    },
    methods: {
        getMessages(){
            this.loading = true
            axios.get('/admin_get_all_mails_enquiries').then((res) => {
                this.loading = false
                this.messages = res.data
                console.log(res.data)
            })
        },
        searchEnquiry(){
            if(this.search !== ''){
                const search = this.search.trim()
                const filtered = this.messages.filter(msg => this.toLower(msg.name).includes(this.toLower(search)) || this.toLower(msg.message).includes(this.toLower(search)))
                const allMsgs = this.messages
                this.messages = filtered
            }else{
                this.getMessages()
            }
        },
        toLower(str){
             return str.replace(/\w\S*/g, function(txt){
                return txt.toLowerCase();
            })
        },
        openDelDialog(msg, index){
            this.delDialog = true
            this.messageToDel = msg
            this.msgIndexToDel = index
        },
        deleteMsg(){
            axios.post(`/admin_delete_contact_enquiry/${this.messageToDel.id}`).then((res) => {
                console.log(res.data)
                this.messages.splice(this.msgIndexToDel, 1)
                this.delDialog = false
                this.closeDelDialog()
                this.delSuccess = true
            })
        },
        closeDelDialog(){
            this.messageToDel = null
            this.msgIndexToDel = null
            this.delDialog = false
        }
    },
    mounted() {
        // this.getUsers()
        this.getMessages()
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
        top: 50% !important;
        left: 50%;
        margin-top: 10rem;
    }

    .table_header{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;

        .subtitle-1{
            flex: 0 1 50%;
            padding-left: 2rem;
        }
        .v-text-field{
            flex: 0 1 50%;
            margin-top: -25px !important;
        }
    }
    .order_table{
        margin-top: 2rem;
        border: 1px solid #fff !important;
        box-shadow: 0 10px 13px -6px rgba(0,0,0,.2),0 20px 31px 3px rgba(0,0,0,.14),0 8px 38px 7px rgba(0,0,0,.12)!important;
        overflow-x: scroll;
        cursor: pointer;

        tr.unread{
            background: #d8d8d8 !important;
            color: #151515 !important;
        }
    }

    @media screen and(max-width: 960px) {
        .order_table{
            min-width: 100vw !important;
            margin-left: -2rem !important;
            overflow-x: scroll;
        }
    }
</style>
