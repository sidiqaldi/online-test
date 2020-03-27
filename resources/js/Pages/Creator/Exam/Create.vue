<template>
  <layout :title="'Buat Ujian - ' + $page.app.name"  active="creator.exams.index">
    <template v-slot:header>
      <h3 class="d-inline">
        <inertia-link :href="$route('creator.exams.index')" type="submit">Daftar Ujian</inertia-link> / Buat baru
      </h3>
    </template>
    <form @submit.prevent="submit">
      <div class="row">
        <div class="col-md-6">
          <input-text class="form-group" v-model="form.name" :errors="$page.errors.name" label="Nama Ujian" :required="true" placeholder="contoh: Ujian matematika dasar"/>
          <input-text class="form-group" v-model="form.description" :errors="$page.errors.description" label="Deskripsi" :required="true" placeholder="contoh: Ujian matematika dasar tahun 2020"/>
          <input-text class="input-group mb-3" v-model="form.code" :errors="$page.errors.code" :required="true" placeholder="contoh: 112233aabb">
            <template v-slot:prepend>
              <div class="input-group-prepend">
                <label class="input-group-text" for="code">Kode ujian <span class="text-danger">*</span></label>
              </div>
            </template>
            <template v-slot:append>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" @click.prevent="generate" type="button">acak kode</button>
                </div>
            </template>
          </input-text>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-md-12">
          <button-loading :loading="sending" class="btn btn-outline-secondary" type="submit">Buat ujian</button-loading>
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
    random_question: Object
  },
  data() {
    return {
      sending: false,
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
      this.sending = true
      this.$inertia.post(this.$route("creator.exams.store"), this.form).then(() => this.sending = false)
    }
  }
};
</script>
