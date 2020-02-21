 <template>
    <layout title="">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Dashboard</div>

                        <div class="card-body">
                            <div class="alert alert-success" role="alert">
                                {{ $page.auth.user.name }}
                            </div>
                            You are logged in!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </layout>
</template>

<script>
  import Layout from './../Layout/Dashboard'

  export default {
    components: {
      Layout,
    },
  }
</script>
