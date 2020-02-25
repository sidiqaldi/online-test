<template>
  <layout :title="'Buat Ujian - ' + $page.app.name" page="Buat Ujian" active="creator.exams.index">
    <form @submit.prevent="submit">
      <div class="row">
        <div class="col-md-6">
          <h2>Informasi umum</h2>
          <div class="form-group">
            <label for="name">
              Nama Ujian
              <span class="text-danger">*</span>
            </label>
            <input
              type="text"
              name="name"
              class="form-control"
              id="name"
              v-model="form.name"
              v-bind:class="{ 'is-invalid' : $page.errors.name }"
              placeholder="contoh: Ujian matematika dasar"
            />
            <span v-if="$page.errors.name" class="invalid-feedback" role="alert">
              <strong>{{ $page.errors.name[0] }}</strong>
            </span>
          </div>
          <div class="form-group">
            <label for="description">
              Deskripsi
              <span class="text-danger">*</span>
            </label>
            <input
              type="text"
              name="description"
              class="form-control"
              id="description"
              v-bind:class="{ 'is-invalid' : $page.errors.description }"
              v-model="form.description"
              placeholder="contoh: Ujian matematika dasar tahun 2020"
            />
            <span v-if="$page.errors.description" class="invalid-feedback" role="alert">
              <strong>{{ $page.errors.description[0] }}</strong>
            </span>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="code">
                Kode ujian
                <span class="text-danger">*</span>
              </label>
            </div>
            <label for="code"></label>
            <input
              type="text"
              class="form-control"
              placeholder="contoh: 112233aabb"
              aria-label="code"
              v-model="form.code"
              aria-describedby="code"
              v-bind:class="{ 'is-invalid' : $page.errors.code }"
            />
            <div class="input-group-append">
              <button
                class="btn btn-outline-secondary"
                @click.prevent="generate"
                type="button"
              >acak kode</button>
            </div>
            <span v-if="$page.errors.code" class="invalid-feedback" role="alert">
              <strong>{{ $page.errors.code[0] }}</strong>
            </span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <button type="submit" class="btn btn-outline-secondary">Buat ujian</button>
          <inertia-link
            :href="$route('creator.exams.index')"
            type="submit"
            class="btn btn-outline-secondary"
          >Kembali ke daftar ujian</inertia-link>
        </div>
      </div>
    </form>
  </layout>
</template>

<script>
import Layout from "./../../../Layout/Dashboard";

export default {
  components: {
    Layout
  },
  props: {
    random_question: Object
  },
  data() {
    return {
      form: {
        name: null,
        description: null,
        code: null
      }
    };
  },
  methods: {
    generate() {
      this.form.code = Math.random()
        .toString(36)
        .substring(3);
    },
    submit() {
      this.$inertia.post(this.$route("creator.exams.store"), this.form);
    }
  }
};
</script>
