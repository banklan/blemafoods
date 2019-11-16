<template>
    <v-navigation-drawer hide-overlay expand-on-hover value="true" absolute permanent color="#34394a">
        <v-list dark>
            <v-list-item-group>
                <v-list-item link two-line to="/home">
                    <v-list-item-icon>
                        <v-icon>dashboard</v-icon>
                    </v-list-item-icon>

                    <v-list-item-title class="subtitle-1">
                        <div>{{ user && user.name }}</div><br/>
                        <div>{{ user && user.email }}</div>
                    </v-list-item-title>
                </v-list-item>
            </v-list-item-group>
        </v-list>
        <v-divider></v-divider>
        <v-list nav dense dark>
            <v-list-item-group v-model="item" color="primary">
                <v-list-item link v-for="(link, i) in items" :key="i" :to="link.to">
                    <v-list-item-icon>
                        <v-icon v-text="link.icon"></v-icon>
                    </v-list-item-icon>

                    <v-list-item-title v-text="link.title">
                    </v-list-item-title>
                    <span class="float-right" v-if="link.unread">{{ unread }}</span>
                </v-list-item>
            </v-list-item-group>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
export default {
    data(){
        return{
            user: null,
            item: 0,
            items: [
                {title: 'My Orders', icon: 'dashboard', to: '/my_orders'},
                {title: 'Messages', icon: 'message', to: '/messages', unread: 'unread'},
                {title: 'Account', icon: 'people_outline', to: '/account'},
            ],
            unread: null
        }
    },
    methods: {
        getUnread(){
            axios.get('/get_users_unread_msgs').then((res) => {
                this.unread = res.data
            })
        }
    },
    mounted() {
        if(window.Laravel.auth){
            this.user = window.Laravel.user
        }

        this.getUnread()
    },
}
</script>

<style lang="scss" scoped>
    .v-navigation-drawer__content .v-list{
        a:hover{
            text-decoration: none !important;
        }
    }
</style>

