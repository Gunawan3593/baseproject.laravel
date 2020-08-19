<template>
  <div>
    <div class="row">
      <div class="col-12">
        <form @submit.prevent="submit">
          <input v-if="update" type="hidden" v-model="fields.id">
          <div class="row">
            <div class="col-6">
              <div class="row">
                <div class="form-group col-12">
                  <label>Nama Pengguna</label>
                  <input type="text" class="form-control" required="" v-model="fields.name" 
                  :class="{ 'is-invalid': !$v.fields.name.minLength || errors.name || !$v.fields.name.required, 'is-valid': $v.fields.name.minLength && fields.name}">
                  <div v-if="!$v.fields.name.minLength" class="invalid-feedback">
                    panjang nama pengguna min. {{$v.fields.name.$params.minLength.min}} karakter
                  </div>
                   <div v-if="!$v.fields.name.required" class="invalid-feedback">
                    nama pengguna wajib isi
                  </div>
                  <div v-if="errors && errors.name" class="invalid-feedback">
                    {{ errors.name[0] }}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-12">
                  <label>Email</label>
                  <input type="email" class="form-control" required="" v-model="fields.email" :class="{ 'is-invalid': errors.email || !$v.fields.email.email || !$v.fields.email.required, 'is-valid': fields.email}" autocomplete="off">
                  <div v-if="!$v.fields.email.email" class="invalid-feedback">
                    masukkan email yang benar
                  </div>
                  <div v-if="!$v.fields.email.required" class="invalid-feedback">
                    email wajib isi
                  </div>
                  <div v-if="errors && errors.email" class="invalid-feedback">
                    {{ errors.email[0] }}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-12">
                  <label>Sandi</label>
                  <input type="password" class="form-control" 
                    v-model="fields.password" 
                    :class="{ 'is-invalid': errors.password || !$v.fields.password.required || !$v.fields.password.minLength, 'is-valid': fields.password}" autocomplete="new-password">
                  <div v-if="!$v.fields.password.minLength" class="invalid-feedback">
                    panjang sandi min. {{$v.fields.password.$params.minLength.min}} karakter
                  </div>
                  <div v-if="!$v.fields.password.required" class="invalid-feedback">
                    sandi harus diisi
                  </div>
                  <div v-if="errors && errors.password" class="invalid-feedback">
                    {{ errors.password[0] }}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-12">
                  <label>Ulangi Sandi</label>
                  <input type="password" class="form-control" v-model="fields.repeat_password"
                  :class="{ 'is-invalid': errors.repeat_password || $v.fields.repeat_password.$error || !$v.fields.repeat_password.sameAsPassword, 'is-valid': $v.fields.repeat_password.sameAsPassword }"
                  >
                  <div v-if="!$v.fields.repeat_password.sameAsPassword" class="invalid-feedback">
                    sandi tidak sesuai
                  </div>
                  <div v-if="errors && errors.repeat_password" class="invalid-feedback">
                    {{ errors.repeat_password[0] }}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-12">
                  <label>Group Hak Akses</label>
                  <div class="selectgroup selectgroup-pills">
                    <label class="selectgroup-item" v-for="(role, index) in roles" :key="index">
                      <input type="checkbox" :id="`role-${index}`" v-model="fields.role" :value="role" class="selectgroup-input">
                      <span class="selectgroup-button">{{ role }}</span>
                    </label>
                  </div>
                  <div v-if="!$v.fields.role" class="invalid-feedback">
                    minimal satu group hak akses dipilih
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <button class="btn btn-primary" type="submit" :disabled="($v.fields.$invalid || loaded === false)">{{ buttonText }}</button>
                  <button class="btn btn-danger" type="reset" v-if="!update" @click="fields = {}"> Kosongkan </button>
                  <a href="/user" class="btn btn-info">Kembali Ke List</a>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="row">
                <div class="form-group col-12">
                  <label>Avatar</label>
                  <image-uploader
                    :debug="1"
                    :max-width="300"
                    :quality="0.7"
                    :auto-rotate=true
                    output-format="verbose"
                    :preview=true
                    :class-name="['form-control', { 'fileinput--loaded' : hasImage }]"
                    :capture="false"
                    accept="image/*"
                    doNotResize="['gif', 'svg']"
                    @input="setImage"
                  >
                  </image-uploader>
                </div>
              </div>
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
import {required, minLength, email, sameAs, requiredIf} from 'vuelidate/lib/validators';
export default {
  mixins: [ FormMixin,  NotificationMixin],
  props: ['idUser'],
  data(){
    return {
      roles: [],
      fields : {
        id: this.idUser,
        name: '',
        email: '',
        repeat_password: '',
        role: []
      },
      action: '/user',
      success: this.success,
      update: this.idUser,
      hasImage: false,
    }
  },
  validations: {
    fields : {
      name: {
        required,
        minLength: minLength(5)
      },
      email: {
        required,
        email
      },
      password: {
        required: requiredIf( function (){
          return this.idUser ? false:true;
        }),
        minLength: minLength(8)
      },
      repeat_password: {
        sameAsPassword: sameAs('password')
      },
      role: {
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
    axios.get('/role/list').then( response => {
      this.roles = response.data;
    });

    if (this.update) {
      this.action = '/user/update';
      axios.get('/user/show/'+this.update).then( response =>{
        this.fields = response.data[0];
        this.fields.role = response.data[1];
        this.fields.image = '';
      });
    }
  },
  methods: {
    setImage: function(file)
    {
      this.hasImage = true;
      this.fields.image = file.dataUrl;
    }
  },
  watch: {
    success: function()
    {
      if (this.success) {
        this.$toast.success(this.response, 'Yeeyy', this.notificationSystem.options.success);
        if (!this.update) {
          this.fields = {};
        }
      } 
      
      if(this.success === false){
        this.$toast.error(this.response, 'Oppss!', this.notificationSystem.options.error);
      }
    },
  }
}
</script>