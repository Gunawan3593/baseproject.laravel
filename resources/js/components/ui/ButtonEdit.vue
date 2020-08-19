<template>
    <button class="btn btn-info" @click="editData">
        <i class="fa fa-pen"></i>
    </button>
</template>

<script>
    export default{
        props: ['id'],
        methods: {
            editData() {
                this.$eventBus.$emit('edit', this.id);
            }
        },
    }
</script>