<template>

    <v-navigation-drawer app
        class="deep-purple accent-4"
        dark
        permanent
    >
        <v-list-item two-line>
            <v-list-item-avatar>
                <img src="https://randomuser.me/api/portraits/men/81.jpg">
            </v-list-item-avatar>

            <v-list-item-content>
                <v-list-item-title>{{ userLogged.first_name+' '+ userLogged.last_name }}</v-list-item-title>
                <v-list-item-subtitle>Administrador</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>

        <v-divider></v-divider>
        <v-list>
            <v-list-item
            v-for="item in items"
            :key="item.title"
            link
            >
            <v-list-item-icon>
                <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
                <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item-content>
            </v-list-item>
        </v-list>

        <template v-slot:append>
            <div class="pa-2">
            <v-btn block @click="logout()">
                Logout
            </v-btn>
            </div>
        </template>
    </v-navigation-drawer>
    
</template>

<script>
    export default {
        data () {
            return {
                items: [
                    { title: 'Dashboard', icon: 'mdi-view-dashboard' },
                    { title: 'Account', icon: 'mdi-account-box' },
                    { title: 'Admin', icon: 'mdi-gavel' },
                ],
                userLogged: this.$store.getters.getUser,
            }
        },
        methods: {
            logout() {
                this.$store.dispatch( 'logout' )
                    .then( ( response ) => {
                        if( response.status ) {
                            this.$toast.success( response.message.description , response.message.title )
                            this.$router.push({name:'login'})
                        }
                    })
            }
        }
    }
</script>