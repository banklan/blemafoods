import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import { totalmem } from 'os';

Vue.use(Vuex, axios);

const prods = window.localStorage.getItem('items')
const items = prods ? JSON.parse(prods) : []

const servs = window.localStorage.getItem('services')
const services = servs ? JSON.parse(servs) : []

const itCst = window.localStorage.getItem('items_cost')
const itemsCost = itCst ? itCst : null

const servCst = window.localStorage.getItem('services_cost')
const servicesCost = servCst ? servCst : null

const token = window.localStorage.getItem('charges')
const charges = token ? token : null

const auth = window.Laravel.auth

export const store = new Vuex.Store({
    state: {
        items: items,
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
            // console.log(state.items)
            return state.items
        },
        getServices(state){
            return state.services
        },
        getItemsCost(state){
            const val = state.items.map(item=>item.cost).reduce((prev, next) => parseFloat(prev) + parseFloat(next), 0)
            state.itemsCost = val
            localStorage.setItem('items_cost', val)
            return val
        },
        getServicesCost(state){
            return state.servicesCost
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
            this.commit('saveItemsToLocalStorage')
        },
        saveItemsToLocalStorage(state, payload){
            window.localStorage.setItem('items', JSON.stringify(state.items))
        },
        addServicesToCart(state, payload){
            state.services.push(payload)
            this.commit('saveServicesToLs')
            this.commit('calcServiceCost')
        },
        calcServiceCost(state, payload){
            const servVal = state.services.map(item=>item.cost).reduce((prev, next) => parseFloat(prev) + parseFloat(next), 0)
            state.servicesCost = servVal
            window.localStorage.setItem('services_cost', servVal)
        },
        saveServicesToLs(state, payload){
            window.localStorage.setItem('services', JSON.stringify(state.services))
        },
        update_items(state, payload){
            state.items = payload
            this.commit('saveItemsToLocalStorage')
        },
        update_services(state, payload){
            state.services = payload
            this.commit('calcServiceCost')
            this.commit('saveServicesToLs')
        },
        addServsToCart(state,payload){
            state.specialServices = payload
        }
    }
})
