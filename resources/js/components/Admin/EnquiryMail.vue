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
                        </v-row>
                        <v-divider></v-divider>
                        <v-row>
                            <v-col cols="12">
                                <v-btn color="#ff3c38" dark raised rounded ripple @click.prevent="$router.go(-1)"><v-icon left>arrow_left</v-icon>Back</v-btn>
                            </v-col>
                            <v-col cols="12">
                                 <v-progress-circular v-if="isLoading" indeterminate color="orange" :width="5" :size="50" class="justify-center align-center"></v-progress-circular>
                                 <v-card v-else light raised elevation="14" min-height="400" min-width="600" class="pa-4">
                                    <v-card-title>
                                        <div class="subtitle-1 font-weight-bold">{{ message.title }}</div>
                                    </v-card-title>
                                    <v-card-text>
                                        <v-simple-table>
                                            <tr>
                                                <th>Sender:</th>
                                                <td>{{ message.name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Date:</th>
                                                <td>{{ message.sent }}</td>
                                            </tr>
                                            <tr>
                                                <th>Message:</th>
                                                <td>{{ message.message }}</td>
                                            </tr>
                                        </v-simple-table>
                                    </v-card-text>
                                 </v-card>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-container>
        </v-row>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            message: [],
        }
    },
    methods: {
        getMessage(){
            this.isLoading = true
            axios.get(`/admin_get_enquiry/${this.$route.params.mail}`).then((res) => {
                this.isLoading = false
                this.message = res.data
                console.log(res.data)
            })
        },
        readMessage(){
            axios.get(`/admin_change_msg_status/${this.$route.params.mail}`).then((res) => {
                console.log(res.data)
            })
        }
    },
    mounted() {
        this.readMessage()
        this.getMessage()
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
