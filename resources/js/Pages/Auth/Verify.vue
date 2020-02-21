 <template>
    <layout title="">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Verify Your Email Address</div>

                        <div class="card-body">
                                <div v-if="$page.status" class="alert alert-success" role="alert">
                                    A fresh verification link has been sent to your email address.
                                </div>

                                Before proceeding, please check your email for a verification link.
                                If you did not receive the email, <a @click="submit" href="#">Click here to request another</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </layout>
</template>

<script>
  import Layout from './../../Layout/Dashboard'

  export default {
    components: {
      Layout,
    },
     methods: {
      submit() {
        this.$inertia.post(this.$route('verification.resend'), this.form)
      },
    },
  }
</script>

