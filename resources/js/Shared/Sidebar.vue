<template>
  <div class="border-right" id="sidebar-wrapper">
    <div class="sidebar-heading d-none d-md-block d-sm-none">
      <inertia-link class="navbar-brand" href="/">{{ $page.app.name }}</inertia-link>
    </div>
    <div class="list-group list-group-flush">
      <inertia-link
        :href="$route('dashboard')"
        class="list-group-item list-group-item-action"
        v-bind:class="{ 'active' : active === 'dashboard' }"
      >Dashboard</inertia-link>
      <a class="list-group-item list-group-item-action list-group-item-secondary">Peserta</a>
      <inertia-link
        class="list-group-item list-group-item-action"
        v-bind:class="{ 'active' : active === 'participant.exams.form' }"
        :href="$route('participant.exams.form')"
      >Ikuti Ujian</inertia-link>
      <inertia-link
        class="list-group-item list-group-item-action"
        v-bind:class="{ 'active' : active === 'participant.results.index' }"
        :href="$route('participant.results.index')"
      >Hasil</inertia-link>
      <a class="list-group-item list-group-item-action list-group-item-secondary">Penyelenggara</a>
      <inertia-link
        class="list-group-item list-group-item-action"
        v-bind:class="{ 'active' : active === 'creator.exams.index' }"
        :href="$route('creator.exams.index')"
      >Daftar Ujian</inertia-link>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    sidebar: false,
    active: String
  }
};
</script>
