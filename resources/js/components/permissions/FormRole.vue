<template>
  <div>
    <div class="row">
      <div class="col-12">
        <form @submit.prevent="submit">
          <input v-if="update" type="hidden" v-model="fields.id">
          <div class="row">
            <div class="form-group col-6">
              <label>Nama Group Hak Akses</label>
              <input type="text" class="form-control" required="" v-model="fields.name" :class="{ 'is-invalid': !$v.fields.name.minLength || errors.name, 'is-valid': $v.fields.name.minLength && fields.name}">
              <div v-if="!$v.fields.name.minLength" class="invalid-feedback">
                panjang nama group akses min. {{$v.fields.name.$params.minLength.min}} karakter
              </div>
              <div v-if="errors && errors.name" class="invalid-feedback">
                {{ errors.name[0] }}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-12">
              <label>Hak Akses</label>
              <div class="selectgroup selectgroup-pills">
                <label class="selectgroup-item" v-for="(permission, index) in permissions" :key="index">
                  <input type="checkbox" :id="`permission-${index}`" v-model="fields.permission" :value="permission.id" class="selectgroup-input">
                  <span class="selectgroup-button">{{ permission.name }}</span>
                </label>
              </div>
              <div v-if="!$v.fields.permission" class="invalid-feedback">
                minimal satu hak akses dipilih
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button class="btn btn-primary" type="submit" :disabled="($v.fields.$invalid || loaded === false)">{{ buttonText }}</button>
              <button class="btn btn-danger" type="reset" v-if="!update" @click="fields = {}"> Kosongkan </button>
              <a href="/role" class="btn btn-info">Kembali Ke List</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import FormMixin from '../../assets/FormMixin';
import NotificationMixin from '../../assets/NotificationMixin';
import {required, minLength} from 'vuelidate/lib/validators';
export default {
  mixins: [ FormMixin,  NotificationMixin],
  props: ['idRole'],
  data(){
    return {
      permissions: [],
      fields : {
        permission : [],
        name: '',
        id: this.idRole
      },
      action: '/role',
      success: this.success,
      update: this.idRole
    }
  },
  validations: {
    fields : {
      name: {
        required,
        minLength: minLength(5)
      },
      permission: {
        required
      }
    }
  },
  computed: {
    buttonText: function() {
      return this.loaded ? 'Simpan':'Tunggu...';
    }
  },
  created: function()
  {
    axios.get('/permission/show').then( response => {
      this.permissions = response.data;
    });
    if (this.update) {
      this.action = '/role/update';
      axios.get('/role/show/'+this.update).then( response =>{
        this.fields.name = response.data[0].name;
        this.fields.permission = response.data[1];
      });
    }
  },
  watch: {
    success: function()
    {
      if (this.success) {
        this.$toast.success(this.response, 'Yeeyy', this.notificationSystem.options.success);
        if (!this.update) {
          this.fields = {};
          this.fields.permission = [];
        }
      } 
      
      if(this.success === false){
        this.$toast.error(this.response, 'Oppss!', this.notificationSystem.options.error);
      }
    },
  }
}
</script>