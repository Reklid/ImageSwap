<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-auto" style="margin: 20px">
        <img :src="imagePath" alt="">
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-auto">
        <b-button
            variant="primary"
            @click="react">
          {{ buttonText }}
        </b-button>
      </div>
    </div>
  </div>
</template>

<script>
import { BButton, BFormFile } from 'bootstrap-vue'

export default {
  components: { BButton, BFormFile },
  props: {
    imageHash: {
      type: String,
      require: true
    },
    imagePath: {
      type: String,
      require: true
    },
    hasLike: {
      type: Boolean,
      require: true
    },
  },
  data() {
    return {
      hasLikeForText: this.hasLike,
    }
  },
  computed: {
    buttonText() {
      return this.hasLikeForText ? 'Dislike' : 'Like'
    }
  },
  methods: {
    react() {
      const currentUrl = window.location.pathname;
      const hash = currentUrl.replace('/', '');

      this.$http.post(`${hash}/react/${this.buttonText}`)
        .then(({ data }) => {
          this.hasLikeForText = data
        })
    }
  }
}
</script>
