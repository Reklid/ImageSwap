<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-auto" style="margin: 20px">
        <b-form-file
            id="image_files"
            ref="image_files"
            :value="image_files"
            placeholder="Выберите или перетащите сюда файл..."
            drop-placeholder="Перетащите файл сюда..."
            accept=".jpg, .png, .gif, .svg"
            multiple=""
            browse-text="Обзор"
            @input="addFile($event)"
        />
      </div>
    </div>
    <div class="row justify-content-center">
      <div
          class="col-md-8"
          v-if="image_links.length > 0"
          v-for="(link, index) in image_links"
          style="margin: 2px">
        <a
            :key="index"
            :href="link">
          {{ link }}
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import { BButton, BFormFile } from 'bootstrap-vue'

export default {
  components: { BButton, BFormFile },
  data() {
    return {
      image_files: null,
      image_links: []
    }
  },
  methods: {
    addFile(file) {
      console.log(file)
      this.image_files = file

      this.upload()
    },

    upload() {
      const form = new FormData()
      const config = {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }

      for (let i = 0; i < this.image_files.length; i++) {
        const file = this.image_files[i]
        form.append('images[' + i + ']', file)
      }

      this.$http.post('/upload', form, config)
        .then(({ data }) => {
          this.image_links = data

          this.$toast.success('Картинки успешно сохранены')
        }).catch(resp => {
          this.$toast.error('Ошибка сохранение картинок')
        })
    }
  }
}
</script>
