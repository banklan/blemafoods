<template>
    <v-app light>
        <v-row>
            <nav-drawer-admin></nav-drawer-admin>
            <v-container>
                <v-row>
                    <v-col cols="10" offset="1" class="content_wrap">
                        <v-row>
                            <v-col cols="12">
                                <div class="title">
                                    Home
                                </div>
                            </v-col>
                        </v-row>
                        <v-divider></v-divider>
                        <v-row>
                            <v-col cols="12">
                                <v-row>
                                    <v-col cols="12" md="6">
                                        <v-card tile dark elevation="12" raised color="indigo darken-2" min-height="250" ripple>
                                            <v-card-title class="justify-center">
                                                Daily Order Summary
                                            </v-card-title>
                                            <v-card-text>
                                                <v-list-item>
                                                    <v-list-item-content>
                                                        <v-list-item-title>You have 150 total orders today</v-list-item-title>
                                                    </v-list-item-content>
                                                </v-list-item>
                                                <v-list-item>
                                                    <v-list-item-content>
                                                        <v-list-item-title class="orange--text lighten-4">12 pending orders</v-list-item-title>
                                                    </v-list-item-content>
                                                </v-list-item>
                                                <v-list-item>
                                                    <v-list-item-content>
                                                        <v-list-item-title class="cyan--text accent-2 lighten-4">35 completed orders</v-list-item-title>
                                                    </v-list-item-content>
                                                </v-list-item>
                                            </v-card-text>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-card dark elevation="12" color="#ff7600" raised min-height="250" ripple>
                                            <v-card-title class="justify-center">
                                                Alerts
                                            </v-card-title>
                                            <v-card-text>
                                               <div class="subtitle-1">New Order alert</div>
                                            </v-card-text>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="12" sm="8">
                                        <v-card light elevation="12" raised min-height="250" class="mx-auto">
                                            <v-list rounded>
                                                <v-subheader class="justify-center">
                                                    <div class="title">Brief analytics</div>
                                                </v-subheader>
                                                <v-list-item-group color="primary">
                                                    <v-list-item link ripple to="">
                                                        <v-list-item-content>
                                                            <v-list-item-title>You have 150 total users</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title>Total products listed - 200</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title>Total services listed</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title>Total special services listed - 18</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title>Total product categories - 12</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                </v-list-item-group>
                                            </v-list>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="12" sm="4">
                                        <v-card light elevation="12" raised min-height="250">
                                            <v-card-title class="justify-center">
                                                Daily Visits to blema
                                            </v-card-title>
                                        </v-card>
                                    </v-col>
                                </v-row>
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

}
</script>

<style lang="scss" scoped>
    @media screen and(max-width: 700px){
        .content_wrap{
            margin-left: 6rem !important;
        }
    }
</style>
