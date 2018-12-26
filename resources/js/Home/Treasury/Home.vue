<template>
    <div>
        <content-data>
            <div class="row row-cards">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">MONTHLY LIST FOR CASH TO BE DEPOSIT</h3>
                        </div>
                        <div class="table-responsive">
                            <loading :active="show" spinner="bar-fade-scale" color="#FF6700"/>
                            <table id="monthly-cash-dep" class="table table-condensed table-hover">
                                <thead>
                                    <tr>
                                    <th>Month</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="dep in forDepositData">
                                        <td>{{dep.date_shrt | moment("MMMM , YYYY")}}</td>
                                        <td>
                                            <router-link :to="'/data/'+dep.date_shrt" :date-covered="dep.date_shrt" class="btn btn-outline-primary btn-sm">
                                            <i class="fe fe-eye"></i>
                                             view
                                            </router-link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </content-data>


    </div>
</template>

<script>
    export default{
        data()
            {
              return {
                  baseUrl:this.$store.state.baseUrl,
                  forDeposit:'',
                  columns: ['sales_date'],
                  tableData: [],
                  show:false,
              }
            },
        mounted()
            {
                this.show = true;
                this.$store.dispatch('getUserData');
                this.userData1 = this.$store.state.userData;
                let $this = this;
              //  this.$store.dispatch('forDepositMonth');
                this.$store.dispatch('forDepositMonth').then(() => {
                    setTimeout(function(){
                        $("#monthly-cash-dep").DataTable({"bSort" : false});
                    },500);

                });



            },
        methods:
            {
                isLoggedIn()
                {
                    return this.$store.getters.loggedIn;
                },
                loadDataTable()
                {


                },
            },
        computed:
            {
                userDataInfo()
                {
                    return this.$store.state.userData;
                },
                loggedIn()
                {
                    return this.$store.getters.loggedIn;
                },
                forDepositData()
                {
                    this.show = false;
                   return this.$store.state.forDepositMonth;
                }
            },
        created()
            {
               //etTimeout(function(){
                  //  tableLoad();
                //},2000);
                if(!this.isLoggedIn())
                {
                    return this.$router.push('/');
                }
                this.tableData =  this.$store.state.forDepositMonth;
            },
        watch:
            {
                computedData()
                {
                    this.tableData =  this.$store.state.forDepositMonth;
                }
            }
    }

    function clearTable(){
        let table = $('#monthly-cash-dep').DataTable();
        table.destroy();
    }

//    function tableLoad()
//    {
    document.addEventListener("DOMContentLoaded",function(){
//        $("#monthly-cash-dep").DataTable();
    });

    //}
</script>