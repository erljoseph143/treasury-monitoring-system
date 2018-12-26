import VueRouter from 'vue-router';

let routes  = [
    {
        path:'/',
        name:'login',
        component:require('./auth/login.vue')
    },
    {
        path:'/api/logout',
        name:'logout',
        component:require('./auth/logout.vue')
    },
   /*
   * *******************************************************
   *  For Treasury Routes
   * *******************************************************
   * */
    {
        path:'/cashForDeposit',
        name:'cashForDeposit',
        component:require('./Home/Treasury/Home.vue')
    },
    {
        path:'/forViewDep/:date',
        name:'forViewDep',
        component:require('./Home/Treasury/viewDep.vue')
    },
    {
        path:'/data/:date',
        name:'data',
        component:require('./Home/Treasury/monthly.vue')
    },
    {
        path:'/cashRelease',
        name:'cashRelease',
        component:require('./Home/Treasury/monthly.vue')
    }
];

export default new VueRouter({
    routes
});