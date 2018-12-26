<template>
    <!-- Begin Container -->
    <div class="page-container">
        <slot></slot>
    </div>
    <!-- END CONTAINER -->
</template>

<script>
    export default {

        computed:
            {
                loggedIn()
                {
                    return this.$store.getters.loggedIn;
                }
            }

    }
</script>