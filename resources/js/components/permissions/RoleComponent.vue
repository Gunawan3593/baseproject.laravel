<template>
  <div>
    <div class="row" style="margin-bottom:15px;" v-if="accAdd">
      <div class="col-12">
        <a class="btn btn-primary float-right" href="role/create">Tambah</a>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <table-component :columns="columns" :ajax="ajax" :options="options" @created-row="createdRow"></table-component>
      </div>
    </div>
  </div>
</template>

<script>
import FormMixin from '../../assets/FormMixin';
import NotificationMixin from '../../assets/NotificationMixin';
export default {
  mixins: [ FormMixin,  NotificationMixin],
  props: ['accAdd'],
  data(){
    return {
      columns: [
        {data: 'id', name: 'id', title: '#', searchable: false},
        {data: 'name', name: 'name', title: 'Group Hak Akses'},
        {data: 'created_at', name:'created_at', title: 'Dibuat'},
        {
          data: 'action',
          orderable: false,
          searchable: false,
          createdCell(cell, cellData, rowData) {
            let DeleteButton = Vue.extend(require('../ui/ButtonDelete').default);
            let delact = new DeleteButton({
                propsData: rowData,
            });
            delact.$mount();
            let editact = `<a class="btn btn-info" href="/role/${rowData.id}/edit"><i class="fa fa-pen"></i></a>`;
            if (rowData.accEdit) {
              $(cell).empty().append(editact);
            }
            $(cell).append(' ');
            if (rowData.accDelete) {
              $(cell).append(delact.$el);
            }
          }
        }
      ],
      ajax: '/roleData',
      options:{
        order: [0, 'desc' ],
        lengthMenu: [[10, 25, 50, -1], ['10', '25', '50', "All"]]
      },
      action: '/permission',
      success: this.success,
      title: 'Tambah Data'
    }
  },
  computed: {
    buttonText: function() {
      return this.loaded ? 'Simpan':'Tunggu...';
    }
  },
  methods:{
    createdRow: function (row, data, index) {
      $('td', row).eq(0).html(index + 1)
    },
    reloadTable: function() {
      this.$eventBus.$emit('reload-table');
    }
  },
  watch: {
    success: function()
    {
      if (this.success) {
        this.reloadTable();
        this.$toast.success(this.response, 'Yeeyy', this.notificationSystem.options.success);
      } 
      
      if(this.success === false){
        this.$toast.error(this.response, 'Oppss!', this.notificationSystem.options.error);
      }
    }
  },
  created() {
    this.$eventBus.$on('delete', (val) => {
      this.action = '/role';
      let url = `${this.action}/${val}`;
      this.delete(url);
    });
  }
}
</script>