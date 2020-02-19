<template>
  <header>
        <nav class="navbar navbar-expand-md navbar-light">
            <div class="container py-4">
                <a class="navbar-brand" href="/">
                    Free Online Test
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item">
                            <inertia-link class="nav-link" :href="$route('login')">Masuk/Daftar</inertia-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container py-5">
            <slot />
        </div>
    </header>
</template>

<script>
  export default {
    props: {
      title: String,
    },
    watch: {
      title: {
        immediate: true,
        handler(title) {
          if(title) {
            document.title = title
          }
        },
      },
    },
  }
</script>
