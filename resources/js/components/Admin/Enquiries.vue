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
                                        <div class="my-5">
                                            <div class="subtitle-1"> Unread <v-chip>{{ unreadCount }}</v-chip></div>
                                        </div>
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
                                        <div class="my-5" v-if="showPag">
                                            <span class="pl-4">
                                                <v-btn color="primary" @click.prevent="getMessages(pagination.prev_link)" :disabled="!pagination.prev_link">&lt;</v-btn>
                                                <v-btn color="primary" @click.prevent="getMessages(pagination.next_link)" :disabled="!pagination.next_link">&gt;</v-btn>
                                            </span>
                                            <span class="pl-8">
                                                Page: {{ pagination.current_page }} of {{ pagination.last_page }}
                                            </span>
                                        </div>
                                        <div class="my-3" v-if="searchMode">
                                            <span class="pl-4">
                                                <v-btn dark text color="#ff3c38" @click.prevent="clearSearch"><v-icon>sync</v-icon> &nbsp; Clear Filter</v-btn>
                                            </span>
                                        </div>
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
                            <v-btn color="#ff3c38" dark @click.prevent="deleteMsg" :loading="loading">Delete Message</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <v-snackbar v-model="delSuccess" :timeout="4000" top color="#43A047">
                    Enquiry was successfully deleted.
                    <v-btn color="#388E3C" text @click="delSuccess = false">Close</v-btn>
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
            delSuccess: false,
            unreadCount: null,
            pagination: {},
            showPag: true,
            searchMode: false,
        }
    },
    computed:{
        unread(){
            axios.get('/unread_enquiries_count').then((res) => {
                this.unreadCount = res.data
            })
        }
    },
    methods: {
        getMessages(pag){
            this.loading = true
            pag = pag || '/admin_get_all_mails_enquiries'
            axios.get(pag).then((res) => {
                this.loading = false
                this.messages = res.data.data

                 this.pagination = {
                    current_page: res.data.current_page,
                    last_page: res.data.last_page,
                    from_page: res.data.from,
                    to_page: res.data.to,
                    total: res.data.total,
                    path_page: res.data.path+"?page=",
                    first_link: res.data.first_page_url,
                    last_link: res.data.last_page_url,
                    prev_link: res.data.prev_page_url,
                    next_link: res.data.next_page_url,
                }
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
        this.getMessages()

        this.unread
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
