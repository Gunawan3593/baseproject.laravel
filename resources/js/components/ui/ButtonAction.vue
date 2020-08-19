<template>
    <div class="dropdown d-inline">
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Action
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item has-icon" v-if="editAct" :href="`/${uri}/${id}/edit`"><i class="fa fa-pen"></i> Edit</a>
            <a class="dropdown-item has-icon" v-if="detailAct" :href="`/${uri}/${id}/detail`"><i class="fa fa-eye"></i> Detail</a>
            <a class="dropdown-item has-icon" v-if="printAct" :href="`/${uri}/${id}/print`" target="_blank"><i class="fa fa-print"></i> Cetak</a>
            <a class="dropdown-item has-icon" v-if="deleteAct" href="#" @click="deleteData"><i class="fa fa-trash"></i> Delete</a>
        </div>
    </div>
</template>

<script>
    export default{
        props: ['id', 'accEdit', 'accDetail', 'accPrint', 'accDelete', 'uri'],
        methods: {
            deleteData() {
                this.$eventBus.$emit('delete', this.id);
            }
        },
        computed: {
            editAct: function() {
                return typeof this.accEdit != 'undefined' && this.accEdit == true ? true:false; 
            },
            detailAct: function() {
                return typeof this.accDetail != 'undefined' && this.accDetail == true ? true:false; 
            },
            printAct: function() {
                return typeof this.accPrint != 'undefined' && this.accPrint == true ? true:false; 
            },
            deleteAct: function() {
                return typeof this.accDelete != 'undefined' && this.accDelete == true ? true:false; 
            },
        },
        created: function() {
            console.log(this.accDelete);
        }
    }
</script>