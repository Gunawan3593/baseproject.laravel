<template>
  <div class="table-responsive">
    <table class="table table-striped" :id="idtable" style="width: 100% !important">
      <thead>
        <tr>
          <th v-for="(column, index) in parameters.columns" v-html="title(column)" :key="index"></th>
        </tr>
      </thead>
    </table>
  </div>
</template>

<script>
  export default{
    data() {
      return {
        dataTable: {},
      }
    },
    methods: {
        title(column) {
            return column.title || this.titleCase(column.data);
        },
        titleCase(str) {
            return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
        }
    },
    computed: {
      parameters() {
        const vm = this;
        return window.$.extend({
          serverSide: true,
          processing: true
        }, {
          ajax: this.ajax,
          columns: this.columns,
          createdRow(...args) {
            vm.$emit('created-row', ...args);
          },
          drawCallback(...args) {
            vm.$emit('draw', ...args);
          },
          footerCallback(...args) {
            vm.$emit('footer', ...args);
          },
          formatNumber(...args) {
            vm.$emit('format', ...args);
          },
          headerCallback(...args) {
            vm.$emit('header', ...args);
          },
          infoCallback(...args) {
            vm.$emit('info', ...args);
          },
          initComplete(...args) {
              vm.$emit('init', ...args);
          },
          preDrawCallback(...args) {
            vm.$emit('pre-draw', ...args);
          },
          rowCallback(...args) {
            vm.$emit('draw-row', ...args);
          },
          stateLoadCallback(...args) {
            vm.$emit('state-load', ...args);
          },
          stateLoaded(...args) {
            vm.$emit('state-loaded', ...args);
          },
          stateLoadParams(...args) {
            vm.$emit('state-load-params', ...args);
          },
          stateSaveCallback(...args) {
            vm.$emit('state-save', ...args);
          },
          stateSaveParams(...args) {
            vm.$emit('state-save-params', ...args);
          },
        }, this.options);
      }
    },
    props: {
        footer: { default: false },
        columns: { type: Array },
        ajax: { default: '' },
        options: {},
        idtable: {default: 'data-table'},
    },
    created() {
      this.$eventBus.$on('reload-table', (val) => {
        this.dataTable.ajax.reload();
      });

      this.$eventBus.$on('hot-reload', (val) => {
        this.dataTable.destroy();
        this.$nextTick(function() {
          this.dataTable = window.$(`#${this.idtable}`).DataTable(this.parameters);
        })
      });
    },
    mounted() {
        this.dataTable = window.$(`#${this.idtable}`).DataTable(this.parameters);
    },
    destroyed() {
        this.dataTable.destroy();
    }
}
</script>