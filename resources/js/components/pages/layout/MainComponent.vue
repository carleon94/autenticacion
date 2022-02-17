<template>
    <v-app>
        <header-component></header-component>
        <menu-component></menu-component>
        <v-main>
            <v-container fluid>
                <router-view></router-view>
            </v-container>
        </v-main>

        <footer-component></footer-component>
    </v-app>
</template>

<script>
    import HeaderComponent from './HeaderComponent.vue';
    import MenuComponent from './MenuComponent.vue';
    import FooterComponent from './FooterComponent.vue';

    export default {
        components : {
            'header-component' : HeaderComponent,
            'menu-component' : MenuComponent,
            'footer-component' : FooterComponent,
        }
    }
</script>

<style lang="scss" scoped>

</style>