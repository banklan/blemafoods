<template>
    <div>
        <v-card raised elevation="10" light ripple hover height="200" v-if="service">
            <v-card-title class="justify-center">
                <div class="title">{{ service.name }}</div>
            </v-card-title>
            <v-card-text>
                {{ service.description }}
            </v-card-text>
            <v-card-actions>
                <v-select dense small :items="units" v-model="picked.units" width="40%"></v-select>
                <v-spacer></v-spacer>
                <v-btn dark small text color="#ff3c38" @click.prevent="addToCart(service)">Add to Cart</v-btn>
            </v-card-actions>
        </v-card>
        <v-progress-circular indeterminate color="purple" :width="5" :size="50" v-if="!service"></v-progress-circular>
    </div>
</template>

<script>
export default {
    props: ['service'],
    data() {
        return {
            units: [1,2,3,4,5],
            picked: {
                price: null,
                service: '',
                units: null
            }
        }
    },
    methods: {
        addToCart(service){
            this.picked.service = service.name
            this.picked.price = service.price
            this.$store.commit('added', this.picked)
        }
    },
}
</script>

<style lang="scss" scoped>
    .v-card .v-btn{
        text-transform: none !important;
    }
</style>

