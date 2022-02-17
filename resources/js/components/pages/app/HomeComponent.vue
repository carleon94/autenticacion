<template>
    <v-row>
        <v-col cols="12">
            <v-toolbar
                elevation="4"
            >   
                <v-row>
                    <v-col>
                        <v-select
                            v-model="categoryBook"
                            :items="categories"
                            item-text="name"
                            item-value="id"
                            menu-props="auto"
                            label="Elegir categoría"
                            hide-details
                            prepend-icon="mdi-tag"
                            single-line
                        ></v-select>
                    </v-col>
                    <v-col>
                        <v-btn
                            outlined
                            color="success"
                            @click="getListBooks()"
                        >
                            Filtrar
                        </v-btn>
                    </v-col>
                </v-row>
            </v-toolbar>
        </v-col>

        <v-col cols="12" v-if="!books.length && !loading" class="text-center">
            <h3 class="empty-text text-gray">No hay libros creados</h3>
            <v-icon class="empty-icon text-gray" size="50">mdi-book</v-icon>
        </v-col>

        <v-col cols="3" v-for="(book , index) in books" :key="index">
        </v-col>

        <v-tooltip left>
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    v-bind="attrs"
                    v-on="on"
                    fab
                    large
                    dark
                    bottom
                    right
                    color="green"
                    class="v-btn--create"
                    @click.prevent="openCreateBook"
                >
                    <v-icon>mdi-plus</v-icon>
                </v-btn>
            </template>
            <span>Crear Libro</span>
        </v-tooltip>

    </v-row>
    
</template>

<script>    
    export default {
        components : {
        },

        data: () => ({
            loading: true,
            categoryBook: null,
            books: [],
            categories: [],
        }),

        methods: {
            openCreateBook() {
                console.log(this.$refs.createBookDialog)
                this.$refs.createBookDialog.open();
            },
            getCategories() {
                axios.get( 'book/create' )
                    .then( response => {
                        this.categories = response.data.category
                    })
            },
            getListBooks() {
                let params = {}
                if ( this.categoryBook ) {
                    params.category_book_id = this.categoryBook
                }
                axios.get( 'book' , { params:params } ) 
                    .then( response => {
                        this.books = response.data.books
                        this.loading = false
                    })
            }
        },
        mounted() {
            // this.getListBooks();
            // this.getCategories();
        }
    }
</script>

<style>
    .v-btn--create {
        bottom: 0;
        right: 0;
        position: absolute;
        margin: 16px;
    }

    .empty-text {
        font-size:40px
    }
</style>