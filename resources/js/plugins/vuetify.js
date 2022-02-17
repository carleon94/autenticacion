import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import colors from 'vuetify/lib/util/colors';
Vue.use(Vuetify)

export default new Vuetify({
    theme: {
        options: {
            customProperties: true,
        },
        dark: true,
        themes: {
            dark: {
                background: colors.grey.darken4,
                primary: colors.green,
                secondary: colors.blue.darken1,
                accent: colors.lightGreen.base,
                error: colors.red.accent3,
            },
        },
    }
})