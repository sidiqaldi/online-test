<template>
  <layout :title="'Ikuti Ujian - ' + $page.app.name" active="participant.exams.form">
    <div class="alert alert-warning alert-dismissible fade show" role="alert" v-if="$page.errors.join && showError">
      <strong>Peringatan!</strong>
      {{ $page.errors.join[0] }}.
      <button
        aria-label="Close"
        class="close"
        type="button"
        @click="showError = false"
      >
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h2>{{ exam.data.name }}</h2>
        <p>oleh: {{ creator }}</p>
      </div>
    </div>
    <div class="row justify-content-md-center">
      <div class="col-md-6">
        <p>{{ exam.data.description }}</p>
      </div>
    </div>
    <div class="row justify-content-md-center">
      <div class="col-md-6">
        Pengaturan Ujian:
        <ul>
          <li>Waktu pengerjaan: <strong>{{ config.data.time_mode_text }} <span v-if="config.data.time_mode === 2">({{ config.data.time_limit }})</span></strong></li>
          <li>Urutan Pertanyaan : <strong>{{ config.data.question_order }}</strong></li>
          <li>Urutan jawaban : <strong>{{ config.data.answer_order }}</strong></li>
          <li>Menampilakan Hasil : <strong>{{ config.data.result_status }}</strong></li>
          <li>Menampilakan Ranking : <strong>{{ config.data.ranking_status }}</strong></li>
        </ul>
      </div>
    </div>
    <div class="row justify-content-center pt-5">
      <button class="btn btn-outline-secondary col-md-4 col-sm-8 col-8" @click="join">Mulai Ujian</button>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Layout/Exam";

export default {
  components: {
    Layout
  },
  props: {
    creator: String,
    exam: Object,
    config: Object,
  },
  data() {
    return {
      showError : false
    }
  },
  watch: {
    "$page.errors.join": {
      handler() {
        this.showError = true;
      },
      deep: true
    }
  },
  methods: {
    join() {
      this.$inertia.post(this.$route("participant.exams.join", this.exam.data.uuid));
    }
  }
};
</script>