<template>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="card-title text-warning font-weight-bold">{{cardTitle}}</h4>
                </div>
                <div class="col-sm-6 text-right">
                    <button v-if="buttonTitle!==undefined" class="btn btn-outline-warning " v-on:click="buttonAction"><i :class="'fa fa-'+buttonIcon"></i> {{buttonTitle}}</button>
                </div>
            </div>
            <hr>
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CustomCard',
    props: {
        cardTitle: {
            type: String,
            required: true
        },
        buttonTitle: String,
        buttonIcon: String,
    },
    created() {

    },
    methods: {
        buttonAction: function () {
            this.$emit("button-action");
        }
    }
}
</script>

<style>

</style>
