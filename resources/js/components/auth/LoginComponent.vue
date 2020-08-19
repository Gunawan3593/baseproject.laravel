<template>
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <!-- <img src="../assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle"> -->
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Login</h4></div>

              <div class="card-body">
                <form @submit.prevent="submit">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input v-model="fields.email" id="email" type="email" class="form-control" :class="{ 'is-invalid': errors.email}" tabindex="1" required autofocus>
                    <div v-if="errors && errors.email" class="invalid-feedback">
                      {{ errors.email[0] }}
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                    	<label for="password" class="control-label">Password</label>
                    </div>
                    <input v-model="fields.password" id="password" type="password" class="form-control" :class="{ 'is-invalid': errors.password}" tabindex="2" required>
                    <div v-if="errors && errors.password" class="invalid-feedback">
                      {{ errors.password[0] }}
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input v-model="fields.remember" type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <button-component :class="'btn-primary btn-lg btn-block'" :type="'submit'" :disabled="loaded === false">
                      {{ buttonText }}
                    </button-component>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; Bali Sejahtera 2020
            </div>
          </div>
        </div>
      </div>
    </section>
</template>
<script>
import FormMixin from '../../assets/FormMixin';
export default {
  mixins: [ FormMixin ],
  data() {
    return {
      action: '/login',
      success: this.success
    }
  },
  computed: {
    buttonText: function() {
      return this.loaded ? 'Login':'Loading...';
    }
  },
  methods : {
    submit() {
      if (this.loaded) {
          this.loaded = false;
          this.success = false;
          this.errors = {};
          axios.post(this.action, this.fields).then(response => {
              this.fields = {};
              this.loaded = true;
              this.success = true;
          }).catch(error => {
              this.loaded = true;
              if (error.response.status === 422 || error.response.status === 429) {
                  this.errors = error.response.data.errors || {};
              }
          })
      }
    }
  },
  watch: {
    success: function()
    {
      if (this.success === true) {
        window.location.href = '/';
      }
    }
  }
}
</script>