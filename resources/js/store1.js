import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import { totalmem } from 'os';

Vue.use(Vuex, axios);

// const items = JSON.parse(localStorage.getItem('items')) || []
const services = JSON.parse(localStorage.getItem('services')) || []
const itemsCost = localStorage.getItem('items_cost') || null
const servicesCost = localStorage.getItem('services_cost') || null
const charges = localStorage.getItem('charges') || null
const auth = window.Laravel.auth

// const items = JSON.parse(localStorage.getItem('items')) != null ? JSON.parse(localStorage.getItem('items')) : []

export const store = new Vuex.Store({
    state: {
        items: JSON.parse(localStorage.getItem('items')) != null ? JSON.parse(localStorage.getItem('items')) : [],
        services: services,
        itemsCost:itemsCost,
        servicesCost:servicesCost,
        charges: charges,
        specialServices: [],
        auth: auth,
        orders: [],
        loading: false,
    },
    getters: {
        getOrders(state){
            return state.orders;
            console.log(state.orders)
        },
        getCart(state){
            console.log(state.items)
            localStorage.setItem('items', JSON.stringify(state.items))
            return state.items;
        },
        getServices(state){
            localStorage.setItem('services', JSON.stringify(state.services))
            // console.log(state.services)
            return state.services;
        },
        getItemsCost(state){
            const val = state.items.map(item=>item.cost).reduce((prev, next) => parseFloat(prev) + parseFloat(next), 0)
            state.itemsCost = val
            localStorage.setItem('items_cost', val)
            return val
        },
        getServicesCost(state){
            const servVal = state.services.map(item=>item.price).reduce((prev, next) => parseFloat(prev) + parseFloat(next), 0);
            state.servicesCost = servVal
            // console.log(servVal)
            localStorage.setItem('services_cost', servVal)
            return servVal
        },
        getCharges(state){
            if(!state.itemsCost){
                state.charges = 0
                return 0;
            }
            if(state.itemsCost > 10000 && state.itemsCost < 500000){
                localStorage.setItem('charges', 50000)
                state.charges = 50000
                return 50000
            }
            if(state.itemsCost > 490000 && state.itemsCost < 1000000){
                state.charges = 70000
                localStorage.setItem('charges', 70000)
                return 70000
            }
            if(state.itemsCost > 990000 && state.itemsCost < 2000000){
                state.charges = 100000
                localStorage.setItem('charges', 100000)
                return 100000
            }
            if(state.itemsCost > 1900000 && state.itemsCost < 5000000){
                state.charges = 2000000
                localStorage.setItem('charges', 200000)
                return 200000
            }
            if(state.itemsCost >= 5000000){
                state.charges = 5000000
                localStorage.setItem('charges', 500000)
                return 500000
            }
        },
    },
    actions: {
        getOrders(context){
            axios.get('/get_all_orders_for_user').then((res) => {
                context.commit('set_orders', res.data)
            }).catch((err) => {
                console.log(err)
            })
        }
    },
    mutations: {
        set_orders(state, payload){
            if(state.auth == true){
                state.loading = false
                state.orders = payload
            }
        },
        addItemsToCart(state, payload){
            state.items.push(payload)
            this.commit('saveToLocalStorage')
        },
        saveToLocalStorage(state, payload){
            window.localStorage.setItem('cart', JSON.stringify(state.items))
        },
        addServicesToCart(state, payload){
            state.services.push(payload)
        },
        update_items(state, payload){
            state.items = payload
        },
        update_services(state, payload){
            state.services = payload
        },
        addServsToCart(state,payload){
            state.specialServices = payload
        }
    }
})
