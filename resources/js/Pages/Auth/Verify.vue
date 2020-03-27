 <template>
  <layout :title="'Verifikasi Alamat Email Anda - ' + $page.app.name">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">Verifikasi Alamat Email Anda</div>

            <div class="card-body">
              <div
                v-if="$page.status"
                class="alert alert-success"
                role="alert"
              >Link untuk verifikasi telah dikirm ke alamat email Anda.</div>
              <p>Sebelum melanjutkan, mohon periksa email anda untuk melakukan verifikasi.</p>
              <p>
                Jika anda tidak menerima email,
                <a @click="submit" href="#">Click untuk kirim ulang.</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from "./../../Layout/Dashboard";

export default {
  components: {
    Layout
  },
  methods: {
    submit() {
      this.$inertia.post(this.$route("verification.resend"), this.form);
    }
  }
};
</script>

