import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state:
        {
            token: localStorage.getItem('access_token') || null,
            baseUrl: $baseUrl,
            userData:[],
            userType:'',
            forDepositMonth:[],
            forDepositDaily:[],
            forViewDep:[],
            forCheckClass:[]
        },
    getters:
        {
            loggedIn(state)
            {
                return state.token !== null;
            },
            userType(state)
            {
                return state.userType;
            },
            userData(state)
            {
                return state.userData;
            },
            forViewDep(state)
            {
                return state.forViewDep;
            },
            forCheckClass(state)
            {
                return state.forCheckClass;
            }

        },
    mutations:
        {
            retrieveToken(state,token)
            {
                state.token = token;
            },
            destroyToken(state)
            {
                state.token = null;
                state.userData = [];
            },
            userData(state,users)
            {
                state.userData = users;
                state.userType = users.usertype.user_type_name;
            },
            /*
            * ******************************************************************************
            * For deposit Actions
            * ******************************************************************************
            * */
            forDepositMonth(state,data)
            {
                state.forDepositMonth = data;
            },
            forDepositDaily(state,data)
            {
                state.forDepositDaily = data;
            },
            forViewDep(state,data)
            {
                state.forViewDep = data;
            },
            forCheckClass(state,data)
            {
                state.forCheckClass = data;
            }
        },
    actions:
        {
            getUserData(context,state)
            {
               return new Promise((resolve,reject)=>{
                   axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
                   axios.get($baseUrl+'/api/user').then(res => {
                       context.commit('userData',res.data);
                   });
               });

            },
            destroyToken(context)
            {
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
                if(context.getters.loggedIn){
                    return new Promise((resolve,reject)=>{
                        axios.post($baseUrl+'/api/logout').then(res=>{
                            localStorage.removeItem('access_token');
                            context.commit('destroyToken');
                            resolve(res);
                        }).catch(error => {
                            console.log(error.data);
                            reject(error);
                        });
                    });
                }

            },
            retrieveToken(context,credentials)
            {
                return new Promise((resolve,reject) => {
                    axios.post($baseUrl+'/api/login',{
                        username:credentials.username,
                        password:credentials.password
                    }).then(res=>{
                        const token = res.data.access_token;
                        localStorage.setItem('access_token',token);
                        context.commit('retrieveToken',token);
                        resolve(res);
                         //console.log(res.data);
                    }).catch(error => {
                        console.log(error.data);
                        reject(error);
                    });
                });
            },
            /*
            * ******************************************************************************
            * For deposit Actions
            * ******************************************************************************
            * */
            forDepositMonth(context)
            {
              //  return new Promise((resolve,reject)=>{
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
                  return  axios.get($baseUrl+'/api/forDeposit').then(res => {
                        context.commit('forDepositMonth',res.data);
                    });
                //});

            },
            forDepositDaily(context,dateOf)
            {
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
                axios.get($baseUrl+'/api/dailyDep/'+dateOf).then(res => {
                    context.commit('forDepositDaily',res.data);
                });
            },
            forViewDep(context,dateOf)
            {
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
                axios.get($baseUrl+'/api/viewDep/'+dateOf).then(res => {
                    context.commit('forViewDep',res.data);
                });
            },
            forCheckClass(context,checkClass,date)
            {
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
                axios.get($baseUrl+'/api/checkClass/'+checkClass+'/'+date).then(res => {
                    context.commit('forCheckClass',res.data);
                });
            },
            forAddCashLog(context,data)
            {
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
                axios.post($baseUrl+'/api/addLogs',data).then(res => {
                 //   axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
                    axios.get($baseUrl+'/api/viewDep/'+data.dateOf).then(res => {
                        context.commit('forViewDep',res.data);
                    });
                })
            },
            allLogsData(context,data)
            {
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
                axios.post($baseUrl+'/api/allLogsData',data).then(res => {

                })
            }

        }
});