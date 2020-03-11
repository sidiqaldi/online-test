<template>
  <layout :title="'Edit Pertanyaan - ' + $page.app.name"  active="creator.exams.index">
    <template v-slot:header>
      <h3 class="d-inline">
        <inertia-link :href="$route('creator.exams.index')" type="submit">Daftar Ujian</inertia-link> /
        <inertia-link :href="$route('creator.exams.edit', exam.uuid)" type="submit">{{ exam.name }}</inertia-link> /
        <inertia-link :href="$route('creator.sections.index', exam.uuid)" type="submit">Daftar Sesi</inertia-link> /
        <inertia-link :href="$route('creator.questions.index', section.uuid)" type="submit">{{ section.name }}</inertia-link> /
        Edit Soal
      </h3>
    </template>
    <form @submit.prevent="submit">
      <div class="row">
        <div class="col-md-6 pl-3">
            <div class="row">
                <div class="col-md-2 col-6 mb-2">
                    <label>Tipe soal:</label>
                    <select class="form-control" v-model="form.question_type" >
                        <option v-for="(type, index) in input_type" :value="index" :key="index">{{type}}</option>
                    </select>
                </div>
                 <div class="col-md-8">
                    <div class="form-group">
                        <label>Judul: <span class="text-danger">*</span></label>
                        <input class="form-control mb-2" v-model="form.question_title"
                          :class="{ 'is-invalid' : $page.errors.question_title }" placeholder="contoh: Soal #1 tentang penjumlahan sederhana"/>
                        <span v-if="$page.errors.question_title" class="invalid-feedback" role="alert">
                          <strong>{{ $page.errors.question_title[0] }}</strong>
                        </span>
                        <small>digunakan untuk penanda soal, tidak akan ditampilkan ke peserta ujian</small>
                    </div>
                    <div class="form-group">
                        <label>Soal: <span class="text-danger">*</span></label>
                        <textarea class="form-control mb-2" v-model="form.question_value"
                          :class="{ 'is-invalid' : $page.errors.question_value }"
                          placeholder="contoh: Nilai dari penjumlahan 10cm + 10cm adalah..">
                        </textarea>
                        <span v-if="$page.errors.question_value" class="invalid-feedback" role="alert">
                          <strong>{{ $page.errors.question_value[0] }}</strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <input v-if="form.question_type == 2" type="text" class="form-control"
                          :class="{ 'is-invalid' : $page.errors.question_image }"
                          v-model="form.question_image"
                          placeholder="contoh: https://dummyimage.com/300x200/b8b8b8/fff.jpg">
                        <span v-if="$page.errors.question_image" class="invalid-feedback" role="alert">
                          <strong>{{ $page.errors.question_image[0] }}</strong>
                        </span>
                    </div>
                 </div>
            </div>
          <label>Pilihan jawaban: <span class="text-danger">*</span></label>
          <div v-for="(option, key) in form.options" :key="option.key" class="row mb-3">
            <div class="col-md-2 col-6 mb-2">
                <select class="form-control" v-model="option.type" >
                    <option v-for="(type, index) in input_type" :value="index" :key="index">{{type}}</option>
                </select>
            </div>
            <div class="col-md-8 col-8">
                <input v-if="option.type == 1" type="text" class="form-control"
                  :class="{ 'is-invalid' : $page.errors.options || $page.errors['options.'+key+'.value']}"
                  v-model="option.value"  placeholder="contoh: 120cm">
                <input v-else-if="option.type == 2" type="text" class="form-control"
                  :class="{ 'is-invalid' : $page.errors.options || $page.errors['options.'+key+'.image']}"
                  v-model="option.image"  placeholder="contoh: https://dummyimage.com/300x200/b8b8b8/fff.jpg">
                <span v-if="$page.errors.options" class="invalid-feedback" role="alert">
                    <strong>{{ $page.errors.options[0] }}</strong>
                </span>
                <span v-if="$page.errors['options.'+key+'.value']" class="invalid-feedback" role="alert">
                    <strong>{{ $page.errors['options.'+key+'.value'][0] }}</strong>
                </span>
                <span v-if="$page.errors['options.'+key+'.image']" class="invalid-feedback" role="alert">
                    <strong>{{ $page.errors['options.'+key+'.image'][0] }}</strong>
                </span>
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
                  :source="form.question_value" :show="markdown.show" :html="markdown.html" :breaks="markdown.breaks" :linkify="markdown.linkify"
                  :emoji="markdown.emoji" :typographer="markdown.typographer" :toc="markdown.toc" toc-id="toc"></vue-markdown>
                <div v-if="form.question_type == 2" class="mb-3"><img class="img-fluid border" alt="preview" :src="form.question_image" @error="imgError"/></div>
                <ul>
                    <li v-for="(option, key) in form.options" :key="key" >
                        <img class="img-fluid border" alt="preview" v-if="option.type == 2" :src="option.image" @error="imgError"/>
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
    question: Object,
    options: Array,
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
        question_value: "",
        question_type: 1,
        question_image: "",
        options: []
      }
    };
  },
  mounted() {
    this.form.question_value = this.question.value
    this.form.question_type = this.question.type
    this.form.question_image = this.question.image
    this.form.options = this.question.options
  },
  methods: {
    correct(key) {
      let val = null
      if (this.answer !== null) this.setIsCorrect(this.answerKey, 1)
      this.setIsCorrect(key, 2)
    },
    setIsCorrect(key, val) {
      let form = this.form.options[key]
      form.correct_id = val
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
          image: '',
          type: 1,
          correct_id: 1,
      })
    },
    imgError(e) {
        e.target.src = "/img/404.jpg"
    },
    submit() {
      this.sending = true
      this.$inertia.post(this.$route("creator.questions.store", this.section.uuid), this.form).then(() => this.sending = false)
    },
  }
};
</script>
