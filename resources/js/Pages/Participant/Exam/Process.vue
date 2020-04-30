<template>
  <layout :title="'Proses Ujian - ' + $page.app.name" active="participant.exams.form">
    ON PROGRESSS
    <b-card class="col-auto mb-2" v-if="question">
      <vue-markdown
        class="result-html full-height"
        :watches="['markdown.show','markdown.html','markdown.breaks','markdown.linkify','markdown.emoji','markdown.typographer','markdown.toc']"
        :source="question.value"
        :show="markdown.show"
        :html="markdown.html"
        :breaks="markdown.breaks"
        :linkify="markdown.linkify"
        :emoji="markdown.emoji"
        :typographer="markdown.typographer"
        :toc="markdown.toc"
        toc-id="toc"
      ></vue-markdown>
      <div v-if="question.type == 2" class="mb-3">
        <img class="img-fluid border" alt="preview" :src="question.image" @error="imgError" />
      </div>
    </b-card>

    <label class="col-12" v-for="(option, key) in options" :key="key">
        <b-card>
          <input type="radio" name="answer" :value="option.uuid" />

          <span>{{ alpha(key) }}.</span>

          <img
            class="img-fluid border"
            alt="preview"
            v-if="option.type == 2"
            :src="option.image"
            @error="imgError"
          />
          <span v-else>{{option.value}}</span>
        </b-card>
    </label>
  </layout>
</template>

<script>
import Layout from "@/Layout/Exam";
import InputText from "@/Shared/InputText";
import ButtonLoading from "@/Shared/ButtonLoading";
import VueMarkdown from "vue-markdown";

export default {
  components: {
    Layout,
    InputText,
    ButtonLoading,
    VueMarkdown
  },
  props: {
    config: Object,
    exam: Object,
    question: Object,
    options: Array,
    answers: Array
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
        code: null
      }
    };
  },
  methods: {
    alpha(key) {
      return String.fromCharCode("A".charCodeAt() + key);
    },
    details() {
      this.$inertia.post(
        this.$route("participant.exams.details.post"),
        this.form
      );
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
