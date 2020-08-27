<template>
  <layout :title="'Edit Sesi Ujian - ' + $page.app.name"  active="creator.exams.index">
    <template v-slot:header>
      <h3 class="d-inline">
        <inertia-link :href="$route('creator.exams.index')" type="submit">Daftar Ujian</inertia-link>
        / <inertia-link :href="$route('creator.exams.edit', exam.uuid)" type="submit">{{ exam.name }}</inertia-link>
        / <inertia-link :href="$route('creator.sections.index', exam.uuid)" type="submit">Daftar Sesi</inertia-link>
        / Edit sesi
      </h3>
    </template>
    <form @submit.prevent="submit">
      <div class="row">
        <div class="col-md-6">
          <input-text class="form-group" v-model="form.name" :errors="$page.errors.name" label="Nama Sesi" :required="true" placeholder="contoh: Sesi 1 matematika dasar"/>
          <div class="form-group">
            <label>
              Instruksi: <span class="text-danger">*</span>
            </label>
            <textarea
              class="form-control mb-2"
              v-model="form.instruction"
              :class="{ 'is-invalid' : $page.errors.instruction }"
              placeholder="contoh: Pilihlah jawaban yang paling tepat"
            ></textarea>
            <span v-if="$page.errors.instruction" class="invalid-feedback" role="alert">
              <strong>{{ $page.errors.instruction[0] }}</strong>
            </span>
          </div>
          <input-text type="number" min="0" class="form-group" v-model="form.score_per_question" :errors="$page.errors.score_per_question" label="Nilai per soal" :required="true" placeholder="contoh: 10"/>
          <input-text type="number" min="0" class="form-group" v-model="form.passing_grade" :errors="$page.errors.passing_grade" label="Passing Grade" :required="true" placeholder="contoh: 100"/>
        </div>
        <div class="col-md-6">
          <label>Preview:</label>
          <b-card class="col-auto mb-2">
            <h4>{{ form.name }}</h4>
            <vue-markdown
              class="result-html full-height"
              :watches="['markdown.show','markdown.html','markdown.breaks','markdown.linkify','markdown.emoji','markdown.typographer','markdown.toc']"
              :source="this.preview"
              :show="markdown.show"
              :html="markdown.html"
              :breaks="markdown.breaks"
              :linkify="markdown.linkify"
              :emoji="markdown.emoji"
              :typographer="markdown.typographer"
              :toc="markdown.toc"
              toc-id="toc"
            ></vue-markdown>
          </b-card>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-md-12">
          <button-loading :loading="sending" class="btn btn-outline-secondary" type="submit">Update sesi</button-loading>
        </div>
      </div>
    </form>
  </layout>
</template>

<script>
import Layout from "@/Layout/Dashboard";
import InputText from "@/Shared/InputText";
import ButtonLoading from "@/Shared/ButtonLoading"
import VueMarkdown from "vue-markdown";

export default {
  components: {
    Layout,
    InputText,
    ButtonLoading,
    VueMarkdown
  },
  props: {
    exam: Object,
    config: Object,
    section: Object,
  },
  mounted() {
    this.form = this.section
  },
  computed: {
    preview: function () {
      return this.form.instruction == null ? '' : this.form.instruction
    }
  },
  data() {
    return {
      markdown: {
        show: true,
        html: false,
        breaks: true,
        linkify: false,
        emoji: true,
        typographer: true,
        toc: false
      },
      sending: false,
      form: {
        name: null,
        instruction: '',
        score_per_question: null,
        passing_grade: null,
      }
    };
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.put(this.$route("creator.sections.update", this.section.uuid), this.form).then(() => this.sending = false)
    }
  }
};
</script>
