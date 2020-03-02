<template>
  <layout :title="'Buat Seksi Ujian - ' + $page.app.name"  active="creator.exams.index">
    <template v-slot:header>
      <h1 class="d-inline">
        <inertia-link :href="$route('creator.exams.index')" type="submit">Daftar Ujian</inertia-link> 
        / <inertia-link :href="$route('creator.sections.index', exam.uuid)" type="submit">Daftar Seksi</inertia-link> 
        / Buat baru
      </h1>
    </template>
    <form @submit.prevent="submit">
      <div class="row">
        <div class="col-md-6">
          <input-text class="form-group" v-model="form.name" :errors="$page.errors.name" label="Nama Seksi" :required="true" placeholder="contoh: Seksi matematika dasar"/>
          <input-text type="number" min="0" class="form-group" v-model="form.score_per_question" :errors="$page.errors.score_per_question" label="Nilai per soal" :required="true" placeholder="contoh: 10"/>
          <input-text type="number" min="0" class="form-group" v-model="form.passing_grade" :errors="$page.errors.passing_grade" label="Passing Grade" :required="true" placeholder="contoh: 100"/>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-md-12">
          <button-loading :loading="sending" type="submit">Tambahkan seksi</button-loading>
        </div>
      </div>
    </form>
  </layout>
</template>

<script>
import Layout from "@/Layout/Dashboard";
import InputText from "@/Shared/InputText";
import ButtonLoading from "@/Shared/ButtonLoading"

export default {
  components: {
    Layout,
    InputText,
    ButtonLoading
  },
  props: {
    exam: Object,
    config: Object
  },
  data() {
    return {
      sending: false,
      form: {
        name: null,
        score_per_question: null,
        passing_grade: null,
      }
    };
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.$route("creator.sections.store", this.exam.uuid), this.form).then(() => this.sending = false)
    }
  }
};
</script>
