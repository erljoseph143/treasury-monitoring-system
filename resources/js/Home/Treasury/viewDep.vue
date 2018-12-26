<template>
    <div class="row row-cards">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> Cash and Checks received for {{dateReceive | moment("MMMM DD, YYYY")}}</h3>
                </div>
                <loading :active="show" spinner="bar-fade-scale" color="#FF6700"/>
                <form  @submit.prevent="allLogsData" method="post" id="all-logs-data">
                    <input type="hidden" name="salesDate" :value="dateReceive">
                <div class="row">

                    <div class="col-md-6">
                        <div class="table-responsive">

                            <table class="table table-condensed table-hover" id="viewDep-checks">
                                <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Trans Type</th>
                                    <th>Amount</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="data in forViewDep[0]">
                                    <td>
                                        <label @click="checkClass(data.check_class,dateReceive)" class="linkCheck" v-b-modal.modal1>{{data.check_class}}</label>
                                        <input type="hidden" name="check_type[]" :value="data.check_class">
                                    </td>
                                    <td>
                                        {{data.check_from}}
                                        <input type="hidden" name="check_from[]" :value="data.check_from">
                                    </td>
                                    <td style="text-align:right">
                                        {{String(data.check_amt_total).replace(/\B(?=(\d{3})+(?!\d))/g,',')}}
                                        <input type="hidden" name="check_total_amount[]" :value="data.check_amt_total">
                                    </td>
                                </tr>
                                <tr v-for="cpolg in forViewDep[1]">
                                    <td>
                                        CPO Payment for {{ cpolg.cpo_date | moment("MM/DD/YYYY")}}
                                        <input type="hidden" name="check_type[]" :value="cpolg.cpo_date">
                                    </td>
                                    <td>
                                        {{ cpolg.check_no }}
                                        <input type="hidden" name="check_from[]" :value="cpolg.check_no">
                                    </td>
                                    <td style="text-align:right">
                                        {{ String(cpolg.cpo_amount).replace(/\B(?=(\d{3})+(?!\d))/g,',') }}
                                        <input type="hidden" name="check_total_amount[]" :value="cpolg.cpo_amount">
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover" id="viewDep-cash">
                                <thead>
                                <tr>
                                    <th >Type</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody id="tbody-adj">
                                    <tr>
                                        <td>
                                            Cash For Deposit
                                            <input type="hidden" name="cash_dep[]" value="Cash For Deposit">
                                        </td>
                                        <td id="cash-dep" class="adj" style="text-align:right">
                                            {{String(forViewDep[2]).replace(/\B(?=(\d{3})+(?!\d))/g,',')}}
                                            <input type="hidden" name="cash_summary_amount[]" :value="forViewDep[2]">
                                        </td>
                                    </tr>
                                    <tr v-for="adj in forViewDep[4]">
                                        <td>
                                            {{adj[1]}}
                                            <input type="hidden" name="cash_dep[]" :value="adj[1]">
                                        </td>
                                        <td style="text-align:right">
                                            {{String(adj[2]).replace(/\B(?=(\d{3})+(?!\d))/g,',')}}
                                            <input type="hidden" name="cash_summary_amount[]" :value="adj[2]">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row " style="padding:10px">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="caption-subject font-green-sharp bold uppercase" for="">TOTAL:</label>
                            </div>
                            <div class="col-sm-8" style="text-align:right">
                                {{String(forViewDep[5]).replace(/\B(?=(\d{3})+(?!\d))/g,',')}}
                                <input type="hidden" name="total_check" :value="forViewDep[5]">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="caption-subject font-green-sharp bold uppercase" for="">TOTAL:</label>
                            </div>
                            <div class="col-sm-8" style="text-align:right">
                                {{String(forViewDep[7]).replace(/\B(?=(\d{3})+(?!\d))/g,',')}}
                                <input type="hidden" name="total_cash_summary" :value="forViewDep[7]">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="sales-data" class="table table-bordered table-striped" style="font-size: medium;">
                                <thead>
                                <tr>
                                    <th>Department</th>
                                    <th>Sales Date</th>
                                    <th>DS Number</th>
                                    <th>Amount</th>
                                    <th>Final Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(cs,index) in forViewDep[6]" v-if="cs.cash_log=='SUPERMARKET'">
                                        <td>
                                            {{cs.cash_log}}
                                            <input type="hidden" name="department[]" :value="cs.cash_log">
                                        </td>
                                        <td>{{cs.sales_date | moment("MM/DD/YYYY") }}</td>
                                        <td>
                                            <input type="text" name="dsno[]" class="form-control" value="" placeholder="Enter DS No">
                                        </td>
                                        <td style="text-align:right">
                                            {{String(cs.totalCash).replace(/\B(?=(\d{3})+(?!\d))/g,',')}}
                                            <input type="hidden" name="SMamount[]" :value="cs.totalCash">
                                        </td>
                                        <td> </td>
                                    </tr>

                                    <tr v-for="(data,index) in forViewDep[4]" v-if="data[1]!='Due Checks'">
                                        <td colspan="3" style="text-align:right">
                                            {{data[1]}}
                                            <input type="hidden" name="adjustment[]" :value="data[1]">
                                        </td>
                                        <td style="text-align:right">
                                            {{String(data[2]).replace(/\B(?=(\d{3})+(?!\d))/g,',')}}
                                            <input type="hidden" name="adjAmount[]" :value="data[2]">
                                        </td>
                                        <td v-if="index == getTheMaxIndex(forViewDep[4])" style="text-align:right">
                                            {{String(forViewDep[8]).replace(/\B(?=(\d{3})+(?!\d))/g,',')}}
                                            <input type="hidden" name="amount[]" :value="forViewDep[8]">
                                        </td>
                                        <td v-else></td>
                                    </tr>

                                    <tr v-for="(cs,index) in forViewDep[6]" v-if="cs.cash_log!='SUPERMARKET'">
                                        <td>
                                            {{cs.cash_log}}
                                            <input type="hidden" name="department[]" :value="cs.cash_log">
                                        </td>
                                        <td>{{cs.sales_date | moment("MM/DD/YYYY") }}</td>
                                        <td>
                                            <input type="text" class="form-control" name="dsno[]" value="" placeholder="Enter DS No">
                                        </td>
                                        <td></td>
                                        <td style="text-align:right">
                                            {{String(cs.totalCash).replace(/\B(?=(\d{3})+(?!\d))/g,',')}}
                                            <input type="hidden" name="amount[]" :value="cs.totalCash">
                                        </td>
                                    </tr>

                                    <tr v-for="cash in forViewDep[3]">
                                        <td v-if="cash.cash_log.description == 'AR#'">{{cash.cash_log.description + " " +cash.ar_from +" to "+cash.ar_to}}</td>
                                        <td v-else>{{cash.cash_log.description}}</td>
                                        <td>{{cash.sales_date | moment("MM/DD/YYYY") }}</td>
                                        <td>{{cash.ds_no}}</td>
                                        <td></td>
                                        <td style="text-align:right">
                                            {{String(cash.amount_edited).replace(/\B(?=(\d{3})+(?!\d))/g,',')}}
                                            <input type="hidden" name="amount[]" :value="cash.amount_edited">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-outline-primary btn-sm float-right" v-if="forCashLog.length!=0" v-b-modal.cashLogs>
                                <i class="fe fe-file-plus"></i>    Add Cash Logs
                            </button>
                                <br/>
                                <br/>
                                <button class="btn btn-info" type="submit">
                                    <i class="fe fe-file-plus"></i>   Post this all data
                                </button>

                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <!-- Modal Component -->
        <b-modal id="modal1" size="lg" title="Check Details" hide-header-close>
            <table class="table table-condensed table-hover" id="check-details">
                <thead>
                <tr>
                    <th>Description</th>
                    <th>Check Date</th>
                    <th>Trans ID</th>
                    <th>Check No</th>
                    <th>Amount</th>

                </tr>
                </thead>
                <tbody>
                <tr v-for="checks in forCheckClass">
                    <td>
                        {{checks.check_class}}
                    </td>
                    <td>{{checks.check_date | moment("MM/DD/YYYY")}}</td>
                    <td>{{checks.checksreceivingtransaction_id}}</td>
                    <td>{{checks.check_no}}</td>
                    <td style="text-align:right">{{String(checks.check_amount).replace(/\B(?=(\d{3})+(?!\d))/g,',')}}</td>
                </tr>

                </tbody>
            </table>
        </b-modal>

        <!-- Adding New Cash Logs Modal -->
        <!--<b-modal id="cashLogs" size="lg" title="Add Cash Logs" hide-header-close  @ok="addToLogs" ok-title="Add">-->
        <b-modal id="cashLogs" ref="cashLogs" size="lg" title="Add Cash Logs" hide-header-close hide-footer>

            <fieldset class="form-fieldset">

                <div class="form-group">
                    <label class="form-label">Department<span v-if="validation.depError" class="form-required">* Department is required</span></label>
                    <select name="cash_log" class="form-control custom-select" @change="getDepartment" ref="dep" v-model="department">
                        <option value="" data-department="">-------------------Select Department----------------------</option>
                        <option v-for="cashLog in forViewDep[9]" :data-department="cashLog.description" :value="cashLog.id">{{cashLog.description}}</option>
                    </select>
                </div>

                <div class="row" v-show="showAR">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">From: </label>
                            <input type="text" name="from" ref="ARfrom" class="form-control" v-model="ArFrom">
                            <span v-if="validation.ARFromError" class="form-required">* AR from is required</span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">To: </label>
                            <input type="text" name="to" ref="ARto" class="form-control" v-model="ArTo">
                            <span v-if="validation.ARtoError" class="form-required">* AR to is required</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Sales Date<span v-if="validation.dateError" class="form-required">* Sales date is required</span></label>
                    <input type="text" ref="salesDate"  id="sales_date" class="form-control" :value="dateReceive"  readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">DS # <span v-if="validation.dsnoError" class="form-required">* DS # is required</span></label>
                    <input type="text" class="form-control" ref="dsno" v-model="dsNo" />
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Amount <span v-if="validation.amountError" class="form-required">* Amount is required</span></label>
                    <input type="text" id="amount" ref="amount" class="form-control" v-model="amount" style="text-align:right"/>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-danger" @click="closeModal">Close</button>
                    <button class="btn btn-outline-primary" @click="addToLogs">Add</button>
                </div>
            </fieldset>
        </b-modal>

    </div>
</template>

<script>
    export default {
        data()
            {
                return {
                    cashLogs:'',
                    show:false,
                    dateReceive:'',
                    amount:'',
                    sales_date:'',
                    dsNo:'',
                    ArFrom:'',
                    ArTo:'',
                    department:'',
                    depName:'',
                    showAR:false,
                    validation:{
                        depError    :false,
                        ARFromError :false,
                        ARtoError   :false,
                        dateError   :false,
                        dsnoError   :false,
                        amountError :false
                    }
                }
            },
        mounted()
            {
                this.show = true;
                let dateOf = this.$route.params.date;
                let dateOf1 = dateOf.split('-');
                this.dateReceive = dateOf1[1]+'/'+dateOf1[2]+'/'+dateOf1[0];

                this.$store.dispatch('forViewDep',dateOf).then(res=>{
                   // console.log(this.$store.getters.forViewDep);
                });



            },
        computed:
            {
                forViewDep()
                {
                    if(this.$store.getters.forViewDep[9] != undefined)
                    {
                        this.cashLogs = this.$store.getters.forViewDep[9];
                    }
                    this.show = false;
                    return this.$store.getters.forViewDep;
                },
                forCheckClass()
                {
                    return this.$store.getters.forCheckClass;
                },
                forCashLog()
                {
                    return this.cashLogs;
                }
            },
        created()
            {
                if(!this.$store.getters.loggedIn)
                {
                    return this.$router.push('/');
                }
                $(document).ready(function(){
                    setTimeout(function(){
                        $("#sales_date").datepicker(
                            {
                                format: 'mm/dd/yyyy',
                                endDate: '+0d',
                                autoclose: true
                            }
                        );

                        $("#amount").maskMoney();
                    },1000);
                });


            },
        methods:
            {
                closeModal()
                {
                    this.validation.depError    = false;
                    this.validation.ARFromError = false;
                    this.validation.ARtoError   = false;
                    this.validation.dateError   = false;
                    this.validation.dsnoError   = false;
                    this.validation.amountError = false;

                    let dateOf                  = this.$route.params.date;
                    let dateOf1                 = dateOf.split('-');
                    this.$refs.salesDate.value  = dateOf1[1]+'/'+dateOf1[2]+'/'+dateOf1[0];
                    this.$refs.ARfrom.value     = "";
                    this.$refs.ARto.value       = "";
                    this.$refs.dsno.value       = "";
                    this.$refs.amount.value     = "";
                    this.$refs.cashLogs.hide();
                },
                checkClass(ckClass,date)
                {
                    this.$store.dispatch('forCheckClass',ckClass,date).then(res => {
                        setTimeout(function(){
                          let table =  $("#check-details").DataTable();
                            ClearTable(table);
                            $("#check-details").DataTable();
                        },500)
                    });
                },
                getTheMaxIndex(array)
                {
                    return array.reduce((iMax, x, i, arr) => x > arr[iMax] ? i : iMax, 0);
                },
                getDepartment(e) {
                    if(e.target.options.selectedIndex > -1)
                    {
                        let dep = e.target.options[e.target.options.selectedIndex].dataset.department;
                        this.depName = dep;
                        if(dep =="AR#")
                        {
                            this.showAR = true;
                        }
                        else
                        {
                            this.showAR = false;
                        }
                    }

                },
                addToLogs()
                {
                    this.validation.depError    = false;
                    this.validation.ARFromError = false;
                    this.validation.ARtoError   = false;
                    this.validation.dateError   = false;
                    this.validation.dsnoError   = false;
                    this.validation.amountError = false;

                    let dateOf     = this.$route.params.date;

                    let salesDate  = this.$refs.salesDate.value;
                    let ARfrom     = this.$refs.ARfrom.value;
                    let ARto       = this.$refs.ARto.value;
                    let DSNo       = this.$refs.dsno.value;
                    let amount     = this.$refs.amount.value;

                    if(this.$refs.dep.value=="")
                    {
                        this.$refs.dep.focus();
                        this.validation.depError = true;
                        return false;
                    }

                    if(this.depName=="AR#")
                    {
                        if(ARfrom=="")
                        {
                            this.$refs.ARfrom.focus();
                            this.validation.ARFromError = true;
                            return false;
                        }
                        if(ARto =="")
                        {
                            this.$refs.ARto.focus();
                            this.validation.ARtoError  = true;
                            return false;
                        }
                    }

                    if(salesDate=="")
                    {
                        this.$refs.salesDate.focus();
                        this.validation.dateError   = true;
                        return false;
                    }

                    if(DSNo == "")
                    {
                        this.$refs.dsno.focus();
                        this.validation.dsnoError   = true;
                        return false;
                    }

                    if(amount=="")
                    {
                        this.$refs.amount.focus();
                        this.validation.amountError = true;
                        return false;
                    }

                    let salesData  = {
                                        'sales_date':salesDate,
                                        'ds_no':DSNo,
                                        'amount':amount,
                                        'amount_edited':amount,
                                        'ar_from':ARfrom,
                                        'ar_to':ARto,
                                        'cash_id':this.department,
                                        'dateOf':dateOf
                                    };
                    let $this = this;
                    this.$dialog.confirm('Are you sure of the data you entered?')
                        .then(function (dialog) {
                            $this.$store.dispatch('forAddCashLog',salesData);
                            $this.closeModal();
                        })
                        .catch(function () {
                            console.log('Error in adding cash log')
                        });


                },
                allLogsData()
                {
                    let form     = document.getElementById("all-logs-data");
                    let formData = new FormData(form);
                    this.$store.dispatch('allLogsData',formData);
                }
            }
    }

    function ClearTable(table)
    {
        table.destroy();
    }



//    function getTheMaxIndex(array)
//    {
//        return a.reduce((iMax, x, i, arr) => x > arr[iMax] ? i : iMax, 0);
//    }

//    let a = [0, 21,30,102];
//    let indexOfMaxValue = a.reduce((iMax, x, i, arr) => x > arr[iMax] ? i : iMax, 0);
//    console.log("indexOfMaxValue = " + indexOfMaxValue);
//    //document.write("indexOfMaxValue = " + indexOfMaxValue);
</script>

<style scoped="">
    .linkCheck{
        color: #295a9f;
        cursor:pointer;
    }
    .linkCheck:hover {
        color: #295a9f;
        text-decoration: underline;
    }
</style>