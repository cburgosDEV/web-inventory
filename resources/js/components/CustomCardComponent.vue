<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h4 class="card-title text-primary font-weight-bold">{{cardTitle}}</h4>
                <button v-if="buttonTitle!==undefined" class="btn btn-outline-primary text-left" v-on:click="buttonAction"><i :class="'fa fa-'+buttonIcon"></i> {{buttonTitle}}</button>
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
