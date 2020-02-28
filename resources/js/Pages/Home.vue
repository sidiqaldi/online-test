<template>
  <layout :title="'Halaman pengguna - ' + $page.app.name" page="Dashboard" active="dashboard">
    <div v-if="$page.status" class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>selamat datang! </strong> {{ $page.auth.user.name }}.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <p>You are logged in!</p>
  </layout>
</template>

<script>
import Layout from "./../Layout/Dashboard";

export default {
  components: {
    Layout
  }
};
</script>
