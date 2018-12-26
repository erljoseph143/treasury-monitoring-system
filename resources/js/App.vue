<template>
    <div class="page-main">
        <header-top v-if="loggedIn"></header-top>
        <!-- Begin Container -->


        <div class="my-3 my-md-5">
            <div class="container">
            <router-view></router-view>
            </div>
        </div>



    </div>
</template>

<script>
    export default {

        computed:
            {
                loggedIn()
                {
                    if(this.$store.getters.loggedIn && this.userType=='Treasury')
                    {
                        return this.$store.getters.loggedIn;
                    }
                    return false;
                },
                userType()
                {
                    this.$store.dispatch('getUserData');
                    return this.$store.state.userType;
                }
            },

    }
</script>
