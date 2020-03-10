<template>
  <layout :title="'Ikuti Ujian - ' + $page.app.name" active="participant.exams.form">
    <template v-slot:header>
      <h3 class="d-inline">
        <inertia-link :href="$route('participant.exams.form')" type="submit">Ikuti Ujian</inertia-link>/
        {{ exam.data.name }}
      </h3>
    </template>
    <div class="row">
      <div class="col-md-6">
          <p><small>oleh: {{ creator }}</small></p>
          <p>{{ exam.data.description }}</p>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Layout/Dashboard";

export default {
  components: {
    Layout
  },
  props: {
    creator: String,
    exam : Object
  },
  methods: {
    join() {
      this.$inertia.post(this.$route("participant.exams.join", this.form));
    }
  }
};
</script>

<style scoped>
.section-title {
  cursor: pointer;
}
.flip-list-move {
  transition: transform 0.5s;
}
.no-move {
  transition: transform 0s;
}
.ghost {
  opacity: 0.5;
  background: #c8ebfb;
}
</style>>
