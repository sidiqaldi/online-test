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
        <div class="col-md-6 pl-3">
            <label>Soal:</label>
            <div class="row">
                <div class="col-md-2 col-6 mb-2">
                    <select class="form-control" v-model="form.question.type" >
                        <option v-for="(type, index) in input_type" :value="index" :key="index">{{type}}</option>
                    </select>
                </div>
                 <div class="col-md-8">
                    <div class="form-group">
                        <textarea class="form-control mb-2" v-model="form.question.value"></textarea>
                        <input v-if="form.question.type == 2" type="text" class="form-control" v-model="form.question.image" placeholder="https://dummyimage.com/300x200/b8b8b8/fff.jpg">
                    </div>
                 </div>
            </div>
          <label>Pilihan jawaban:</label>
          <div v-for="(option, key) in form.options" :key="option.key" class="row mb-3">
            <div class="col-md-2 col-6 mb-2">
                <select class="form-control" v-model="option.type" >
                    <option v-for="(type, index) in input_type" :value="index" :key="index">{{type}}</option>
                </select>
            </div>
            <div class="col-md-8 col-8">
                <input v-if="option.type == 1" type="text" class="form-control" v-model="option.value"  placeholder="contoh: 112233aabb">
                <input v-else-if="option.type == 2" type="text" class="form-control" v-model="option.value"  placeholder="https://dummyimage.com/300x200/b8b8b8/fff.jpg">
            </div>
            <div class="col-md-2 col-4 row">
                <b-button-group size="sm">
                    <b-button :variant="answer == option.key ? 'success' : 'outline-secondary'" @click="correct(key)">{{ answer == option.key ? 'Benar' : 'Salah' }}</b-button>
                    <b-button variant="outline-secondary" @click.prevent="deleteOption(key)" type="button"><icon name="trash" /></b-button>
                </b-button-group>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
                <b-button v-if="form.options.length < 5" size="sm" class="col-10" variant="outline-secondary" @click.prevent="addOption"><icon name="plus"/>Tambah jawaban</b-button>
            </div>
          </div>
          <div class="row my-4">
            <div class="col-md-12">
              <button-loading :loading="sending" type="submit">Buat soal</button-loading>
            </div>
          </div>
        </div>
        <div class="col-md-6">
            <label>Preview:</label>
            <b-card class="col-auto mb-2">
                <vue-markdown class="result-html full-height" :watches="['markdown.show','markdown.html','markdown.breaks','markdown.linkify','markdown.emoji','markdown.typographer','markdown.toc']"
                  :source="form.question.value" :show="markdown.show" :html="markdown.html" :breaks="markdown.breaks" :linkify="markdown.linkify"
                  :emoji="markdown.emoji" :typographer="markdown.typographer" :toc="markdown.toc" toc-id="toc"></vue-markdown>
                <div v-if="form.question.type == 2" class="mb-3"><img :src="form.question.image"/></div>
                <ul>
                    <li v-for="(option, key) in form.options" :key="key" >
                        <img v-if="option.type == 2" :src="option.value" />
                        <span v-else >{{option.value}}</span>
                    </li>
                </ul>
            </b-card>

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
import VueMarkdown from 'vue-markdown'

export default {
  components: {
    Layout,
    InputText,
    InputTextarea,
    ButtonLoading,
    Icon,
    VueMarkdown,
  },
  props: {
    config: Object,
    exam: Object,
    section: Object,
    input_type: Object,
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
      answer: null,
      answerKey: null,
      form: {
        question: {
            type: 1,
            value: "",
            image: ""
        },
        options: []
      }
    };
  },
  methods: {
    correct(key) {
      let val = null
      if (this.answer !== null) this.setIsCorrect(this.answerKey, 0)
      this.setIsCorrect(key, 1)
    },
    setIsCorrect(key, val) {
      let form = this.form.options[key]
      form.is_correct = val
      Vue.set(this.form.options, key, form)
      this.answer = form.key
      this.answerKey = key
    },
    deleteOption(key) {
      if (this.answerKey == key) {
        this.answer = null
        this.answerKey = null
      }
      Vue.delete(this.form.options, key)
    },
    addOption() {
      this.form.options.push({
          key: Date.now(),
          value: '',
          type: 1,
          is_correct: 0,
      })
    },
    submit() {
      this.sending = true
      this.$inertia.post(this.$route("creator.exams.store"), this.form).then(() => this.sending = false)
    },
  }
};
</script>
