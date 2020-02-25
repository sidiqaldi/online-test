 <template>
    <layout :title="'Reset Password -' + $page.app.name">
        <div class="row container justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Reset Password - {{ $page.app.name }}</div>
                    <div class="card-body">
                        <div v-if="$page.status" class="alert alert-success" role="alert">
                            {{ $page.status }}
                        </div>

                        <form @submit.prevent="submit">
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>
                                <div class="col-md-6">
                                    <input id="email"
                                        type="email"
                                        class="form-control"
                                        v-bind:class="{ 'is-invalid' : $page.errors.email }"
                                        name="email"
                                        v-model="form.email"
                                        required
                                        autocomplete="email">

                                    <span v-if="$page.errors.email" class="invalid-feedback" role="alert">
                                        <strong>{{ $page.errors.email[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                             <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input id="password"
                                        type="password"
                                        class="form-control"
                                        v-bind:class="{ 'is-invalid' : $page.errors.password }"
                                        name="password"
                                        v-model="form.password"
                                        required
                                        autocomplete="new-password">
                                    <span v-if="$page.errors.password" class="invalid-feedback" role="alert">
                                        <strong>{{ $page.errors.password[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Ulangi Password</label>
                                <div class="col-md-6">
                                    <input id="password-confirm"
                                        type="password"
                                        class="form-control"
                                        name="password_confirmation"
                                        v-model="form.password_confirmation"
                                        required
                                        autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-outline-secondary">
                                        Reset Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </layout>
</template>

<script>
  import Layout from './../../../Layout/Guest'

  export default {
    props: {
      token: Object
    },
    data() {
      return {
        form: {
          token: this.token,
          password: this.password,
          password_confirmation: this.password_confirmation,
        },
      }
    },
    components: {
      Layout,
    },
    methods: {
      submit() {
        this.$inertia.post(this.$route('password.update'), this.form)
      },
    },
  }
</script>
