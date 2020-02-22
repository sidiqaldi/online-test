<template>
  <div class="d-flex" id="wrapper" v-bind:class="{'toggled':sidebar}">
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading">
        <inertia-link class="navbar-brand" href="/">{{ $page.app.name }}</inertia-link>
      </div>
      <div class="list-group list-group-flush">
        <inertia-link
          :href="$route('dashboard')"
          class="list-group-item list-group-item-action"
          v-bind:class="{ 'active' : active == 'dashboard' }"
        >Dashboard</inertia-link>
        <a
          class="list-group-item list-group-item-action bg-light"
          data-toggle="collapse"
          data-target="#collapseCreator"
          aria-expanded="true"
          aria-controls="collapseCreator"
        >Penyelenggara</a>
        <div class="collapse" aria-labelledby="collapseCreator" id="collapseCreator">
          <inertia-link
            :href="$route('creator.tests.index')"
            class="list-group-item list-group-item-action"
            v-bind:class="{ 'active' : active == 'creator.test.index' }"
          >Daftar Ujian</inertia-link>
        </div>
        <a
          class="list-group-item list-group-item-action bg-light"
          data-toggle="collapse"
          data-target="#collapseParticipant"
          aria-expanded="false"
          aria-controls="collapseParticipant"
        >Peserta</a>
        <div class="collapse" aria-labelledby="collapseParticipant" id="collapseParticipant">
          <a href="#" class="list-group-item list-group-item-action bg-light">Ikut ujian</a>
          <a href="#" class="list-group-item list-group-item-action bg-light">Hasil</a>
        </div>
      </div>
    </div>

    <div id="page-content-wrapper">
      <nav class="navbar navbar-expand-md navbar-light py-3">
        <button class="btn btn-outline-secondary" id="menu-toggle" @click="sidebar = !sidebar">Menu</button>

        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto"></ul>
          <ul class="navbar-nav ml-auto my-2">
            <li class="nav-item"></li>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >{{ $page.auth.user.name }}</a>
              <div
                class="dropdown-menu dropdown-menu-right fade bg-light"
                aria-labelledby="navbarDropdown"
              >
                <a href="#" class="dropdown-item">Profil</a>
                <div class="dropdown-divider"></div>
                <logout-button class="dropdown-item" />
              </div>
            </li>
          </ul>
        </div>
      </nav>
      <div class="container-fluid">
        <h1 class="mt-4">{{ this.page }}</h1>
        <slot />
      </div>
    </div>
  </div>
</template>

<script>
import LogoutButton from "../components/LogoutButton";

export default {
  components: {
    LogoutButton
  },
  data() {
    return {
      sidebar: false
    };
  },
  props: {
    title: String,
    page: String,
    active: String
  },
  watch: {
    title: {
      immediate: true,
      handler(title) {
        document.title = title;
      }
    }
  },
  methods: {
    logout() {
      this.$inertia.post(this.$route("logout"), this.form);
    }
  }
};
</script>
