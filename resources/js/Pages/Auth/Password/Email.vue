 <template>
  <layout :title="'Lupa Password - ' + $page.app.name">
    <div class="row container justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Lupa Password - {{ $page.app.name }}</div>
          <div class="card-body">
            <div v-if="$page.status" class="alert alert-success" role="alert">{{ $page.status }}</div>

            <form @submit.prevent="submit">
              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>
                <div class="col-md-6">
                  <input
                    id="email"
                    type="email"
                    class="form-control"
                    v-bind:class="{ 'is-invalid' : $page.errors.email }"
                    name="email"
                    v-model="form.email"
                    required
                    autocomplete="email"
                  />

                  <span v-if="$page.errors.email" class="invalid-feedback" role="alert">
                    <strong>{{ $page.errors.email[0] }}</strong>
                  </span>
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-outline-secondary">Kirim Link Reset Password</button>
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
import Layout from "./../../../Layout/Guest";

export default {
  props: {
    routesPasswordEmail: ""
  },
  data() {
    return {
      form: {
        email: null
      }
    };
  },
  components: {
    Layout
  },
  methods: {
    submit() {
      this.$inertia.post(this.routesPasswordEmail, this.form);
    }
  }
};
</script>
