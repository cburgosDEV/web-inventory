<template>
    <div class="d-flex justify-content-center mb-3">
        <div class="search">
            <input type="text" class="search-input" placeholder="Buscar..." name="filterText" v-on:keypress.enter="search" v-model="filterText">
            <a class="search-icon" v-on:click="search"><i class="fa fa-search"></i></a>
        </div>
    </div></template>
<script>
export default {
    name: 'SearchBar',
    props: {

    },
    data() {
        return {
            filterText: ''
        }
    },
    methods: {
        search: function (){
            this.$emit("search", this.filterText);
        }
    }
}
</script>

<style>
    .search {
        width: 100%;
        margin-bottom: auto;
        margin-top: 20px;
        height: 50px;
        background-color: #EEEEEE;
        padding: 10px;
        border-radius: 5px;
    }

    .search-input {
        color: white;
        border: 0;
        outline: 0;
        background: none;
        width: 0;
        margin-top: 5px;
        caret-color: transparent;
        line-height: 20px;
        transition: width 0.4s linear;
    }

    .search .search-input {
        padding: 0 10px;
        width: 100%;
        caret-color: #536bf6;
        font-size: 19px;
        font-weight: 300;
        color: black;
        transition: width 0.4s linear;
    }

    .search-icon {
        height: 34px;
        width: 34px;
        float: right;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        background-color: #536bf6;
        font-size: 10px;
        bottom: 30px;
        position: relative;
        border-radius: 5px;
    }

    .search-icon:hover {
        text-decoration: none;
        background: #3046ff;
        cursor: pointer;
        color: #fff !important
    }

    a:link {
        text-decoration: none
    }
</style>
