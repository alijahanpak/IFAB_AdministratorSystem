export const auth = new Vue({
    el: '#login',
    data:{
        showModalLogin: false,
        authInfo: {email: '' , password: ''},
        tokenInfo: {Authorization: '' , Accept: 'application/json'},
    },
    created: function () {

    },

    methods:{
        login: function () {
            axios.post('/api/login' , this.authInfo)
                .then((response) => {
                    console.log(response);
                    this.tokenInfo.Authorization = 'Bearer ' + response.data.access_token;
                    localStorage.setItem('ifab_token_info' , JSON.stringify(this.tokenInfo));
                    this.showModalLogin = false;
                },(error) => {
                    console.log(error);
                });
        },
        test: function () {
            if (!localStorage["ifab_token_info"])
                this.showModalLogin = true;
            else{
                axios.post('/api/userIsAuthorize' , null ,{headers: JSON.parse(localStorage.getItem("ifab_token_info"))})
                    .then((response) => {
                        console.log(response);
                    },(error) => {
                        this.showModalLogin = true;
                        console.log(error);
                    });
            }
        }
    }
});

