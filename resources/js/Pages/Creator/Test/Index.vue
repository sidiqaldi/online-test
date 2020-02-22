 <template>
  <layout :title="'Halaman Penyelenggara - ' + $page.app.name" page="Daftar Ujian" active="creator.test.index">
    <p>Table will be here</p>
  </layout>
</template>

<script>
import Layout from "./../../../Layout/Dashboard";

export default {
  components: {
    Layout
  }
};
</script>
