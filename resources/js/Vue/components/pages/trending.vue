<template>
  <videos :videos="videos"><span></span></videos>
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
    this.$store
      .dispatch("videos/getVideos")
      .then(res => {
        this.videos = res.data.data.Videos;
        this.$nextTick();
      })
      .catch(err => {});
  }
};
</script>

