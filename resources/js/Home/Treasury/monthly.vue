<template>
    <content-data>
        <div class="row row-cards">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> DAILY LIST FOR CASH TO BE DEPOSIT</h3>
                    </div>
                    <div class="table-responsive">
                        <loading :active="show" spinner="bar-fade-scale" color="#FF6700"/>
                        <table id="daily-cash-dep" v-show="tableDisplay" class="table table-condensed table-hover dataTable no-footer">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="dep in forDepositDaily">
                                <td>{{dep.date_shrt | moment("MMMM DD, YYYY")}}</td>
                                <td>
                                    <router-link :to="'/forViewDep/'+dep.date_shrt" :date-covered="dep.date_shrt" class="btn btn-outline-primary btn-sm">
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
</template>

<script>
    export default {
        data()
        {
          return {
              //forDepositDaily:[]
              show:false,
              tableDisplay:false
          }
        },
        mounted()
        {

            this.show = true;
            let dateOf = this.$route.params.date;
            this.$store.dispatch('forDepositDaily', dateOf).then(function(){
                setTimeout(function(){
                    $("#daily-cash-dep").DataTable({"bSort" : false});
//                   let tableData = $("#daily-cash-dep");
//                    ClearTable(tableData.DataTable());

                },2000);

            });
            this.tableDisplay = true;
        },
        created()
        {
            if(!this.$store.getters.loggedIn)
            {
                return this.$router.push('/');
            }
        },
        computed:
            {
                forDepositDaily()
                {
                    this.show = false;

                    setTimeout(function(){
                       // $("#daily-cash-dep").DataTable({"bSort" : false});
                       // $("#daily-cash-dep").DataTable({"bSort" : false});
                      //  let tableData = $("#daily-cash-dep").DataTable();
                        //ClearTable(tableData.DataTable());

                    },1000);


                    return this.$store.state.forDepositDaily;

                }

            },
        watch: {
            $route()
            {
                let dateOf = this.$route.params.date;
                this.$store.dispatch('forDepositDaily', dateOf).then(() => {
                    this.forDepositDaily = this.$store.dispatch.forDepositDaily;
                });
            }
//            $route () {
//                     let dateOf = this.$route.params.date;
//                    let dateData = [];
//                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.$store.state.token;
//                      axios.get($baseUrl+'/api/dailyDep/'+dateOf).then(res => {
//                       // context.commit('forDepositMonth',res.data);
//                          dateData = res.data;
//                    });
//                      this.forDepositMonth = dateData;
//            }
        },

    }

    function ClearTable(table)
    {
        table.destroy();
    }
</script>