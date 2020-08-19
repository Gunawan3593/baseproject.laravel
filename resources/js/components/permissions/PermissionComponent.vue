<template>
  <div>
    <div class="row" style="margin-bottom:15px;" v-if="accAdd">
      <div class="col-12">
        <button class="btn btn-primary float-right" @click="addData">Tambah</button>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <table-component :columns="columns" :ajax="ajax" :options="options" @created-row="createdRow"></table-component>
      </div>
    </div>
    <portal to="portal-modal">
      <modal-component>
        <span slot="title">
          {{ title }}
        </span>
        <div slot="body">
          <form @submit.prevent="submit">
            <input v-if="update" type="hidden" v-model="fields.id">
            <div class="form-group">
              <label>Hak Akses</label>
              <input type="text" class="form-control" value="" required="" v-model="fields.name" :class="{ 'is-invalid': !$v.fields.name.minLength, 'is-valid': $v.fields.name.minLength && fields.name}">
              <div v-if="!$v.fields.name.minLength" class="invalid-feedback">
                panjang hak akses min. {{$v.fields.name.$params.minLength.min}} karakter
              </div>
            </div>
          </form>
        </div>
        <div slot="button">
          <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button @click="submit" type="button" class="btn btn-primary" :disabled="($v.fields.$invalid || loaded === false)">{{ buttonText }}</button>
        </div>
      </modal-component>
    </portal>
  </div>
</template>

<script>
import FormMixin from '../../assets/FormMixin';
import NotificationMixin from '../../assets/NotificationMixin';
import {required, minLength} from 'vuelidate/lib/validators';
export default {
  mixins: [ FormMixin,  NotificationMixin],
  props: ['accAdd'],
  data(){
    return {
      columns: [
        {data: 'id', name: 'id', title: '#', searchable: false},
        {data: 'name', name: 'name', title: 'Hak Akses'},
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

            let EditButton = Vue.extend(require('../ui/ButtonEdit').default);
            let editact = new EditButton({
                propsData: rowData,
            });
            editact.$mount();
            if (rowData.accEdit) {
              $(cell).empty().append(editact.$el);
            }
            $(cell).append(' ');
            if (rowData.accDelete) {
              $(cell).append(delact.$el);
            }
          }
        }
      ],
      ajax: '/permissionData',
      options:{
        order: [0, 'desc' ],
        lengthMenu: [[10, 25, 50, -1], ['10', '25', '50', "All"]]
      },
      action: '/permission',
      success: this.success,
      title: 'Tambah Data'
    }
  },
  validations: {
    fields:{
      name: {
        required,
        minLength: minLength(5),
      }
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
    }, 
    addData: function(){
      $('#form-modal').modal('show');
      this.action = '/permission';
      this.fields = {};
      this.title = 'Tambah Data';
    }
  },
  watch: {
    success: function()
    {
      if (this.success) {
        this.fields = {};
        this.action = '/permission';
        this.reloadTable();
        this.$toast.success(this.response, 'Yeeyy', this.notificationSystem.options.success);
        $('#form-modal').modal('hide');
      } 
      
      if(this.success === false){
        this.$toast.error(this.response, 'Oppss!', this.notificationSystem.options.error);
      }
    },
    update: function()
    {
      if (this.update) {
        this.title = 'Edit Data';
        this.action = '/permission/update';
        $('#form-modal').modal('show');
      }
    }
  },
  created() {
    this.$eventBus.$on('delete', (val) => {
      this.action = '/permission';
      let url = `${this.action}/${val}`;
      this.delete(url);
    });
    this.$eventBus.$on('edit', (val) => {
      this.action = '/permission';
      let url = `${this.action}/${val}/edit`;
      this.edit(url);
    });
  }
}
</script>