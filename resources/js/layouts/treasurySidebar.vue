<template>

        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar-wrapper">

            <div class="page-sidebar navbar-collapse collapse">
                <!-- BEGIN SIDEBAR MENU -->
                <!--@include('layouts.Treasury.sideBar')-->
                <!-- END SIDEBAR MENU -->

                <ul class="page-sidebar-menu page-sidebar-menu-light " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                    <li :class="cashForDep+' link'" id="link1" @click="linkChange(1)">
                        <router-link to="/cashForDeposit" exact id="cash-for-dep">
                            <i class="fa fa-money"></i>
                            <span class="title">Cash For Deposit</span>
                            <span class="selected"></span>
                        </router-link>
                    </li>
                    <li :class="cashRelease+' link'"  id="link2"  @click="linkChange(2)">
                        <router-link to="/cashRelease" exact>
                            <i class="icon-paper-plane"></i>
                            <span class="title">Cash Releasing</span>
                        </router-link>
                    </li>
                    <li :class="cashDeposited+' link'"  id="link3" @click="linkChange(3)">
                        <router-link to="/cashDeposited" exact>
                            <i class="icon-briefcase"></i>
                            <span class="title">Cash Deposited</span>
                        </router-link>
                    </li>

                </ul>

            </div>
        </div>
        <!-- END SIDEBAR -->

        <!-- BEGIN QUICK SIDEBAR -->
        <!--Cooming Soon...-->
        <!-- END QUICK SIDEBAR -->

</template>

<script>
    export default {

        data()
        {
            return {
                hasclass:'',
                cashForDep:'',
                cashRelease:'',
                cashDeposited:''
            }
        },
        methods:{
            linkChange(linkNo)
            {
                //$(".link").click(function(){
                    //var Handler = $(this);
                    if($("#link"+linkNo).hasClass('start')==false)
                    {
                        $(".link").removeClass('start active');
                        $(".link").find('a').remove('selected');
                        $("#link"+linkNo).addClass("start active");
                        $("#link"+linkNo).find('a').append('<span class="selected"></span>');
                    }
              //  });
                if(this.cashForDep!="" && linkNo!=1)
                {
                    this.cashForDep="";
                    if(linkNo==2)
                    {
                        this.cashRelease = "start active";
                        localStorage.setItem('active-link','cash release');
                    }
                    else if(linkNo==3)
                    {
                        this.cashDeposited = "start active";
                        localStorage.setItem('active-link','cash deposited');
                    }
                }
                else if(this.cashRelease!="" && linkNo!=2)
                {
                    this.cashRelease="";
                    if(linkNo==1)
                    {
                        this.cashForDep = "start active";
                        localStorage.setItem('active-link','cash for deposit');

                    }
                    else if(linkNo==3)
                    {
                        this.cashDeposited = "start active";
                        localStorage.setItem('active-link','cash deposited');
                    }
                }
                else if(this.cashDeposited!="" && linkNo!=3)
                {
                    this.cashDeposited="";
                    if(linkNo==1)
                    {
                        this.cashForDep = "start active";
                        localStorage.setItem('active-link','cash for deposit');
                    }
                    else if(linkNo==2)
                    {
                        this.cashRelease = "start active";
                        localStorage.setItem('active-link','cash release');
                    }
                }
                else
                {
                    let linkActive = localStorage.getItem('active-link');
                    if(linkActive == "cash for deposit")
                    {
                        this.cashForDep = "start active";
                        $("#link1").find('a').append('<span class="selected"></span>');
                    }
                    else if(linkActive == "cash release")
                    {
                        this.cashRelease = "start active";
                        $("#link2").find('a').append('<span class="selected"></span>');
                    }
                    else if(linkActive == "cash deposited")
                    {
                        this.cashDeposited = "start active";
                        $("#link3").find('a').append('<span class="selected"></span>');
                    }
                }

            }
        },
        mounted()
        {
            let linkActive = localStorage.getItem('active-link');
            if(linkActive == "cash for deposit")
            {
                this.cashForDep = "start active";
                $("#link1").find('a').append('<span class="selected"></span>');
            }
            else if(linkActive == "cash release")
            {
                this.cashRelease = "start active";
                $("#link2").find('a').append('<span class="selected"></span>');
            }
            else if(linkActive == "cash deposited")
            {
                this.cashDeposited = "start active";
                $("#link3").find('a').append('<span class="selected"></span>');
            }
            else
            {
                this.cashForDep = "start active";
            }
        }
    }
</script>