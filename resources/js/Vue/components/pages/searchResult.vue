<template>
<div>
  <videos :videos="videos"><span></span></videos>
   <v-alert
      :value="true"
      type="success"
      v-if="videos.length == 0"
    >
      There are no data
    </v-alert>
    </div>
</template>
<script>
import ListOfVideo from "./listVideo.vue";
export default {
  components: {
    videos: ListOfVideo
  },
  data() {
    return {
      videos: []
    };
  },
  created() {
      let keyword = this.$route.params.keyword;

    this.$store
      .dispatch("videos/searchVideoByTitle",{title:keyword})
      .then(res => {
        this.videos = res.data.data.Videos;
        this.$nextTick();
      })
      .catch(err => {});

  }
};
</script>

