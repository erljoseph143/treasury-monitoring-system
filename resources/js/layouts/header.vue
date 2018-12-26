<template>
        <!-- BEGIN HEADER -->
        <div class="">
            <div class="header py-4">
                <div class="container">
                    <div class="d-flex">

                            <img :src="baseUrl+'/img/logo.png'" class="header-brand-img" alt="tabler logo">
                           <span style="margin-top:10px">Treasury Monitoring System</span>
                        <div class="d-flex order-lg-2 ml-auto">
                            <div class="dropdown">
                                <a href="#" class="btn btn-outline-success" data-toggle="dropdown" >
                                    <!--<span class="avatar" style="background-image: url(./demo/faces/female/25.jpg)"></span>-->
                                    <span class="ml-2 d-none d-lg-block" style="color:white">
                                      <span class="text-default" style="color:white"><i class="dropdown-icon fe fe-user" style="color:white"></i> {{userData.firstname}}</span>
                                      <!--<small class="text-muted d-block mt-1">Administrator</small>-->
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item" href="#">
                                        <i class="dropdown-icon fe fe-user"></i> Profile
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="dropdown-icon fe fe-settings"></i> Settings
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <span class="float-right"><span class="badge badge-primary">6</span></span>
                                        <i class="dropdown-icon fe fe-mail"></i> Inbox
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="dropdown-icon fe fe-send"></i> Message
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">
                                        <i class="dropdown-icon fe fe-help-circle"></i> Need help?
                                    </a>
                                    <router-link to="/api/logout" class="dropdown-item">
                                        <i class="dropdown-icon fe fe-log-out"></i> Sign out
                                    </router-link>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                            <span class="header-toggler-icon"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
                <div class="container">
                    <div class="row align-items-center">

                        <div class="col-lg order-lg-first">
                            <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                                <li class="nav-item">
                                    <router-link to="/cashForDeposit" class="nav-link active"><i class="fe fe-home"></i> Cash for Deposit</router-link>
                                </li>
                                <li class="nav-item">
                                    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-box"></i> Cash Release</a>
                                    <div class="dropdown-menu dropdown-menu-arrow">
                                        <a href="./cards.html" class="dropdown-item ">Cards design</a>
                                        <a href="./charts.html" class="dropdown-item ">Charts</a>
                                        <a href="./pricing-cards.html" class="dropdown-item ">Pricing cards</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-calendar"></i> Cash Deposited</a>
                                    <div class="dropdown-menu dropdown-menu-arrow">
                                        <a href="./maps.html" class="dropdown-item ">Maps</a>
                                        <a href="./icons.html" class="dropdown-item ">Icons</a>
                                        <a href="./store.html" class="dropdown-item ">Store</a>
                                        <a href="./blog.html" class="dropdown-item ">Blog</a>
                                        <a href="./carousel.html" class="dropdown-item ">Carousel</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END HEADER -->

</template>

<script>
    export default
    {
        computed:
            {
                baseUrl()
                {

                    return $baseUrl;
                },
                userData()
                {
                    //console.log($baseUrl);
                    return this.$store.getters.userData;
                }
            }
    }
</script>