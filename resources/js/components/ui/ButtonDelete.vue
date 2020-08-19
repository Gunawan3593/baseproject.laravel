<template>
    <button class="btn btn-danger" @click="deleteData">
        <i class="fa fa-trash"></i>
    </button>
</template>

<script>
    export default{
        props: ['id'],
        methods: {
            deleteData() {
                this.$eventBus.$emit('delete', this.id);
            }
        },
    }
</script>