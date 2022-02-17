<template>
    <v-app>
        <v-main>
            <v-container fluid>
                <div class="page-login w-100 flex-column d-flex justify-center align-center">
                    <v-form
                        @submit.prevent="loader='loading'; doLogin()"
                        ref="form"
                        v-model="formValid"
                        lazy-validation
                        class="py-2"
                    >
                        <img src="/images/logo.png" alt="Logo Aplicación" class="logo">
                        <div class="form-box">
                            <h3>¡Bienvenido!</h3>
                            <div class="form-input">
                                <v-text-field
                                    outlined
                                    type="email"
                                    v-model="email"
                                    :rules="rulesForm.emailRules"
                                    label="Correo / Usuario"
                                    required
                                >
                                    <v-icon
                                        slot="append"
                                    >
                                        mdi-shield-account
                                    </v-icon>
                                </v-text-field>
                                <v-text-field
                                    outlined
                                    v-model="password"
                                    :rules="rulesForm.passwordRules"
                                    label="Contraseña"
                                    required
                                    :append-icon="value ? 'mdi-eye' : 'mdi-eye-off'"
                                    @click:append="() => ( value =! value )"
                                    :type="value ? 'password' : 'text'"
                                >
                                </v-text-field>
                            </div>
                            <div class="buttons">
                                <v-btn
                                    type="submit"
                                    color="info"
                                    :loading="loading"
                                    :disabled="!formValid"
                                >
                                    Iniciar Sesión
                                </v-btn>
                                <a href="" class="reminder">¿Has olvidado tu contraseña?</a>
                            </div>
                        </div>
                    </v-form>
                </div>
            </v-container>
        </v-main>
    </v-app>
</template>
<script>
    export default {
        data() {
            return {
                value: String,
                formValid: true,
                rulesForm: {
                    emailRules: [
                        v => !!v || 'Correo es requerido',
                        v => /.+@.+\..+/.test(v) || 'Correo debe ser válido',
                    ],
                    passwordRules: [
                        v => !!v || 'Contraseña es requerida',
                    ]
                },
                email: '',
                password: '',
                loading: false,
                loader: null,
            }
        },
        watch: {
            loader () {
                const l = this.loader
                this[l] = !this[l]
                setTimeout( () => ( this[l] = false ), 2500)
                this.loader = null
            },
        },
        methods: {
            validate () {
                this.$refs.form.validate()
            },
            reset () {
                this.$refs.form.reset()
            },
            resetValidation () {
                this.$refs.form.resetValidation()
            },
            doLogin () {
                if ( this.formValid ) {
                    let data = {
                        email: this.email,
                        password: this.password,
                    }
                    this.$store.dispatch( 'login' , data )
                        .then( async( response ) => {
                            if( response.status ) {
                                this.$toast.success( response.message.description , response.message.title )
                                this.$router.push({ name: 'home' })
                            } else {
                                this.$toast.warning( response.message.description , response.message.title )
                            }
                            return false
                        })
                } else {
                    this.$refs.form.validate()
                }
            }
        },
        mounted() {
            this.validate();
        }
    }
    
</script>
<style lang="scss" scoped>
    .page-login {
        height: 100vh;
        width: 100vw;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }
    form {
        position: relative;
        background:#282828;
        width: 100%;
        max-width: 360px;
        min-height: 480px;
        img.logo {
            max-width: 220px;
            width: 50%;
            display: block;
            margin: 36px auto 0;
        }
        .form-box {
            padding: 24px;
        }
        .buttons {
            text-align: center;
            margin-top: 6px;
        }
        h2 {
            font-size: 20px;
            margin: auto;
            text-align: center;
            color: white;
            font-weight: 300;
        }
        h3, h4 {
            text-align: center;
            color: white;
            font-weight: 400;
            margin: 0;
        }
        h3 {
            font-size: 18px;
        }
        h4 {
            font-size: 14px;
            margin: 8px 0;
        }
        .btn-login {
            width: 70%;
            text-transform: uppercase;
        }
        .form-input {
            margin-top: 20px;
            .v-input {
                margin-top: 5px;
            }
        }
        .reminder {
            color: #2196F3;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
            display: inline-block;
            margin-top: 16px;
            &:hover {
                text-decoration: underline;
            }
        }
    }
</style>
