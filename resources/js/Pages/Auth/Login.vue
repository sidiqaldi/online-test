 <template>
    <layout :title="'Masuk - ' + $page.app.name">
        <div class="row container justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Masuk - {{ $page.app.name }}</div>
                    <div class="card-body">
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
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                            type="checkbox"
                                            name="remember"
                                            id="remember"
                                            v-model="form.remember">
                                        <label class="form-check-label" for="remember">
                                            Ingatkan saya?
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-outline-secondary">
                                        Login
                                    </button>
                                    <a v-if="$route('password.request')" class="btn btn-link" :href="$route('password.request')">
                                        Lupa password?
                                    </a>
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
  import Layout from './../../Layout/Guest'

  export default {
    data() {
      return {
        form: {
          email: null,
          password: null,
          remembar: null,
        },
      }
    },
    components: {
      Layout,
    },
    methods: {
      submit() {
        this.$inertia.post(this.$route('login'), this.form)
      },
    },
  }
</script>
