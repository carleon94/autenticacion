export default function() {
    axios.interceptors.request.use(
        request => {
            const token = localStorage.getItem('token');
            if ( token ) {
                request.headers.common["Authorization"] = `Bearer ${token}`;
            }
            return request;
        },
        error => {
            return Promise.reject(error);
        }
    );
    axios.interceptors.response.use(
        response => {
            return response
        },
        error => {
            const { config , response: { status , data } } = error ;
            let message = {
                title: 'Error',
                description: 'Ha ocurrido un error',
            }
            if ( status === 400 ) {
                message.description = 'El token no ha sido proveído'
            }
            else if ( status === 401 ) {
                if ( data.error == 'token_invalid' ) {
                    message.description = 'El token es inválido'
                }
                else if( data.error == 'token_expired' ) {
                    message.description = 'El token ha expirado vuelva a iniciar sesión'
                }
            }
            else if ( status === 403 ) {
                message.description = 'El token está en lista negra'
            }
            else {
                message.description = data.message
                return Promise.reject( error );
            }
            this.$store.commit( 'CLEAR_AUTH_DATA' )
            this.$toast.error( message.description , message.title )
            this.$router.push( { name: 'login' } );

            return Promise.reject( error );
        }
    );
}
