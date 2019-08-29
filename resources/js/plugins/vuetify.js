import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import colors from 'vuetify/lib/util/colors'


Vue.use(Vuetify, {
    iconfont: 'md',
    theme: {
        // themes: {
            // light: {
                primary: '#15C5C5',
                secondary: '#ff3c38',
                body: '#f5f8fa',
                body_bg: '#f7f7f7',
                info: '#4eebff',
                body_text: '#484848',
                pry_col: colors.red.accent3,
                nice_blue: colors.blue.accent4
        //     }
        // }
    }
})

export default new Vuetify();
