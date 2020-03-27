<template>
  <div class="d-flex" id="wrapper" v-bind:class="{'toggled':sidebar}">
    <sidebar :sidebar="sidebar" :active="active" />

    <div id="page-content-wrapper">
      <div
        class="container-fluid text-center text-white bg-secondary d-sm-block d-md-none"
      >{{ $page.app.name }}</div>
      <nav class="navbar navbar-expand navbar-light py-3">
        <button class="btn btn-outline-secondary" id="menu-toggle" @click="sidebar = !sidebar">Menu</button>

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
                <button-logout class="dropdown-item" />
              </div>
            </li>
          </ul>
        </div>
      </nav>
      <div class="container-fluid px-4">
        <flash-note />
        <div class="my-4">
          <slot name="header" />
          <div class="d-flex my-3">
            <slot name="buttons" />
          </div>
        </div>
        <slot />
      </div>
    </div>
  </div>
</template>

<script>
import ButtonLogout from "@/Shared/ButtonLogout";
import Sidebar from "@/Shared/Sidebar";
import FlashNote from "@/Shared/FlashNote";

export default {
  components: {
    ButtonLogout,
    FlashNote,
    Sidebar
  },
  data() {
    return {
      sidebar: false
    };
  },
  props: {
    title: String,
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
