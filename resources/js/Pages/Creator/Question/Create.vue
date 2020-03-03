<template>
  <layout :title="'Buat Ujian - ' + $page.app.name"  active="creator.exams.index">
    <template v-slot:header>
      <h3 class="d-inline">
        <inertia-link :href="$route('creator.exams.index')" type="submit">Daftar Ujian</inertia-link> /
        <inertia-link :href="$route('creator.exams.edit', exam.uuid)" type="submit">{{ exam.name }}</inertia-link> /
        <inertia-link :href="$route('creator.sections.index', exam.uuid)" type="submit">Daftar Seksi</inertia-link> /
        {{ section.name }} / Buat Soal
      </h3>
    </template>
    <form @submit.prevent="submit">
      <div class="row">
        <div class="col-md-6">
          <h4>Soal:</h4>
          <input-textarea v-model="form.question" />
          <input-text class="form-group" v-model="form.question" :errors="$page.errors.name" label="Nama Ujian" :required="true" placeholder="contoh: Ujian matematika dasar"/>
          <h4>Jawaban:</h4>
          <div v-for="(answer, key) in form.answers" :key="key" >
            <input-text class="input-group mb-3" v-model="answer.value" :errors="$page.errors.code" :required="true" placeholder="contoh: 112233aabb">
                <template v-slot:prepend>
                <div class="input-group-prepend">
                    <b-form-radio v-model="answer.is_correct" name="answersradio" :value="true"></b-form-radio>
                </div>
                </template>
                <template v-slot:append>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" @click.prevent="deleteAnswer(key)" type="button"><icon name="trash" /></button>
                    </div>
                </template>
            </input-text>
          </div>
          <b-button class="col-12" variant="outline-secondary" @click.prevent="addAnswer">Tambah jawaban</b-button>
        </div>
        <div class="col-md-6">
          <h4>Preview:</h4>
          <h4>Soal:</h4>
          <pre>{{ form.question }}</pre>
          <h4>Jawaban:</h4>
          <div v-for="(answer, key) in form.answers" :key="key" >
            <input-text class="input-group mb-3" v-model="answer.value" :errors="$page.errors.code" :required="true" placeholder="contoh: 112233aabb">
                <template v-slot:prepend>
                <div class="input-group-prepend">
                    <b-form-radio v-model="answer.is_correct" name="answersradio" :value="true"></b-form-radio>
                </div>
                </template>
                <template v-slot:append>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" @click.prevent="deleteAnswer(key)" type="button"><icon name="trash" /></button>
                    </div>
                </template>
            </input-text>
          </div>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-md-12">
          <button-loading :loading="sending" type="submit">Buat ujian</button-loading>
        </div>
      </div>
    </form>
  </layout>
</template>

<script>
import Layout from "@/Layout/Dashboard"
import InputText from "@/Shared/InputText"
import InputTextarea from "@/Shared/InputTextarea"
import ButtonLoading from "@/Shared/ButtonLoading"
import Icon from "@/Shared/Icon"

export default {
  components: {
    Layout,
    InputText,
    InputTextarea,
    ButtonLoading,
    Icon,
  },
  props: {
    config: Object,
    exam: Object,
    section: Object,
  },
  data() {
    return {
      sending: false,
      finds: [],
      form: {
        question: null,
        answers: []
      }
    };
  },
  methods: {
    deleteAnswer(key) {
      Vue.delete(this.form.answers, key)
    },
    addAnswer() {
      this.form.answers.push({
          value: '',
          is_correct: false,
      })
    },
    submit() {
      this.sending = true
      this.$inertia.post(this.$route("creator.exams.store"), this.form).then(() => this.sending = false)
    }
  }
};
</script>
