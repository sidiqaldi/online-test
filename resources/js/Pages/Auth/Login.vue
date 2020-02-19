<template>
    <layout title="">
        <div class="row container justify-content-center">
            <inertia-link class="btn btn-outline-primary" :href="$route('dashboard')">Masuk dengan Google <font-awesome-icon class="mx-2" :icon="myIcon"/></inertia-link>
        </div>
    </layout>
</template>

<script>
  import Layout from './../../Layout/Guest'
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
  import { faGoogle } from '@fortawesome/free-brands-svg-icons'

  export default {
    data () {
      return {
        myIcon: faGoogle
      }
    },
    components: {
      Layout,
      FontAwesomeIcon,
    },

  }
</script>
