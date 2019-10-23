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
const servicesCost = servCst ? servCst : 0

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
        fees: {},
        fees1: null,
        fees2: null,
        fees3: null,
        fees4: null,
        fees5: null,
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
    },
    actions: {
        getOrders(context){
            axios.get('/get_all_orders_for_user').then((res) => {
                context.commit('set_orders', res.data)
            }).catch((err) => {
                console.log(err)
            })
        },
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
        },
        empty_cart(state, payload){
            state.items = []
            state.services = []
            window.localStorage.removeItem('items')
            window.localStorage.removeItem('services')
            window.localStorage.removeItem('charges')
            window.localStorage.removeItem('items_cost')
        }
    }
})
