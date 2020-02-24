<template>
  <div class="d-flex" id="wrapper" v-bind:class="{'toggled':sidebar}">
    <sidebar :sidebar="sidebar" :active="active" />

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
      <div class="container-fluid px-4">
        <div class="my-4">
          <h1 class="d-inline">{{ this.page }}</h1>
          <slot name="buttons"></slot>
        </div>
        <slot />
      </div>
    </div>
  </div>
</template>

<script>
import LogoutButton from "../components/LogoutButton";
import Sidebar from "../components/Sidebar";

export default {
  components: {
    LogoutButton,
    Sidebar
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
