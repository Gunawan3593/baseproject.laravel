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
              <label>Kode</label>
              <input type="text" class="form-control" value="" required="" v-model="fields.page_code" :class="{ 'is-invalid': !$v.fields.page_code.minLength || errors.page_code, 'is-valid': $v.fields.page_code.minLength && fields.page_code}">
              <div v-if="!$v.fields.page_code.minLength" class="invalid-feedback">
                panjang kode min. {{$v.fields.page_code.$params.minLength.min}} karakter
              </div>
              <div v-if="errors && errors.page_code" class="invalid-feedback">
                {{ errors.page_code[0] }}
              </div>
            </div>
            <div class="form-group">
              <label>Judul</label>
              <input type="text" class="form-control" value="" required="" v-model="fields.page_title" :class="{ 'is-invalid': !$v.fields.page_title.minLength || errors.page_title, 'is-valid': $v.fields.page_title.minLength && fields.page_title}">
              <div v-if="!$v.fields.page_title.minLength" class="invalid-feedback">
                panjang judul min. {{$v.fields.page_title.$params.minLength.min}} karakter
              </div>
              <div v-if="errors && errors.page_title" class="invalid-feedback">
                {{ errors.page_title[0] }}
              </div>
            </div>
            <div class="form-group">
              <label>Deskripsi</label>
              <textarea class="form-control" value="" required="" v-model="fields.page_description"></textarea>
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
        {data: 'page_code', name: 'page_code', title: 'Kode'},
        {data: 'page_title', name:'page_title', title: 'Judul'},
        {data: 'page_description', name:'page_description', title: 'Deskripsi'},
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
      ajax: '/pageData',
      options:{
        order: [0, 'desc' ],
        lengthMenu: [[10, 25, 50, -1], ['10', '25', '50', "All"]]
      },
      action: '/page',
      success: this.success,
      title: 'Tambah Data'
    }
  },
  validations: {
    fields:{
      page_code: {
        required,
        minLength: minLength(5),
      },
      page_title: {
        required,
        minLength: minLength(5),
      },
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
      this.action = '/page';
      this.fields = {};
      this.title = 'Tambah Data';
    }
  },
  watch: {
    success: function()
    {
      if (this.success) {
        this.fields = {};
        this.action = '/page';
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
        this.action = '/page/update';
        $('#form-modal').modal('show');
      }
    }
  },
  created() {
    this.$eventBus.$on('delete', (val) => {
      this.action = '/page';
      let url = `${this.action}/${val}`;
      this.delete(url);
    });
    this.$eventBus.$on('edit', (val) => {
      this.action = '/page';
      let url = `${this.action}/${val}/edit`;
      this.edit(url);
    });
  }
}
</script>